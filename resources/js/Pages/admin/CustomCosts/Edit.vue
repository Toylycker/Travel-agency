<template>
    <AdminLayout>
        <Head title="Edit Custom Cost" />
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6">Edit Custom Cost</h1>

            <form @submit.prevent="submit" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" v-model="form.name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                </div>

                <div class="flex justify-end space-x-2">
                    <Link :href="route('admin.custom-costs.index')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</Link>
                    <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    customCost: Object,
});

const form = useForm({
    name: props.customCost.name,
    description: props.customCost.description,
});

function submit() {
    form.put(route('admin.custom-costs.update', props.customCost.id));
}
</script> 