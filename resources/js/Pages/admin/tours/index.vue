<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Tours Management</h2>
      <div class="space-x-2">
        <Link :href="route('admin.tours.create')">
          <n-button type="primary" class="bg-blue-500 hover:bg-blue-600">Create Public Tour</n-button>
        </Link>
        <Link :href="route('admin.private_tours.create')">
          <n-button type="info" class="bg-teal-500 hover:bg-teal-600">Create Private Tour</n-button>
        </Link>
      </div>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.tours.data"
        :pagination="paginationProps"
        :remote="true"
        :bordered="false"
        :scroll-x="2200" 
        striped
        @update:page="handlePageChange"
        @update:page-size="handlePageSizeChange"
        @update:sorter="handleSortChange"
        @update:filters="handleFilterChange"
      />
    </n-card>
  </div>
</template>

<script setup>
import { h, computed, ref, watch } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NButton, NDataTable, NTag, NSpace, NPopconfirm, NCard, NTooltip, NIcon } from 'naive-ui';
import { CheckmarkCircleOutline as CheckIcon, CloseCircleOutline as CloseIcon, EllipsisHorizontal as MoreIcon } from '@vicons/ionicons5';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  tours: Object, 
  filters: Object,
});

const formatDateTime = (value) => {
  if (!value) return 'N/A';
  return new Date(value).toLocaleString();
};

const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

