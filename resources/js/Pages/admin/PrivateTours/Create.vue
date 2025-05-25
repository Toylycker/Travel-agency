<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Create Private Tour</h1>
        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" v-model="form.name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
            </div>

            <div>
                <label for="name_cn" class="block text-sm font-medium text-gray-700">Name (Chinese)</label>
                <input type="text" v-model="form.name_cn" id="name_cn" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.name_cn" class="text-red-500 text-sm mt-1">{{ form.errors.name_cn }}</div>
            </div>

            <div>
                <label for="main_image" class="block text-sm font-medium text-gray-700">Main Image</label>
                <input type="file" @input="form.main_image = $event.target.files[0]" id="main_image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <progress v-if="form.progress && form.progress.main_image" :value="form.progress.main_image.percentage" max="100">
                    {{ form.progress.main_image.percentage }}%
                </progress>
                <div v-if="form.errors.main_image" class="text-red-500 text-sm mt-1">{{ form.errors.main_image }}</div>
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <textarea v-model="form.body" id="body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <div v-if="form.errors.body" class="text-red-500 text-sm mt-1">{{ form.errors.body }}</div>
            </div>

            <div>
                <label for="body_cn" class="block text-sm font-medium text-gray-700">Body (Chinese)</label>
                <textarea v-model="form.body_cn" id="body_cn" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <div v-if="form.errors.body_cn" class="text-red-500 text-sm mt-1">{{ form.errors.body_cn }}</div>
            </div>

            <div>
                <label for="map" class="block text-sm font-medium text-gray-700">Map (Embed URL)</label>
                <input type="text" v-model="form.map" id="map" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.map" class="text-red-500 text-sm mt-1">{{ form.errors.map }}</div>
            </div>

            <div>
                <label for="total_days" class="block text-sm font-medium text-gray-700">Total Days</label>
                <input type="number" v-model.number="form.total_days" id="total_days" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.total_days" class="text-red-500 text-sm mt-1">{{ form.errors.total_days }}</div>
            </div>

            <div>
                <label for="prices" class="block text-sm font-medium text-gray-700">Prices (JSON format or simple text)</label>
                <input type="text" v-model="form.prices" id="prices" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.prices" class="text-red-500 text-sm mt-1">{{ form.errors.prices }}</div>
            </div>

            <div>
                <label for="discount_percent" class="block text-sm font-medium text-gray-700">Discount Percent</label>
                <input type="number" v-model.number="form.discount_percent" id="discount_percent" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.discount_percent" class="text-red-500 text-sm mt-1">{{ form.errors.discount_percent }}</div>
            </div>

            <div>
                <label for="discount_datetime_start" class="block text-sm font-medium text-gray-700">Discount Start Date</label>
                <input type="date" v-model="form.discount_datetime_start" id="discount_datetime_start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.discount_datetime_start" class="text-red-500 text-sm mt-1">{{ form.errors.discount_datetime_start }}</div>
            </div>

            <div>
                <label for="discount_datetime_end" class="block text-sm font-medium text-gray-700">Discount End Date</label>
                <input type="date" v-model="form.discount_datetime_end" id="discount_datetime_end" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.discount_datetime_end" class="text-red-500 text-sm mt-1">{{ form.errors.discount_datetime_end }}</div>
            </div>
            
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                <input type="number" v-model.number="form.sort_order" id="sort_order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.sort_order" class="text-red-500 text-sm mt-1">{{ form.errors.sort_order }}</div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" v-model="form.active" id="active" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="active" class="ml-2 block text-sm text-gray-900">Active</label>
                <div v-if="form.errors.active" class="text-red-500 text-sm ml-2">{{ form.errors.active }}</div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" v-model="form.recommended" id="recommended" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="recommended" class="ml-2 block text-sm text-gray-900">Recommended</label>
                <div v-if="form.errors.recommended" class="text-red-500 text-sm ml-2">{{ form.errors.recommended }}</div>
            </div>

            <!-- Multiple Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Additional Images</label>
                <input type="file" multiple @input="form.images = $event.target.files" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <progress v-if="form.progress && form.progress.images" :value="form.progress.images.percentage" max="100">
                    {{ form.progress.images.percentage }}%
                </progress>
                <div v-if="form.errors.images" class="text-red-500 text-sm mt-1">{{ form.errors.images }}</div>
            </div>

            <!-- Included Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Included Notes</label>
                <n-select multiple filterable :options="props.notes" label-field="name" value-field="id" v-model:value="form.included" placeholder="Select included notes" />
                <div v-if="form.errors.included" class="text-red-500 text-sm mt-1">{{ form.errors.included }}</div>
            </div>

            <!-- Non-Included Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Not Included Notes</label>
                <n-select multiple filterable :options="props.notes" label-field="name" value-field="id" v-model:value="form.non_included" placeholder="Select not included notes" />
                <div v-if="form.errors.non_included" class="text-red-500 text-sm mt-1">{{ form.errors.non_included }}</div>
            </div>
            
            <!-- Detailed Prices -->
            <div class="border p-4 rounded-md">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Detailed Prices</h2>
                <div v-for="(price, index) in form.detailedPrices" :key="index" class="space-y-2 border-b pb-2 mb-2">
                    <div>
                        <label :for="`price_name_${index}`" class="block text-sm font-medium text-gray-700">Price Item Name</label>
                        <input type="text" v-model="price.name" :id="`price_name_${index}`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label :for="`price_value_${index}`" class="block text-sm font-medium text-gray-700">Price Value</label>
                        <input type="number" v-model.number="price.price" :id="`price_value_${index}`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label :for="`price_name_cn_${index}`" class="block text-sm font-medium text-gray-700">Price Item Name (CN)</label>
                        <input type="text" v-model="price.name_cn" :id="`price_name_cn_${index}`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label :for="`price_value_cn_${index}`" class="block text-sm font-medium text-gray-700">Price Value (CN)</label>
                        <input type="number" v-model.number="price.price_cn" :id="`price_value_cn_${index}`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <button type="button" @click="removeDetailedPrice(index)" class="text-red-500 hover:text-red-700 text-sm">Remove Price Item</button>
                </div>
                <button type="button" @click="addDetailedPrice" class="mt-2 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Add Price Item</button>
                <div v-if="form.errors.detailedPrices" class="text-red-500 text-sm mt-1">{{ form.errors.detailedPrices }}</div>
            </div>

            <button type="submit" :disabled="form.processing" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Tour and Continue to Add Days
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { NSelect } from 'naive-ui'; // Import NSelect

const props = defineProps({
    places: Array,
    hotels: Array,
    notes: Array,
});

const form = useForm({
    name: null,
    name_cn: null,
    main_image: null,
    body: null,
    body_cn: null,
    map: null,
    total_days: 1,
    prices: null, // Corresponds to tour_prices in migration
    discount_percent: 0,
    discount_datetime_start: null,
    discount_datetime_end: null,
    viewed: 0,
    recommended: false,
    isPublic: false, 
    active: true, // from migration
    sort_order: null, // from migration
    images: [], // For multiple image uploads
    included: [], // For notes relation
    non_included: [], // For notes relation
    detailedPrices: [{ name: null, price: null, name_cn: null, price_cn: null }], // For prices relation (if you have one, or adapt)
    days: [] 
});

function addDetailedPrice() {
    form.detailedPrices.push({ name: null, price: null, name_cn: null, price_cn: null });
}

function removeDetailedPrice(index) {
    form.detailedPrices.splice(index, 1);
}

function submit() {
    form.post(route('admin.private_tours.store'), {
        onError: (errors) => {
            console.error('Form submission error:', errors);
        },
        onSuccess: () => {
            console.log('Form submitted successfully!');
            // Potentially redirect to the days setup page or clear form
        }
    });
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 