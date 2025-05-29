<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Tours Management</h2>
      <div class="space-x-2">
        <Link :href="route('admin.tours.create')">
          <n-button type="primary" class="bg-blue-500">Create Public Tour</n-button>
        </Link>
        <Link :href="route('admin.private_tours.create')">
          <n-button type="info" class="bg-teal-500">Create Private Tour</n-button>
        </Link>
      </div>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.tours.data"
        :pagination="tablePagination"
        :remote="true" 
        :bordered="false"
        striped
      />
    </n-card>
  </div>
</template>

<script setup>
import { h, computed } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NButton, NDataTable, NTag, NSpace, NPopconfirm, NCard } from 'naive-ui';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  tours: Object, 
});

const tablePagination = computed(() => ({
  page: props.tours.current_page,
  pageSize: props.tours.per_page,
  itemCount: props.tours.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [5, 10, 20, 50].map(size => ({ label: String(size), value: size })),
  // For remote pagination, you would handle these events:
  // onUpdatePage: (page) => { Inertia.get(props.tours.path, { page: page, perPage: props.tours.per_page }, { preserveState: true, replace: true }); },
  // onUpdatePageSize: (pageSize) => { Inertia.get(props.tours.path, { page: 1, perPage: pageSize }, { preserveState: true, replace: true }); }
}));

const columns = [
  { title: 'ID', key: 'id', sorter: true, width: 60 },
  { title: 'Name', key: 'name', sorter: true },
  {
    title: 'Type',
    key: 'isPublic',
    render(row) {
      return h(
        NTag,
        { type: row.isPublic ? 'success' : 'info', size: 'small' },
        { default: () => (row.isPublic ? 'Public' : 'Private') }
      );
    },
    filterOptions: [
        { label: 'Public', value: 1 },
        { label: 'Private', value: 0 },
    ],
    filter (value, row) {
        return row.isPublic == value;
    }
  },
  { title: 'Total Days', key: 'total_days', width: 100, sorter: true },
  { 
    title: 'Recommended', 
    key: 'recommended', 
    render(row) {
        return h(NTag, {type: row.recommended ? 'warning' : 'default', size: 'small'}, {default: () => row.recommended ? 'Yes' : 'No'})
    },
    width: 120
  },
  {
    title: 'Active',
    key: 'active',
    render(row) {
        return h(NTag, {type: row.active ? 'success' : 'error', size: 'small'}, {default: () => row.active ? 'Active' : 'Inactive'})
    },
    width: 100
  },
  { title: 'Viewed', key: 'viewed', width: 80, sorter: true },
  {
    title: 'Actions',
    key: 'actions',
    width: 150,
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(
            Link,
            {
              href: row.isPublic ? route('admin.tours.edit', row.id) : route('admin.private_tours.edit', row.id),
            },
            {
              default: () =>
                h(NButton, { type: 'primary', size: 'small', class: 'bg-blue-500' }, { default: () => 'Edit' }),
            }
          ),
          h(
            NPopconfirm,
            {
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600' }
            },
            {
              default: () => 'Are you sure you want to delete this tour?',
              trigger: () =>
                h(NButton, { type: 'error', size: 'small', class: 'bg-red-500' }, { default: () => 'Delete' }),
            }
          ),
        ],
      });
    },
  },
];

// Handle sorting and pagination changes for remote data
// This part would be needed if you want NDataTable to control server-side sorting/pagination
// Inertia.on('navigate', (event) => {
//   if (event.detail.page.component === 'admin/Tours/index') {
//     const urlParams = new URLSearchParams(window.location.search);
//     tablePagination.value.page = parseInt(urlParams.get('page') || '1');
//     tablePagination.value.pageSize = parseInt(urlParams.get('perPage') || props.tours.per_page);
//     // Add sorting state if needed
//   }
// });

const handleDelete = (tourId) => {
  Inertia.delete(route('admin.tours.destroy', tourId), {
    onFinish: () => {
      // Optional: show notification or refresh data if needed
    },
  });
};

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>