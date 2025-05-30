<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Places Management</h2>
      <Link :href="route('admin.places.create')">
        <n-button type="primary" class="bg-blue-500 hover:bg-blue-600">Create Place</n-button>
      </Link>
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
  </div>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag, NTooltip } from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon } from '@vicons/ionicons5';

const props = defineProps({
  places: Object,
  filters: Object,
});

const loading = ref(false);

const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

const columns = computed(() => [
  { title: 'ID', key: 'id', width: 60, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  { title: 'Name', key: 'name', width: 200, sorter: true, sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false, ellipsis: { tooltip: true } },
  {
    title: 'Location',
    key: 'location.name',
    width: 150,
    sorter: true,
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
    width: 150,
    fixed: 'right',
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(
            Link,
            { href: route('admin.places.edit', row.id) }, 
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
  fetchData(1, pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleSortChange = (sorter) => {
  currentSortBy.value = sorter.columnKey;
  currentSortOrder.value = sorter.order || false;
  fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.places.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onFinish: () => { loading.value = false; },
  });
};

watch(() => props.filters, (newFilters) => {
  currentSortBy.value = newFilters?.sort_by || 'id';
  currentSortOrder.value = newFilters?.sort_order || 'desc';
}, { deep: true, immediate: true });

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>

<style scoped>
/* Add any specific styles if needed */
</style>