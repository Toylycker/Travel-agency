<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Places Management</h2>
      <n-button type="primary" @click="openCreateDrawer" class="bg-blue-500 hover:bg-blue-600">Create Place</n-button>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.places.data"
        :pagination="paginationProps"
        :loading="loading"
        :remote="true"
        :bordered="false"
        striped
        :scroll-x="1800"
        @update:page="handlePageChange"
        @update:page-size="handlePageSizeChange"
        @update:sorter="handleSortChange"
      />
    </n-card>

    <n-drawer v-model:show="showDrawer" :width="600">
      <n-drawer-content :title="drawerTitle" closable>
        <n-form ref="formRef" :model="formModel" :rules="formRules">
          <n-form-item path="name" label="Name">
            <n-input v-model:value="formModel.name" placeholder="Enter name" />
          </n-form-item>
          <n-form-item path="location_id" label="Location">
            <n-select
              v-model:value="formModel.location_id"
              placeholder="Select location"
              :options="locationOptions"
              clearable
            />
          </n-form-item>
           <n-form-item path="category_ids" label="Categories">
            <n-select
              v-model:value="formModel.category_ids"
              placeholder="Select categories"
              :options="categoryOptions"
              multiple
              clearable
            />
          </n-form-item>
          <n-form-item path="body" label="Body">
            <n-input type="textarea" v-model:value="formModel.body" placeholder="Enter body content" />
          </n-form-item>
          <n-form-item path="meta_title" label="Meta Title">
            <n-input v-model:value="formModel.meta_title" placeholder="Enter meta title" />
          </n-form-item>
          <n-form-item path="meta_description" label="Meta Description">
            <n-input type="textarea" v-model:value="formModel.meta_description" placeholder="Enter meta description" />
          </n-form-item>
          <n-form-item label="Recommended">
            <n-switch v-model:value="formModel.recommended" />
          </n-form-item>
          <!-- Add main_image and additional_images file inputs if needed -->
        </n-form>
        <template #footer>
          <n-button @click="showDrawer = false" class="mr-2">Cancel</n-button>
          <n-button type="primary" @click="handleFormSubmit" :loading="formModel.processing">Submit</n-button>
        </template>
      </n-drawer-content>
    </n-drawer>

  </div>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import {
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag, NTooltip,
    NDrawer, NDrawerContent, NInput, NSelect, NForm, NFormItem, NSwitch
} from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon } from '@vicons/ionicons5';

const props = defineProps({
  places: Object,
  filters: Object,
  locations: Array, // For location select options
  categories: Array, // For category select options
  errors: Object, // For form errors
});

const loading = ref(false);
const showDrawer = ref(false);
const isEditing = ref(false);
const formRef = ref(null); // For form validation access

const defaultFormValues = {
  id: null,
  name: null,
  location_id: null,
  category_ids: [],
  body: null,
  recommended: false,
  meta_title: null,
  meta_description: null,
  // main_image: null,
  // additional_images: [],
};

const formModel = useForm({ ...defaultFormValues });

const drawerTitle = computed(() => isEditing.value ? 'Edit Place' : 'Create Place');

const locationOptions = computed(() =>
  props.locations ? props.locations.map(loc => ({ label: loc.name, value: loc.id })) : []
);
const categoryOptions = computed(() =>
  props.categories ? props.categories.map(cat => ({ label: cat.name, value: cat.id })) : []
);


// Basic validation rules, extend as needed
const formRules = {
  name: [{ required: true, message: 'Name is required', trigger: 'blur' }],
  location_id: [{ type: 'number', required: true, message: 'Location is required', trigger: 'change' }],
};

const openCreateDrawer = () => {
  isEditing.value = false;
  formModel.reset();
  // formModel.clearErrors(); // Clear previous errors
  showDrawer.value = true;
};

const openEditDrawer = (place) => {
  isEditing.value = true;
  formModel.reset(); // Reset to defaults first
  formModel.id = place.id;
  formModel.name = place.name;
  formModel.location_id = place.location_id;
  formModel.category_ids = place.categories ? place.categories.map(c => c.id) : [];
  formModel.body = place.body;
  formModel.recommended = !!place.recommended;
  formModel.meta_title = place.meta_title;
  formModel.meta_description = place.meta_description;
  // formModel.clearErrors();
  showDrawer.value = true;
};

const handleFormSubmit = async () => {
  formRef.value?.validate(errors => {
    if (!errors) {
      if (isEditing.value) {
        formModel.put(route('admin.places.update', formModel.id), {
          preserveScroll: true,
          onSuccess: () => {
            showDrawer.value = false;
            alert('Place updated successfully!');
            // Inertia.reload({ only: ['places'] }); // Or rely on controller to return updated data
          },
          onError: () => {
            alert('Failed to update place. Please check errors.');
          }
        });
      } else {
        formModel.post(route('admin.places.store'), {
          preserveScroll: true,
          onSuccess: () => {
            showDrawer.value = false;
            alert('Place created successfully!');
            // Inertia.reload({ only: ['places'] });
          },
          onError: () => {
            alert('Failed to create place. Please check errors.');
          }
        });
      }
    } else {
      console.log('Form validation failed:', errors);
      alert('Please correct the form errors.');
    }
  });
};


