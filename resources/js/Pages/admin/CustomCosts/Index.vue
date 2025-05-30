<template>
    <AdminLayout>
        <Head title="Custom Costs" />
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1>Custom Costs</h1>
                        <Link :href="route('admin.custom-costs.create')" class="btn btn-primary">
                            Create Custom Cost
                        </Link>
                    </div>

                    <div v-if="$page.props?.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $page.props.flash.success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <n-card title="Custom Costs List">
                        <n-data-table
                            :columns="columns"
                            :data="customCosts.data"
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
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon } from 'naive-ui';

const props = defineProps({
    customCosts: Object,
    filters: Object, // Assuming filters will be passed like in Tours/index.vue
});

const page = usePage();
const loading = ref(false); // For table loading state

// --- Sorting ---
const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

// --- Columns ---
const columns = computed(() => [
    { title: 'ID', key: 'id', width: 80, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
    { title: 'Name', key: 'name', width: 250, sorter: true, sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false },
    { title: 'Description', key: 'description', ellipsis: { tooltip: true } },
    {
        title: 'Actions',
        key: 'actions',
        width: 220,
        fixed: 'right',
        render(row) {
            return h(NSpace, null, {
                default: () => [
                    h(
                        Link,
                        { href: route('admin.custom-costs.edit', row.id) },
                        { default: () => h(NButton, { type: 'primary', size: 'small', class:'bg-yellow-500 hover:bg-yellow-600' }, { default: () => 'Edit' }) }
                    ),
                    h(
                        Link,
                        { href: route('admin.costs.create', { costable_type: 'App\\Models\\CustomCost', costable_id: row.id }) },
                        { default: () => h(NButton, { type: 'info', size: 'small', class:'bg-teal-500 hover:bg-teal-600' }, { default: () => 'Add Cost' }) }
                    ),
                    h(
                        NPopconfirm,
                        { 
                            onPositiveClick: () => handleDelete(row.id),
                            positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
                        },
                        {
                            trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { default: () => 'Delete' }),
                            default: () => 'Are you sure you want to delete this custom cost?',
                        }
                    ),
                ],
            });
        },
    },
]);

// --- Pagination ---
const paginationProps = computed(() => ({
    page: props.customCosts.current_page,
    pageSize: props.customCosts.per_page,
    itemCount: props.customCosts.total,
    pageSlot: 7,
    showSizePicker: true,
    pageSizes: [5, 10, 15, 20, 50, 100].map(size => ({ label: String(size), value: size })),
    prefix: ({ itemCount }) => `${itemCount} total items`,
}));

// --- Data Fetching Logic ---
const getQueryParams = (page, pageSize, sortBy, sortOrder, activeFilters = props.filters) => {
    let params = { page: page, perPage: pageSize };
    if (sortBy) {
        params.sort_by = sortBy;
        if (sortOrder === 'ascend' || sortOrder === 'asc') params.sort_order = 'asc';
        else if (sortOrder === 'descend' || sortOrder === 'desc') params.sort_order = 'desc';
        else if (params.sort_by) params.sort_order = 'asc'; // Default to asc if order not specified but sort_by is
    }
    // Add other filters if any (similar to Tours/index.vue)
    // Example: if (activeFilters?.name) params.name = activeFilters.name;
    return params;
};

const fetchData = (page, pageSize, sortBy, sortOrder, activeFilters) => {
    const queryParams = getQueryParams(page, pageSize, sortBy, sortOrder, activeFilters);
    loading.value = true;
    Inertia.get(route('admin.custom-costs.index'), queryParams, {
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
    Inertia.delete(route('admin.custom-costs.destroy', id), {
        preserveScroll: true,
        onStart: () => { loading.value = true; },
        onFinish: () => { loading.value = false; },
        onSuccess: () => { alert('Custom cost deleted successfully!'); }
    });
};

// Watch for props.filters changes to update sorting indicators if filters are applied externally
watch(() => props.filters, (newFilters) => {
    currentSortBy.value = newFilters?.sort_by || 'id';
    currentSortOrder.value = newFilters?.sort_order || 'desc';
    // The columns are already a computed property that references these, so they will update automatically.
}, { deep: true, immediate: true });
</script>

<style scoped>
/* You can add Bootstrap specific overrides here if Naive UI conflicts */
.btn-warning {
    color: #000;
}
</style> 