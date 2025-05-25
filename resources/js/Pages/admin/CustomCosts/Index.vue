<template>
    <AdminLayout>
        <Head title="Custom Costs" />
        <div class="container mx-auto p-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Custom Costs</h1>
                <Link :href="route('admin.custom-costs.create')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Create Custom Cost
                </Link>
            </div>

            <div v-if="$page.props?.flash?.success" class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ $page.props.flash.success }}
            </div>

            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="customCost in customCosts.data" :key="customCost.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ customCost.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ customCost.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">{{ customCost.description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <Link :href="route('admin.custom-costs.edit', customCost.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                <button @click="deleteCustomCost(customCost.id)" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                        <tr v-if="customCosts.data.length === 0">
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No custom costs found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="customCosts.links" class="mt-6" />
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import Pagination from '@/Shared/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    customCosts: Object,
});

const page = usePage();

function deleteCustomCost(id) {
    if (confirm('Are you sure you want to delete this custom cost?')) {
        Inertia.delete(route('admin.custom-costs.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                // Can show a toast or rely on flash message
            },
        });
    }
}
</script> 