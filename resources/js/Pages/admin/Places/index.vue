<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Places Management</h2>
      <n-button type="primary" @click="openCreateDrawer" class="bg-blue-500 hover:bg-blue-600">Create Place</n-button>
    </div>

    <PlaceFormDrawer
      v-model:show="showDrawer"
      :is-edit="isEditing"
      :place-data="editingPlaceData"
      :locations="locations"
      :categories="categories"
      :errors="currentFormErrors"
      @submit="handleFormSubmit"
    />

    <!-- Data Table -->
    <n-card class="mt-4">
      <n-data-table
        :columns="columns"
        :data="places.data"
        :pagination="paginationReactive"
        :remote="true"
        :bordered="true"
        striped
        @update:page="handlePageChange"
        @update:page-size="handlePageSizeChange" 
      />
    </n-card>
  </div>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3'; // useForm is not directly used here anymore
import { Inertia } from '@inertiajs/inertia';
import {
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NTag,
} from 'naive-ui';
// import Pagination from '@/Shared/Pagination.vue'; // Removed custom pagination
import PlaceFormDrawer from '@/Components/admin/Places/PlaceFormDrawer.vue';

const props = defineProps({
  places: Object, // Paginated places (e.g., from Laravel Paginator)
  locations: Array,
  categories: Array,
  errors: Object, // Global errors from session flash
  filters: Object, // To preserve existing filters/query params
});

const showDrawer = ref(false);
const isEditing = ref(false);
const editingPlaceData = ref(null);
const currentFormErrors = ref({}); // To pass to the drawer

const paginationReactive = computed(() => ({
  page: props.places.current_page,
  pageSize: props.places.per_page,
  itemCount: props.places.total,
  // showSizePicker: true, // Optional: if you want to allow changing page size
  // pageSizes: [10, 15, 20, 50] // Optional: page size options
}));

const handlePageChange = (page) => {
  Inertia.get(route('admin.places.index'), {
    ...props.filters, // spread existing filters/query params
    page: page,
    per_page: props.places.per_page // keep current page size
  }, {
    preserveState: true,
    replace: true,
  });
};

const handlePageSizeChange = (pageSize) => {
    Inertia.get(route('admin.places.index'), {
        ...props.filters, // spread existing filters/query params
        page: 1, // Reset to first page when page size changes
        per_page: pageSize,
    }, {
        preserveState: true,
        replace: true,
    });
};

const openCreateDrawer = () => {
  isEditing.value = false;
  editingPlaceData.value = null;
  currentFormErrors.value = {};
  showDrawer.value = true;
};

const openEditDrawer = (placeData) => {
  isEditing.value = true;
  editingPlaceData.value = { ...placeData };
  currentFormErrors.value = {};
  showDrawer.value = true;
};

const handleFormSubmit = (formData) => {
  const options = {
    preserveScroll: true,
    onSuccess: () => {
      showDrawer.value = false;
      alert(isEditing.value ? 'Place updated successfully!' : 'Place created successfully!');
      Inertia.reload({ 
          only: ['places'],
          data: { page: props.places.current_page, per_page: props.places.per_page, ...props.filters }, // Ensure current page is reloaded
          preserveState: (page) => Object.keys(page.props.errors).length > 0, // Preserve state if there are errors
      }); 
    },
    onError: (pageErrors) => {
      currentFormErrors.value = pageErrors;
    },
    forceFormData: true, // Crucial for file uploads
  };

  let url;
  if (isEditing.value) {
    url = route('admin.places.update', editingPlaceData.value.id);
    Inertia.post(url, formData, options);
  } else {
    url = route('admin.places.store');
    Inertia.post(url, formData, options);
  }
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.places.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
        alert('Place deleted successfully!');
        Inertia.reload({ 
            only: ['places'],
            data: { page: props.places.current_page, per_page: props.places.per_page, ...props.filters },
            preserveState: false, // Don't preserve state on successful delete, reload fresh data
        });
    },
    onError: () => {
        alert('Failed to delete place.');
    },
  });
};

watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    // console.log("Global errors:", newErrors);
  }
}, { immediate: true, deep: true });

const createColumns = () => [
  { title: 'Id', key: 'id', sorter: 'default' },
  { title: 'Name', key: 'name', sorter: 'default' },
  {
    title: 'Location',
    key: 'location.name',
    render(row) {
      return row.location?.name || 'N/A';
    }
  },
  {
    title: 'Categories',
    key: 'categories',
    render(row) {
      if (!row.categories || row.categories.length === 0) return 'N/A';
      return h(
        NSpace,
        { vertical: true, size: 'small' },
        {
          default: () => row.categories.map(category => 
            h(NTag, { type: 'info', size: 'small', bordered: true }, { default: () => category.name })
          )
        }
      );
    }
  },
  {
    title: 'Body',
    key: 'body',
    ellipsis: { tooltip: true }, 
    width: 150 
  },
  {
    title: 'Texts Count',
    key: 'texts',
    render(row) {
      return row.texts ? row.texts.length : 0;
    }
  },
  { title: 'Meta Title', key: 'meta_title', ellipsis: { tooltip: true }, width: 150 },
  { title: 'Meta Keywords', key: 'meta_keywords', ellipsis: { tooltip: true }, width: 150 },
  { title: 'Meta Description', key: 'meta_description', ellipsis: { tooltip: true }, width: 200 },
  { title: 'Viewed', key: 'viewed', sorter: 'default' },
  {
    title: 'Recommended',
    key: 'recommended',
    render(row) {
      return h(
        NTag,
        { type: row.recommended ? 'success' : 'error', size: 'small' },
        { default: () => (row.recommended ? 'Yes' : 'No') }
      );
    },
    sorter: (a, b) => a.recommended - b.recommended
  },
  {
    title: 'Actions',
    key: 'actions',
    render(row) {
      return h(
        NSpace,
        null,
        {
          default: () => [
            h(
              NButton,
              {
                type: 'primary',
                class: 'bg-info',
                size: 'small',
                onClick: () => openEditDrawer(row)
              },
              { default: () => 'Edit' }
            ),
            h(
              NPopconfirm,
              { onPositiveClick: () => handleDelete(row.id) },
              {
                trigger: () => h(NButton, { type: 'error', class: 'bg-danger', size: 'small' }, { default: () => 'Delete' }),
                default: () => 'Are you sure you want to delete this place?'
              }
            )
          ]
        }
      );
    }
  }
];

const columns = createColumns();

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>

<style scoped>
/* Add any specific styles if needed */
</style>