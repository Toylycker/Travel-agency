<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Messages</h2>
      <!-- Add Create button if applicable -->
      <!-- <Link :href="route('admin.messages.create')">
        <n-button type="primary" class="bg-blue-500 hover:bg-blue-600">New Message</n-button>
      </Link> -->
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.messages.data"
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
import { NDataTable, NButton, NSpace, NCard, NPopconfirm, NTooltip, NIcon } from 'naive-ui';
// Example icons, adjust as needed
import { EyeOutline as ViewIcon, TrashOutline as DeleteIcon } from '@vicons/ionicons5';

const props = defineProps({
  messages: Object,
  filters: Object, // For consistency, even if not immediately used for filtering messages
});

const loading = ref(false);

// --- Sorting ---
const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

// --- Columns ---
const columns = computed(() => [
  { title: 'ID', key: 'id', width: 80, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  { title: 'Email', key: 'email', width: 250, sorter: true, sortOrder: currentSortBy.value === 'email' ? currentSortOrder.value : false },
  {
    title: 'Message',
    key: 'message',
    ellipsis: { tooltip: true },
    // You might want a custom renderer if messages are very long or contain HTML
    // render(row) {
    //   return h(NTooltip, null, {
    //     trigger: () => h('span', row.message.substring(0, 50) + (row.message.length > 50 ? '...' : '')),
    //     default: () => h('div', { style: 'max-width: 400px; white-space: pre-wrap;' }, row.message),
    //   });
    // }
  },
  { title: 'Received At', key: 'created_at', width: 180, sorter: true, sortOrder: currentSortBy.value === 'created_at' ? currentSortOrder.value : false, 
    render: (row) => new Date(row.created_at).toLocaleString() 
  },
  {
    title: 'Actions',
    key: 'actions',
    width: 150,
    fixed: 'right',
    render(row) {
      return h(NSpace, null, {
        default: () => [
          // Add View button if there is a show page for messages
          // h(
          //   Link,
          //   { href: route('admin.messages.show', row.id) }, 
          //   { default: () => h(NButton, { type: 'info', size: 'small', class:'bg-blue-500 hover:bg-blue-600' }, { icon: () => h(NIcon, null, { default: () => h(ViewIcon) }), default: () => 'View' }) }
          // ),
          h(
            NPopconfirm,
            { 
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { icon: () => h(NIcon, null, { default: () => h(DeleteIcon) }), default: () => 'Delete' }),
              default: () => 'Are you sure you want to delete this message?',
            }
          ),
        ],
      });
    },
  },
]);

// --- Pagination ---
const paginationProps = computed(() => ({
  page: props.messages.current_page,
  pageSize: props.messages.per_page,
  itemCount: props.messages.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [10, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total messages`,
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
  // Add other filters if any (e.g., search by email)
  // if (activeFilters?.email) params.email = activeFilters.email;
  return params;
};

const fetchData = (page, pageSize, sortBy, sortOrder, activeFilters) => {
  const queryParams = getQueryParams(page, pageSize, sortBy, sortOrder, activeFilters);
  loading.value = true;
  Inertia.get(route('admin.messages.index'), queryParams, {
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
  Inertia.delete(route('admin.messages.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onFinish: () => { loading.value = false; },
    onSuccess: () => { alert('Message deleted successfully!'); }
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