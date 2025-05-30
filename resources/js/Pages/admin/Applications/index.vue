<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Applications</h2>
      <!-- No Create button for applications -->
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.applications.data"
        :pagination="paginationProps"
        :loading="loading"
        :remote="true"
        :bordered="false"
        striped
        :scroll-x="2000" 
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
import { EyeOutline as ViewIcon, TrashOutline as DeleteIcon } from '@vicons/ionicons5';

const props = defineProps({
  applications: Object,
  filters: Object,
  errors: Object,
});

const loading = ref(false);

const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

const formatDate = (value) => {
  if (!value) return 'N/A';
  return new Date(value).toLocaleDateString(); // Or toLocaleString for date and time
};

const columns = computed(() => [
  { title: 'ID', key: 'id', width: 60, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  { title: 'Name', key: 'name', width: 150, sorter: true, sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false },
  { title: 'Surname', key: 'surname', width: 150, sorter: true, sortOrder: currentSortBy.value === 'surname' ? currentSortOrder.value : false },
  { title: 'Email', key: 'email', width: 200, sorter: true, sortOrder: currentSortBy.value === 'email' ? currentSortOrder.value : false },
  { title: 'Phone', key: 'phone', width: 130, sorter: true, sortOrder: currentSortBy.value === 'phone' ? currentSortOrder.value : false },
  { title: 'Country', key: 'country.name', width: 120, sorter: true, render: (row) => row.country?.name || 'N/A', sortOrder: currentSortBy.value === 'country.name' ? currentSortOrder.value : false },
  { title: 'Tour', key: 'tour.name', width: 180, sorter: true, render: (row) => row.tour?.name || 'N/A', sortOrder: currentSortBy.value === 'tour.name' ? currentSortOrder.value : false, ellipsis: {tooltip: true} },
  { title: 'Arrival', key: 'arrival', width: 120, sorter: true, render: (row) => formatDate(row.arrival), sortOrder: currentSortBy.value === 'arrival' ? currentSortOrder.value : false },
  { title: 'Departure', key: 'departure', width: 120, sorter: true, render: (row) => formatDate(row.departure), sortOrder: currentSortBy.value === 'departure' ? currentSortOrder.value : false },
  { title: 'Note', key: 'note', width: 200, ellipsis: { tooltip: true } },
  { title: 'IP', key: 'ip', width: 100, sorter: true, sortOrder: currentSortBy.value === 'ip' ? currentSortOrder.value : false },
  { 
    title: 'Submitted At', 
    key: 'created_at', 
    width: 170, 
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
            NPopconfirm,
            { 
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { icon: () => h(NIcon, null, { default: () => h(DeleteIcon) }), default: () => 'Delete' }),
              default: () => 'Are you sure you want to delete this application?',
            }
          ),
        ],
      });
    },
  },
]);

const paginationProps = computed(() => ({
  page: props.applications.current_page,
  pageSize: props.applications.per_page,
  itemCount: props.applications.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [10, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total applications`,
}));

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
  Inertia.get(route('admin.applications.index'), queryParams, {
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
  Inertia.delete(route('admin.applications.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onSuccess: () => { alert('Application deleted successfully!'); },
    onError: () => { alert('Failed to delete application.'); },
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