<template>
    <AdminLayout>
        <Head :title="`Custom Cost: ${customCost.name}`" />
        <div class="container mx-auto p-4">
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">{{ customCost.name }}</h1>
                <p class="text-gray-700 mb-2"><strong>ID:</strong> {{ customCost.id }}</p>
                <p class="text-gray-700 mb-4"><strong>Description:</strong> {{ customCost.description }}</p>
                
                <div v-if="customCost.costs && customCost.costs.length > 0">
                    <h2 class="text-xl font-semibold mt-6 mb-3">Associated Costs:</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li v-for="cost in customCost.costs" :key="cost.id">
                            {{ cost.name }} - ${{ cost.cost }} (For {{ cost.number_of_people }} people)
                        </li>
                    </ul>
                </div>
                 <div v-else>
                    <p class="text-gray-500 mt-4">No specific costs are directly associated with this custom cost category yet.</p>
                </div>

                <div class="mt-6">
                    <Link :href="route('admin.custom-costs.edit', customCost.id)" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 mr-2">Edit</Link>
                    <Link :href="route('admin.custom-costs.index')" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">Back to List</Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    customCost: Object, // Expects customCost with 'costs' relation loaded
});
</script> 