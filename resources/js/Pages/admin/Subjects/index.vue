<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Subjects Management</h2>
      <n-button type="primary" @click="showCreateDrawer = true" class="bg-blue-500 hover:bg-blue-600">Create Subject</n-button>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="editableSubjects"
        :pagination="false"
        :bordered="false"
        striped
      />
    </n-card>

    <n-drawer v-model:show="showCreateDrawer" :width="502">
      <n-drawer-content title="Create Subject" closable>
        <n-form ref="createFormRef" :model="createFormModel">
          <n-form-item path="name" label="Name">
            <n-input v-model:value="createFormModel.name" placeholder="Enter name" />
          </n-form-item>
          <n-form-item path="name_cn" label="Name CN">
            <n-input v-model:value="createFormModel.name_cn" placeholder="Enter name in Chinese" />
          </n-form-item>
          <n-form-item path="subject_id" label="Parent Subject ID (Optional)">
            <n-input-number v-model:value="createFormModel.subject_id" clearable placeholder="Optional Parent ID" />
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
    NDrawer, NDrawerContent, NInput, NInputNumber, NForm, NFormItem
} from 'naive-ui';
import { TrashOutline as DeleteIcon } from '@vicons/ionicons5';

const props = defineProps({
    subjects: Array, // Assuming subjects is an array
    errors: Object,
});

const showCreateDrawer = ref(false);
const createFormRef = ref(null);

const editableSubjects = ref([]);
onMounted(() => {
  editableSubjects.value = JSON.parse(JSON.stringify(props.subjects));
});
watch(() => props.subjects, (newSubjects) => {
    editableSubjects.value = JSON.parse(JSON.stringify(newSubjects));
}, { deep: true });

const createFormModel = useForm({
  name: null,
  name_cn: null,
  subject_id: null,
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
          editableSubjects.value[index].name = v;
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
          editableSubjects.value[index].name_cn = v;
        }
      });
    }
  },
  // { title: 'Parent/Subject ID', key: 'subject_id' }, // Display if needed, non-editable in this setup
  {
    title: 'Actions',
    key: 'actions',
    width: 220,
    fixed: 'right',
    render(row, index) {
      return h(NSpace, null, {
        default: () => [
          h(NButton, {
            type: 'primary',
            size: 'small',
            class:'bg-green-500 hover:bg-green-600',
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
              default: () => 'Are you sure you want to delete this subject?',
            }
          ),
        ],
      });
    },
  },
]);

const handleCreateSubmit = () => {
  createFormModel.post(route('admin.subjects.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showCreateDrawer.value = false;
      createFormModel.reset();
      alert('Subject created successfully!');
      Inertia.visit(route('admin.subjects.index'), { preserveState: false });
    },
    onError: (formErrors) => {
      let errorText = 'Failed to create subject.';
      if (formErrors && Object.keys(formErrors).length > 0) {
        errorText += " Details: " + JSON.stringify(formErrors);
      }
      alert(errorText);
    },
  });
};

const handleUpdate = (rowData) => {
  const dataToUpdate = {
    name: rowData.name,
    name_cn: rowData.name_cn,
    subject_id: rowData.subject_id, // Assuming subject_id might be updated if present
  };
  Inertia.put(route('admin.subjects.update', rowData.id), dataToUpdate, {
    preserveScroll: true,
    onSuccess: () => {
      alert('Subject updated successfully!');
    },
    onError: (errors) => {
      let errorText = 'Failed to update subject.';
      if (errors && Object.keys(errors).length > 0) {
        errorText += " Details: " + JSON.stringify(errors);
      }
      alert(errorText);
    }
  });
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.subjects.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
      alert('Subject deleted successfully!');
      editableSubjects.value = editableSubjects.value.filter(subject => subject.id !== id);
    },
    onError: () => { alert('Failed to delete subject.'); },
  });
};

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