const paginationProps = computed(() => ({
  page: props.tours.current_page,
  pageSize: props.tours.per_page,
  itemCount: props.tours.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [5, 10, 15, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total tours`,
}));

const booleanFilterOptions = [
    { label: 'Yes', value: 1 },
    { label: 'No', value: 0 },
];

const activeFilterOptions = [
    { label: 'Active', value: 1 }, 
    { label: 'Inactive', value: 0 },
];

const columns = ref([
  { title: 'ID', key: 'id', width: 60, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  {
    title: 'Name', 
    key: 'name', 
    width: 200, 
    sorter: true, 
    sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false,
    ellipsis: { tooltip: true }
  },
  {
    title: 'Type',
    key: 'isPublic',
    width: 90,
    render(row) {
      return h(
        NTag,
        { type: row.isPublic ? 'success' : 'info', size: 'small' },
        { default: () => (row.isPublic ? 'Public' : 'Private') }
      );
    },
    filterOptions: booleanFilterOptions,
    filter: true,
    filterOptionValue: props.filters?.isPublic !== undefined && props.filters?.isPublic !== null ? Number(props.filters.isPublic) : null,
  },
  {
    title: 'Active',
    key: 'active',
    width: 90,
    render(row) {
        return h(NIcon, { size: 20, color: row.active ? '#18a058' : '#d03050' }, {
            default: () => row.active ? h(CheckIcon) : h(CloseIcon)
        });
    },
    filterOptions: activeFilterOptions,
    filter: true,
    filterOptionValue: props.filters?.active !== undefined && props.filters?.active !== null ? Number(props.filters.active) : null,
  },
  {
    title: 'Rec.',
    key: 'recommended',
    width: 80,
    render(row) {
      return h(NIcon, { size: 20, color: row.recommended ? '#f0a020' : '#ccc' }, {
            default: () => row.recommended ? h(CheckIcon) : h(CloseIcon)
        });
    },
    filterOptions: booleanFilterOptions,
    filter: true,
    filterOptionValue: props.filters?.recommended !== undefined && props.filters?.recommended !== null ? Number(props.filters.recommended) : null,
  },
  { title: 'Sort Order', key: 'sort_order', width: 100, sorter: true, sortOrder: currentSortBy.value === 'sort_order' ? currentSortOrder.value : false },
  { title: 'Name CN', key: 'name_cn', width: 200, ellipsis: { tooltip: true } },
  {
    title: 'Map',
    key: 'map',
    width: 80,
    render(row) {
        return row.map ? h(NTooltip, null, { trigger: () => h(NIcon, { size: 20}, {default: () => h(MoreIcon)}), default: () => row.map }) : 'N/A';
    }
  },
  {
    title: 'Main Image',
    key: 'main_image',
    width: 120,
    render(row) {
        return row.main_image ? h('img', { src: `/storage/tours/${row.main_image}`, class: 'h-10 w-auto object-cover rounded' }) : 'N/A';
    }
  },
  { title: 'Body', key: 'body', width: 250, ellipsis: { tooltip: true } },
  { title: 'Body CN', key: 'body_cn', width: 250, ellipsis: { tooltip: true } },
  { title: 'Total Days', key: 'total_days', width: 100, sorter: true, sortOrder: currentSortBy.value === 'total_days' ? currentSortOrder.value : false },
  { title: 'Base Price Text', key: 'tour_prices', width: 150, ellipsis: { tooltip: true } },
  { title: 'Discount %', key: 'discount_percent', width: 100 },
  { title: 'Disc. Start', key: 'discount_datetime_start', width: 170, render: (row) => formatDateTime(row.discount_datetime_start) },
  { title: 'Disc. End', key: 'discount_datetime_end', width: 170, render: (row) => formatDateTime(row.discount_datetime_end) }, 
  { title: 'Viewed', key: 'viewed', width: 80, sorter: true, sortOrder: currentSortBy.value === 'viewed' ? currentSortOrder.value : false },
  { title: 'Liked', key: 'liked', width: 80 },
  {
    title: 'Actions',
    key: 'actions',
    width: 130,
    fixed: 'right',
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
                h(NButton, { type: 'primary', size: 'small', class: 'bg-blue-500 hover:bg-blue-600' }, { default: () => 'Edit' }),
            }
          ),
          h(
            NPopconfirm,
            {
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              default: () => 'Are you sure you want to delete this tour?',
              trigger: () =>
                h(NButton, { type: 'error', size: 'small', class: 'bg-red-500 hover:bg-red-600' }, { default: () => 'Delete' }),
            }
          ),
        ],
      });
    },
  },
]);

const getQueryParams = (page, pageSize, sortBy, sortOrder, activeFiltersFromProps) => {
    let params = { page: page, perPage: pageSize };

    if (sortBy) {
        params.sort_by = sortBy;
        if (sortOrder === 'ascend' || sortOrder === 'asc') params.sort_order = 'asc';
        else if (sortOrder === 'descend' || sortOrder === 'desc') params.sort_order = 'desc';
        else if (params.sort_by) params.sort_order = 'asc';
    }

    if (activeFiltersFromProps) {
        for (const key in activeFiltersFromProps) {
            if (key === 'page' || key === 'perPage' || key === 'sort_by' || key === 'sort_order') continue;

            const value = activeFiltersFromProps[key];
            const isBooleanLikeFilter = ['isPublic', 'active', 'recommended'].includes(key);

            // Add filter if value is not null/undefined.
            // For boolean-like filters, 0 is a valid value.
            // For other filters, ensure it's not an empty string.
            if (value !== null && value !== undefined) {
                if (isBooleanLikeFilter) {
                    params[key] = Number(value); // Ensure 0 is passed as a number
                } else if (String(value).length > 0) {
                    params[key] = value;
                }
            } 
            // If value is null (filter cleared), it won't be added to params, 
            // which means backend won't filter by it.
        }
    }
    return params;
};

const fetchData = (page, pageSize, sortBy, sortOrder, activeFilters) => {
    const queryParams = getQueryParams(page, pageSize, sortBy, sortOrder, activeFilters);
    Inertia.get(route('admin.tours.index'), queryParams, {
        preserveState: true, 
        replace: true, 
        preserveScroll: true
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

    columns.value = columns.value.map(col => {
        if (col.key === sorter.columnKey) {
            return { ...col, sortOrder: currentSortOrder.value };
        } else if (col.sorter) {
             return { ...col, sortOrder: false };
        }
        return col;
    });

    fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleFilterChange = (filters) => {
    let newFilters = { ...props.filters };
    for (const columnKey in filters) {
        newFilters[columnKey] = filters[columnKey];
    }
    fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, newFilters);
};

const handleDelete = (tourId) => {
  Inertia.delete(route('admin.tours.destroy', tourId), {
    onSuccess: () => { /* router.reload({ only: ['tours'] }); */ },
  });
};

watch(() => props.filters, (newFilters) => {
    currentSortBy.value = newFilters?.sort_by || 'id';
    currentSortOrder.value = newFilters?.sort_order || 'desc';
    columns.value = columns.value.map(col => {
        let updatedCol = { ...col };
        if (updatedCol.sorter) {
            updatedCol.sortOrder = updatedCol.key === currentSortBy.value ? currentSortOrder.value : false;
        }
        
        if (updatedCol.filter && newFilters) {
            const filterValue = newFilters[updatedCol.key];
            if (filterValue === null || filterValue === undefined || filterValue === '') { // Consider empty string as null for filter tick
                updatedCol.filterOptionValue = null;
            } else {
                updatedCol.filterOptionValue = Number(filterValue); // For boolean-like, this gets 0 or 1
                 // For other filter types if they were numeric. If not, this might need adjustment based on filter type
            }
        }
        return updatedCol;
    });
}, { deep: true, immediate: true });

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>