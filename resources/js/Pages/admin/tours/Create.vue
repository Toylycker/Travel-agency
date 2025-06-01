<template>
    <div class="container mx-auto p-4">
        <Head title="Create Public Tour" />
        <h1 class="text-2xl font-bold mb-6">Create Public Tour</h1>

        <div v-if="$page.props?.flash?.success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="form.hasErrors" class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <p class="font-bold">Please correct the following errors:</p>
            <ul>
                <li v-for="(error, key) in form.errors" :key="key">- {{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Tour Details Section -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Tour Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <n-input v-model:value="form.name" id="name" placeholder="Enter tour name" />
                        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                    </div>
                    <div>
                        <label for="name_cn" class="block text-sm font-medium text-gray-700">Name (Chinese)</label>
                        <n-input v-model:value="form.name_cn" id="name_cn" placeholder="输入旅行名称" />
                        <div v-if="form.errors.name_cn" class="text-red-500 text-xs mt-1">{{ form.errors.name_cn }}</div>
                    </div>
                    <div>
                        <label for="total_days" class="block text-sm font-medium text-gray-700">Total Days</label>
                        <n-input-number v-model:value="form.total_days" id="total_days" :min="1" class="w-full" @update:value="updateDaysArray" />
                        <div v-if="form.errors.total_days" class="text-red-500 text-xs mt-1">{{ form.errors.total_days }}</div>
                    </div>
                     <div>
                        <label for="prices" class="block text-sm font-medium text-gray-700">Base Price (Text)</label>
                        <n-input v-model:value="form.prices" id="prices" placeholder="e.g., $500 per person / 描述价格" />
                        <div v-if="form.errors.prices" class="text-red-500 text-xs mt-1">{{ form.errors.prices }}</div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="body" class="block text-sm font-medium text-gray-700">Description</label>
                    <n-input type="textarea" v-model:value="form.body" id="body" placeholder="Describe the tour" :autosize="{ minRows: 3 }" />
                    <div v-if="form.errors.body" class="text-red-500 text-xs mt-1">{{ form.errors.body }}</div>
                </div>
                <div class="mt-6">
                    <label for="body_cn" class="block text-sm font-medium text-gray-700">Description (Chinese)</label>
                    <n-input type="textarea" v-model:value="form.body_cn" id="body_cn" placeholder="描述旅行（中文）" :autosize="{ minRows: 3 }" />
                    <div v-if="form.errors.body_cn" class="text-red-500 text-xs mt-1">{{ form.errors.body_cn }}</div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="main_image" class="block text-sm font-medium text-gray-700">Main Image</label>
                        <input type="file" @input="form.main_image = $event.target.files[0]" class="mt-1 block w-full text-sm" />
                        <div v-if="form.errors.main_image" class="text-red-500 text-xs mt-1">{{ form.errors.main_image }}</div>
                    </div>
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700">Additional Images</label>
                        <input type="file" multiple @input="form.images = $event.target.files" class="mt-1 block w-full text-sm" />
                        <div v-if="form.errors.images" class="text-red-500 text-xs mt-1">{{ form.errors.images }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="map" class="block text-sm font-medium text-gray-700">Map Embed URL</label>
                        <n-input v-model:value="form.map" id="map" placeholder="Paste map embed URL" />
                        <div v-if="form.errors.map" class="text-red-500 text-xs mt-1">{{ form.errors.map }}</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                     <div>
                        <label for="discount_percent" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                        <n-input-number v-model:value="form.discount_percent" :min="0" :max="100" placeholder="0" class="w-full"/>
                        <div v-if="form.errors.discount_percent" class="text-red-500 text-xs mt-1">{{ form.errors.discount_percent }}</div>
                    </div>
                    <div>
                        <label for="discount_datetime_start" class="block text-sm font-medium text-gray-700">Discount Start</label>
                        <n-date-picker v-model:formatted-value="form.discount_datetime_start" type="date" value-format="yyyy-MM-dd" class="w-full" />
                        <div v-if="form.errors.discount_datetime_start" class="text-red-500 text-xs mt-1">{{ form.errors.discount_datetime_start }}</div>
                    </div>
                    <div>
                        <label for="discount_datetime_end" class="block text-sm font-medium text-gray-700">Discount End</label>
                        <n-date-picker v-model:formatted-value="form.discount_datetime_end" type="date" value-format="yyyy-MM-dd" class="w-full" />
                        <div v-if="form.errors.discount_datetime_end" class="text-red-500 text-xs mt-1">{{ form.errors.discount_datetime_end }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Included Notes</label>
                        <n-select multiple filterable :options="props.form_notes" label-field="name" value-field="id" v-model:value="form.included" placeholder="Select notes" />
                        <div v-if="form.errors.included" class="text-red-500 text-xs mt-1">{{ form.errors.included }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Not Included Notes</label>
                        <n-select multiple filterable :options="props.form_notes" label-field="name" value-field="id" v-model:value="form.non_included" placeholder="Select notes" />
                        <div v-if="form.errors.non_included" class="text-red-500 text-xs mt-1">{{ form.errors.non_included }}</div>
                    </div>
                </div>
                 <div class="flex items-center space-x-6 mt-6">
                    <n-checkbox v-model:checked="form.active">Active</n-checkbox>
                    <n-checkbox v-model:checked="form.recommended">Recommended</n-checkbox>
                </div>
            </div>

            <!-- Days Setup Section -->
            <div class="p-6 bg-white shadow rounded-lg mt-6">
                <h2 class="text-xl font-semibold mb-4">Days Setup</h2>
                <n-dynamic-input 
                    v-model:value="form.days" 
                    :on-create="createDay"
                    #default="{ value: day, index: dayIndex }"
                    class="w-full space-y-4" 
                >
                    <div class="p-4 border rounded-md bg-gray-50 w-full">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold">Day {{ day.day_number }}</h3>
                        </div>
                        <n-input-number v-model:value="day.day_number" :min="1" class="hidden"/>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Day Title</label>
                                <n-input v-model:value="day.title" placeholder="e.g., Arrival and City Exploration" />
                                <div v-if="form.errors[`days.${dayIndex}.title`]" class="text-red-500 text-xs mt-1">{{ form.errors[`days.${dayIndex}.title`] }}</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Day Description</label>
                            <n-input type="textarea" v-model:value="day.body" placeholder="Details for this day" :autosize="{minRows: 2}" />
                            <div v-if="form.errors[`days.${dayIndex}.body`]" class="text-red-500 text-xs mt-1">{{ form.errors[`days.${dayIndex}.body`] }}</div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700">Day Description (CN)</label>
                            <n-input type="textarea" v-model:value="day.body_cn" placeholder="中文描述 (Chinese Description)" :autosize="{minRows: 2}" />
                            <div v-if="form.errors[`days.${dayIndex}.body_cn`]" class="text-red-500 text-xs mt-1">{{ form.errors[`days.${dayIndex}.body_cn`] }}</div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Places for Day {{day.day_number}}</label>
                            <n-select multiple filterable :options="props.places" label-field="name" value-field="id" v-model:value="day.places" placeholder="Select places" class="w-full"/>
                            <div v-if="form.errors[`days.${dayIndex}.places`]" class="text-red-500 text-xs mt-1">{{ form.errors[`days.${dayIndex}.places`] }}</div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Hotels for Day {{day.day_number}}</label>
                            <n-select multiple filterable :options="props.hotels" label-field="name" value-field="id" v-model:value="day.hotels" placeholder="Select hotels" class="w-full"/>
                            <div v-if="form.errors[`days.${dayIndex}.hotels`]" class="text-red-500 text-xs mt-1">{{ form.errors[`days.${dayIndex}.hotels`] }}</div>
                        </div>
                    </div>
                </n-dynamic-input>
            </div>

            <!-- Detailed Prices Section -->
            <div class="p-6 bg-white shadow rounded-lg mt-6">
                <h2 class="text-xl font-semibold mb-4">Detailed Prices</h2>
                <n-dynamic-input
                    v-model:value="form.detailedPrices"
                    :on-create="() => ({ name: '', price: null, name_cn: '', price_cn: null })"
                    #default="{ value: priceEntry, index: priceIndex }"
                    class="space-y-4"
                >
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center p-3 border rounded bg-white">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600">Price Name</label>
                            <n-input v-model:value="priceEntry.name" placeholder="e.g., Adult" />
                            <div v-if="form.errors[`detailedPrices.${priceIndex}.name`]" class="text-red-500 text-xs mt-1">{{ form.errors[`detailedPrices.${priceIndex}.name`] }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Price Value</label>
                            <n-input-number v-model:value="priceEntry.price" placeholder="e.g., 100.00" class="w-full" :step="0.01" />
                            <div v-if="form.errors[`detailedPrices.${priceIndex}.price`]" class="text-red-500 text-xs mt-1">{{ form.errors[`detailedPrices.${priceIndex}.price`] }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600">Price Name (CN)</label>
                            <n-input v-model:value="priceEntry.name_cn" placeholder="e.g., 成人" />
                            <div v-if="form.errors[`detailedPrices.${priceIndex}.name_cn`]" class="text-red-500 text-xs mt-1">{{ form.errors[`detailedPrices.${priceIndex}.name_cn`] }}</div>
                        </div>
                        <!-- Remove button is part of n-dynamic-input -->
                    </div>
                </n-dynamic-input>
                 <div v-if="form.errors.detailedPrices" class="text-red-500 text-xs mt-1">{{ form.errors.detailedPrices }}</div>
            </div>


            <div class="mt-8 flex justify-end">
                <n-button class="bg-success" type="primary" @click="submit" :loading="form.processing" :disabled="form.processing">
                    Create Public Tour
                </n-button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { 
    NInput, NInputNumber, NSelect, NDatePicker, NCheckbox, 
    NDynamicInput, NButton 
} from 'naive-ui';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    places: Array, 
    hotels: Array, 
    form_notes: Array, // For tour general notes [{id, name}]
    errors: Object
});

const form = useForm({
    name: null,
    name_cn: null,
    main_image: null,
    body: null,
    body_cn: null,
    map: null,
    total_days: 1,
    prices: null, // This is the general text price
    discount_percent: 0,
    discount_datetime_start: null,
    discount_datetime_end: null,
    viewed: 0,
    recommended: false,
    active: true, // Default active to true for new tours
    is_public: true, // Explicitly true for public tours
    sort_order: null, // You might want to add a field for this if needed
    images: [], // For additional images
    included: [],
    non_included: [],
    days: [ // Initial day structure for n-dynamic-input
        { day_number: 1, title: 'Day 1', body: null, body_cn: null, places: [], hotels: [] }
    ],
    detailedPrices: [ // Initial price structure
        { name: '', price: null, name_cn: '', price_cn: null }
    ]
});

const createDay = () => {
    const newDayNumber = form.days.length + 1;
    return {
        day_number: newDayNumber,
        title: `Day ${newDayNumber}`,
        body: null,
        body_cn: null,
        places: [],
        hotels: []
    };
};

const updateDaysArray = (newTotalDays) => {
    const currentDaysCount = form.days.length;
    if (newTotalDays > currentDaysCount) {
        for (let i = currentDaysCount; i < newTotalDays; i++) {
            form.days.push(createDay()); 
        }
    } else if (newTotalDays < currentDaysCount) {
        form.days.splice(newTotalDays);
    }
    // Ensure day_number is sequential, especially if user manually reduces and then increases via total_days input
    form.days.forEach((day, index) => day.day_number = index + 1);
};

// Watch total_days to dynamically add/remove day objects
watch(() => form.total_days, (newVal, oldVal) => {
    if (newVal !== oldVal) { // Only update if value actually changed
      updateDaysArray(newVal);
    }
}, { immediate: false }); // Set immediate to false, let initial day be based on default form.days


function submit() {
    form.post(route('admin.tours.store'), {
        onError: (pageErrors) => {
            console.error('Form submission error:', pageErrors);
        },
        onSuccess: () => {
            form.reset(); 
            // Optional: Redirect or further actions
        }
    });
}

</script>

<script>
// AdminLayout already imported in setup
export default { layout: AdminLayout }
</script> 