const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

const columns = computed(() => [
  { title: 'ID', key: 'id', width: 60, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  { title: 'Name', key: 'name', width: 200, sorter: true, sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false, ellipsis: { tooltip: true } },
  {
    title: 'Location',
    key: 'location.name',
    width: 150,
    sorter: true, // Assuming backend supports sorting by location.name
    sortOrder: currentSortBy.value === 'location.name' ? currentSortOrder.value : false,
    render: (row) => row.location?.name || 'N/A',
    ellipsis: { tooltip: true }
  },
  {
    title: 'Categories',
    key: 'categories',
    width: 200,
    render(row) {
      if (!row.categories || row.categories.length === 0) return 'N/A';
      return h(NSpace, { vertical: true, size: 'small' }, {
        default: () => row.categories.map(cat => h(NTag, { type: 'info', size: 'small', bordered: true }, { default: () => cat.name }))
      });
    }
  },
  { title: 'Body', key: 'body', width: 250, ellipsis: { tooltip: true } },
  { title: 'Viewed', key: 'viewed', width: 80, sorter: true, sortOrder: currentSortBy.value === 'viewed' ? currentSortOrder.value : false },
  {
    title: 'Recommended',
    key: 'recommended',
    width: 120,
    sorter: true,
    sortOrder: currentSortBy.value === 'recommended' ? currentSortOrder.value : false,
    render(row) {
      return h(NTag, { type: row.recommended ? 'success' : 'error', size: 'small' }, { default: () => (row.recommended ? 'Yes' : 'No') });
    }
  },
  { title: 'Meta Title', key: 'meta_title', width: 200, ellipsis: { tooltip: true } },
  {
    title: 'Actions',
    key: 'actions',
    width: 180, // Adjusted width for two buttons
    fixed: 'right',
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(NButton, {
            type: 'primary',
            size: 'small',
            class:'bg-yellow-500 hover:bg-yellow-600',
            onClick: () => openEditDrawer(row)
          }, { icon: () => h(NIcon, null, {default: () => h(EditIcon)}), default: () => 'Edit' }),
          h(
            NPopconfirm,
            {
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { icon: () => h(NIcon, null, { default: () => h(DeleteIcon) }), default: () => 'Delete' }),
              default: () => 'Are you sure you want to delete this place?',
            }
          ),
        ],
      });
    },
  },
]);

const paginationProps = computed(() => ({
  page: props.places.current_page,
  pageSize: props.places.per_page,
  itemCount: props.places.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [10, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total places`,
}));

const getQueryParams = (page, pageSize, sortBy, sortOrder, activeFilters = props.filters) => {
  let params = { page: page, perPage: pageSize };
  if (sortBy) {
    params.sort_by = sortBy;
    if (sortOrder === 'ascend' || sortOrder === 'asc') params.sort_order = 'asc';
    else if (sortOrder === 'descend' || sortOrder === 'desc') params.sort_order = 'desc';
    else if (params.sort_by) params.sort_order = 'asc';
  }
  // Include other filters if they are implemented
  // e.g., if (activeFilters?.name) params.name = activeFilters.name;
  return params;
};

const fetchData = (page, pageSize, sortBy, sortOrder, activeFilters) => {
  const queryParams = getQueryParams(page, pageSize, sortBy, sortOrder, activeFilters);
  loading.value = true;
  Inertia.get(route('admin.places.index'), queryParams, {
    preserveState: true,
    replace: true,
    preserveScroll: true,
    onFinish: () => { loading.value = false; }
  });
};

const handlePageChange = (page) => {
  fetchData(page, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handlePageSizeChange = (pageSize) => {
  fetchData(1, pageSize, currentSortBy.value, currentSortOrder.value, props.filters); // Reset to page 1
};

const handleSortChange = (sorter) => {
  currentSortBy.value = sorter.columnKey;
  currentSortOrder.value = sorter.order || false; // Naive UI gives false if sorter is removed
  fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters); // Reset to page 1
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.places.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; }, // Optional: manage loading state
    onSuccess: () => {
        alert('Place deleted successfully!');
        // Optionally force a reload if the list doesn't update automatically
        // Inertia.reload({ only: ['places'] });
    },
    onError: () => {
        alert('Failed to delete place.');
    },
    onFinish: () => { loading.value = false; },
  });
};

watch(() => props.filters, (newFilters) => {
  currentSortBy.value = newFilters?.sort_by || 'id';
  currentSortOrder.value = newFilters?.sort_order || 'desc';
}, { deep: true });

watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    // Assign errors to formModel if they are form-specific
    // formModel.clearErrors(); // Clear old errors
    // Object.keys(newErrors).forEach(key => {
    //   formModel.setError(key, newErrors[key]);
    // });
    // For now, just showing a generic alert
    alert('There were errors with your submission. Please check the form.');
  }
}, { immediate: true, deep: true });

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>

<style scoped>
/* Add any specific styles if needed */
</style>