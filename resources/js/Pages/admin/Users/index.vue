<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Users Management</h2>
      <Link :href="route('admin.users.create')">
        <n-button type="primary" class="bg-blue-500 hover:bg-blue-600">Create User</n-button>
      </Link>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.users.data"
        :pagination="paginationProps"
        :loading="loading"
        :remote="true"
        :bordered="false"
        striped
        @update:page="handlePageChange"
        @update:page-size="handlePageSizeChange"
        @update:sorter="handleSortChange"
      />
    </n-card>
  </div>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag } from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon } from '@vicons/ionicons5';

const props = defineProps({
    users: Object,    // Paginated user data
    filters: Object,  // For sorting and potential future filtering
    errors: Object,
});

const loading = ref(false);

// --- Sorting ---
const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

// --- Columns ---
const columns = computed(() => [
  { title: 'ID', key: 'id', width: 80, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  { title: 'Name', key: 'name', sorter: true, sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false },
  { title: 'Email', key: 'email', sorter: true, sortOrder: currentSortBy.value === 'email' ? currentSortOrder.value : false },
  {
    title: 'Role',
    key: 'role', // Assuming a 'role' field exists on the user object
    width: 120,
    sorter: true, // If backend supports sorting by role
    sortOrder: currentSortBy.value === 'role' ? currentSortOrder.value : false,
    render(row) {
      // Basic role display, can be enhanced with NTag and colors based on role value
      return row.role ? h(NTag, { type: 'info', size: 'small' }, { default: () => row.role }) : 'N/A';
    }
  },
  {
    title: 'Created At',
    key: 'created_at',
    width: 180,
    sorter: true,
    sortOrder: currentSortBy.value === 'created_at' ? currentSortOrder.value : false,
    render: (row) => new Date(row.created_at).toLocaleString()
  },
  {
    title: 'Actions',
    key: 'actions',
    width: 180,
    fixed: 'right',
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(
            Link,
            { href: route('admin.users.edit', row.id) }, 
            { default: () => h(NButton, { type: 'primary', size: 'small', class:'bg-yellow-500 hover:bg-yellow-600' }, { icon: () => h(NIcon, null, {default: () => h(EditIcon)}), default: () => 'Edit' }) }
          ),
          h(
            NPopconfirm,
            { 
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { icon: () => h(NIcon, null, { default: () => h(DeleteIcon) }), default: () => 'Delete' }),
              default: () => 'Are you sure you want to delete this user?',
            }
          ),
        ],
      });
    },
  },
]);

// --- Pagination ---
const paginationProps = computed(() => ({
  page: props.users.current_page,
  pageSize: props.users.per_page,
  itemCount: props.users.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [10, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total users`,
}));

// --- Data Fetching Logic ---
const getQueryParams = (page, pageSize, sortBy, sortOrder, activeFilters = props.filters) => {
  let params = { page: page, perPage: pageSize };
  if (sortBy) {
    params.sort_by = sortBy;
    if (sortOrder === 'ascend' || sortOrder === 'asc') params.sort_order = 'asc';
    else if (sortOrder === 'descend' || sortOrder === 'desc') params.sort_order = 'desc';
    else if (params.sort_by) params.sort_order = 'asc';
  }
  return params;
};

const fetchData = (page, pageSize, sortBy, sortOrder, activeFilters) => {
  const queryParams = getQueryParams(page, pageSize, sortBy, sortOrder, activeFilters);
  loading.value = true;
  Inertia.get(route('admin.users.index'), queryParams, {
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
  fetchData(1, pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleSortChange = (sorter) => {
  currentSortBy.value = sorter.columnKey;
  currentSortOrder.value = sorter.order || false;
  fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.users.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onSuccess: () => { alert('User deleted successfully!'); },
    onError: () => { alert('Failed to delete user.'); },
    onFinish: () => { loading.value = false; },
  });
};

watch(() => props.filters, (newFilters) => {
  currentSortBy.value = newFilters?.sort_by || 'id';
  currentSortOrder.value = newFilters?.sort_order || 'desc';
}, { deep: true, immediate: true });

watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    alert('There were errors with your submission.');
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