<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Notes Management</h2>
      <n-button type="primary" @click="showCreateDrawer = true" class="bg-blue-500 hover:bg-blue-600">Create Note</n-button>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="editableNotes"
        :pagination="false"
        :bordered="false"
        striped
      />
    </n-card>

    <n-drawer v-model:show="showCreateDrawer" :width="502">
      <n-drawer-content title="Create Note" closable>
        <n-form ref="createFormRef" :model="createFormModel">
          <n-form-item path="name" label="Name">
            <n-input v-model:value="createFormModel.name" placeholder="Enter name" />
          </n-form-item>
          <n-form-item path="name_cn" label="Name CN">
            <n-input v-model:value="createFormModel.name_cn" placeholder="Enter name in Chinese" />
          </n-form-item>
        </n-form>
        <template #footer>
          <n-button @click="showCreateDrawer = false" class="mr-2">Cancel</n-button>
          <n-button type="primary" @click="handleCreateSubmit" :loading="createFormModel.processing">Submit</n-button>
        </template>
      </n-drawer-content>
    </n-drawer>
  </div>
</template>

<script setup>
import { h, ref, computed, watch, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import {
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon,
    NDrawer, NDrawerContent, NInput, NForm, NFormItem
} from 'naive-ui';
import { TrashOutline as DeleteIcon } from '@vicons/ionicons5'; // Removed EditIcon as edit is inline

const props = defineProps({
    notes: Array, // Assuming notes is an array of note objects
    errors: Object,
});

const showCreateDrawer = ref(false);
const createFormRef = ref(null);

// Create a deep copy of props.notes for local editing
const editableNotes = ref([]);
onMounted(() => {
  editableNotes.value = JSON.parse(JSON.stringify(props.notes));
});
watch(() => props.notes, (newNotes) => {
    editableNotes.value = JSON.parse(JSON.stringify(newNotes));
}, { deep: true });


const createFormModel = useForm({
  name: null,
  name_cn: null,
});

const columns = ref([
  { title: 'ID', key: 'id', width: 80 },
  {
    title: 'Name',
    key: 'name',
    render(row, index) {
      return h(NInput, {
        value: row.name,
        onUpdateValue(v) {
          editableNotes.value[index].name = v;
        }
      });
    }
  },
  {
    title: 'Name CN',
    key: 'name_cn',
    render(row, index) {
      return h(NInput, {
        value: row.name_cn,
        onUpdateValue(v) {
          editableNotes.value[index].name_cn = v;
        }
      });
    }
  },
  {
    title: 'Actions',
    key: 'actions',
    width: 220, // Adjusted width
    fixed: 'right',
    render(row, index) {
      return h(NSpace, null, {
        default: () => [
          h(NButton, {
            type: 'primary',
            size: 'small',
            class:'bg-green-500 hover:bg-green-600', // Update button style
            onClick: () => handleUpdate(row)
          }, { default: () => 'Update' }),
          h(
            NPopconfirm,
            {
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { icon: () => h(NIcon, null, { default: () => h(DeleteIcon) }), default: () => 'Delete' }),
              default: () => 'Are you sure you want to delete this note?',
            }
          ),
        ],
      });
    },
  },
]);

const handleCreateSubmit = () => {
  createFormModel.post(route('admin.notes.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showCreateDrawer.value = false;
      createFormModel.reset();
      alert('Note created successfully!');
      // No need to manually refresh data if preserveState: false (or similar) is used or if Inertia handles it.
      // If a full refresh is needed: Inertia.reload({ only: ['notes'] });
      // For simplicity, we rely on Inertia's default behavior or a full page visit if needed.
      // Setting preserveState to false to ensure data is fresh
       Inertia.visit(route('admin.notes.index'), { preserveState: false });
    },
    onError: (formErrors) => {
      let errorText = 'Failed to create note.';
      if (formErrors && Object.keys(formErrors).length > 0) {
        errorText += " Details: " + JSON.stringify(formErrors);
      }
      alert(errorText);
    },
  });
};

const handleUpdate = (rowData) => {
  // Find the original row data to compare if needed, or just send all.
  // For simplicity, sending all editable fields.
  const dataToUpdate = {
    name: rowData.name,
    name_cn: rowData.name_cn,
    // include other fields from rowData if they are part of the update
  };
  Inertia.put(route('admin.notes.update', rowData.id), dataToUpdate, {
    preserveScroll: true,
    onSuccess: () => {
      alert('Note updated successfully!');
      // Optionally, refresh if the backend doesn't return the updated list
      // Or find and update the row in editableNotes if backend returns single updated item.
      // For now, assuming success means UI is in sync or will be refreshed by a visit.
      // A visit might be too disruptive for inline edit, consider just updating local state
      // if backend confirms success and returns the updated object.
    },
    onError: (errors) => {
      let errorText = 'Failed to update note.';
      if (errors && Object.keys(errors).length > 0) {
        errorText += " Details: " + JSON.stringify(errors);
      }
      alert(errorText);
      // Potentially revert changes in editableNotes[index] if update fails
      // This requires knowing the original state or re-fetching.
      // For now, we keep the UI as is and let the user retry or refresh.
    }
  });
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.notes.destroy', id), {
    preserveScroll: true, // Might be false if you want to reset scroll
    onSuccess: () => {
        alert('Note deleted successfully!');
        // Remove the item from local state to update UI immediately
        editableNotes.value = editableNotes.value.filter(note => note.id !== id);
    },
    onError: () => { alert('Failed to delete note.'); },
  });
};

// Watch for props.errors to display general submission errors
watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    let errorText = 'There were errors with your submission.';
      if (newErrors && Object.keys(newErrors).length > 0) {
        errorText += " Details: " + JSON.stringify(newErrors);
      }
      alert(errorText);
  }
}, { immediate: true });

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>

<style scoped>
/* Add any specific styles if needed */
</style>