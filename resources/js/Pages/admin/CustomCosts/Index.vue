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
                            :pagination="paginationReactive"
                            :bordered="false"
                            striped
                            remote
                            @update:page="handlePageChange"
                        />
                    </n-card>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { h, reactive, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { NDataTable, NButton, NSpace } from 'naive-ui';

const props = defineProps({
    customCosts: Object,
});

const page = usePage();

const columns = [
    { title: 'ID', key: 'id', sorter: 'default' },
    { title: 'Name', key: 'name', sorter: 'default' },
    { title: 'Description', key: 'description' },
    {
        title: 'Actions',
        key: 'actions',
        render(row) {
            return h(NSpace, null, {
                default: () => [
                    h(
                        Link,
                        {
                            href: route('admin.custom-costs.edit', row.id),
                            class: 'btn btn-sm btn-warning me-2'
                        },
                        { default: () => 'Edit' }
                    ),
                    h(
                        Link,
                        {
                            href: route('admin.costs.create', { costable_type: 'App\\Models\\CustomCost', costable_id: row.id }),
                            class: 'btn btn-sm btn-info me-2'
                        },
                        { default: () => 'Add Cost' }
                    ),
                    h(
                        NButton,
                        {
                            strong: true,
                            tertiary: true,
                            size: 'small',
                            type: 'error',
                            class: 'btn btn-sm btn-danger',
                            onClick: () => deleteCustomCost(row.id),
                        },
                        { default: () => 'Delete' }
                    ),
                ],
            });
        },
    },
];

const paginationReactive = computed(() => ({
    page: props.customCosts.current_page,
    pageSize: props.customCosts.per_page,
    itemCount: props.customCosts.total,
    showSizePicker: false, // Optional: if you want to allow changing page size
    // pageSizes: [10, 20, 50], // Optional: page size options
}));

function handlePageChange(currentPage) {
    Inertia.get(route('admin.custom-costs.index', { page: currentPage }), {}, { preserveState: true, replace: true });
}

// function handlePageSizeChange(pageSize) {
//     Inertia.get(route('admin.custom-costs.index', { per_page: pageSize }), {}, { preserveState: true, replace: true });
// }

function deleteCustomCost(id) {
    if (confirm('Are you sure you want to delete this custom cost?')) {
        Inertia.delete(route('admin.custom-costs.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                // Flash message is handled by the template
            },
        });
    }
}
</script>

<style scoped>
/* You can add Bootstrap specific overrides here if Naive UI conflicts */
.btn-warning {
    color: #000;
}
</style> 