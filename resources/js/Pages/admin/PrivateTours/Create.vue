<template>
    <div class="container mx-auto p-4">
        <Head title="Create Private Tour" />
        <h1 class="text-2xl font-bold mb-6">Create Private Tour</h1>

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
                    <n-checkbox v-model:checked="form.isPublic" :disabled="true">Is Public (Private tours are not public)</n-checkbox>
                </div>
            </div>

            <!-- Days Setup Section -->
            <div class="p-6 bg-white shadow rounded-lg mt-6">
                <h2 class="text-xl font-semibold mb-4">Days Setup</h2>
                <n-steps vertical :current="currentStep" :status="stepStatus">
                    <n-step 
                        v-for="(day, dayIndex) in form.days" 
                        :key="dayIndex" 
                        :title="`Day ${day.day_number}` + (day.title ? ' - ' + day.title : '')" 
                        :description="day.body ? day.body.substring(0, 50) + '...' : 'Add details'"
                    >
                        <div class="mt-4 p-4 border rounded-md bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Day Title</label>
                                    <n-input v-model:value="day.title" placeholder="e.g., Arrival and City Exploration" />
                                    <div v-if="form.errors[`days.${dayIndex}.title`]">{{ form.errors[`days.${dayIndex}.title`] }}</div>
                                </div>
                                <n-input-number v-model:value="day.day_number" :min="1" class="hidden"/>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Day Description</label>
                                <n-input type="textarea" v-model:value="day.body" placeholder="Details for this day" :autosize="{minRows: 2}" />
                                 <div v-if="form.errors[`days.${dayIndex}.body`]">{{ form.errors[`days.${dayIndex}.body`] }}</div>
                            </div>
                             <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-700">Day Description (CN)</label>
                                <n-input type="textarea" v-model:value="day.body_cn" placeholder="中文描述 (Chinese Description)" :autosize="{minRows: 2}" />
                                <div v-if="form.errors[`days.${dayIndex}.body_cn`]">{{ form.errors[`days.${dayIndex}.body_cn`] }}</div>
                            </div>

                            <h3 class="text-md font-semibold mt-6 mb-2">Resources for Day {{ day.day_number }}</h3>
                            <n-dynamic-input 
                                v-model:value="day.cost_entries" 
                                :on-create="() => ({ resource_type: null, specific_resource_id: null, available_costs: [], cost_id: null, quantity: 1, max_quantity: undefined }) "
                                #default="{ value: costEntry, index: costIndex }"
                            >
                                <div class="flex flex-wrap items-start gap-4 w-full p-3 border rounded mb-2 bg-white">
                                    <div class="flex-1 min-w-[150px]">
                                        <label class="block text-xs font-medium text-gray-600">Resource Type</label>
                                        <n-select 
                                            v-model:value="costEntry.resource_type" 
                                            :options="resourceTypeOptions" 
                                            placeholder="Select Type"
                                            @update:value="handleResourceTypeChange(costEntry)"
                                        />
                                    </div>
                                    <div class="flex-1 min-w-[200px]">
                                        <label class="block text-xs font-medium text-gray-600">Specific Resource</label>
                                        <n-select 
                                            v-model:value="costEntry.specific_resource_id" 
                                            :options="getSpecificResourceOptions(costEntry.resource_type)" 
                                            :disabled="!costEntry.resource_type" 
                                            placeholder="Select Resource"
                                            filterable
                                            clearable
                                            @update:value="handleSpecificResourceChange(costEntry)"
                                        />
                                         <div v-if="form.errors[`days.${dayIndex}.cost_entries.${costIndex}.specific_resource_id`]">{{ form.errors[`days.${dayIndex}.cost_entries.${costIndex}.specific_resource_id`] }}</div>
                                    </div>
                                    <div class="flex-1 min-w-[200px]">
                                        <label class="block text-xs font-medium text-gray-600">Cost Option</label>
                                        <n-select 
                                            v-model:value="costEntry.cost_id" 
                                            :options="costEntry.available_costs"
                                            label-field="name" 
                                            value-field="id" 
                                            :disabled="!costEntry.specific_resource_id || costEntry.available_costs.length === 0"
                                            placeholder="Select Cost"
                                            clearable
                                            @update:value="handleCostOptionChange(costEntry)"
                                        />
                                        <div v-if="form.errors[`days.${dayIndex}.cost_entries.${costIndex}.cost_id`]">{{ form.errors[`days.${dayIndex}.cost_entries.${costIndex}.cost_id`] }}</div>
                                    </div>
                                    <div class="flex-1 min-w-[150px]">
                                        <label class="block text-xs font-medium text-gray-600">Quantity</label>
                                        <n-input-number v-model:value="costEntry.quantity" :min="1" placeholder="1" class="w-full" :max="costEntry.max_quantity"/>
                                        <div v-if="form.errors[`days.${dayIndex}.cost_entries.${costIndex}.quantity`]">{{ form.errors[`days.${dayIndex}.cost_entries.${costIndex}.quantity`] }}</div>
                                    </div>
                                </div>
                            </n-dynamic-input>
                        </div>
                    </n-step>
                </n-steps>
            </div>

            <div class="mt-8 flex justify-end">
                <n-button class="bg-success" type="primary" @click="submit" :loading="form.processing" :disabled="form.processing">
                    Create Private Tour
                </n-button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { 
    NInput, NInputNumber, NSelect, NDatePicker, NCheckbox, 
    NSteps, NStep, NDynamicInput, NButton 
} from 'naive-ui';

const props = defineProps({
    places: Array, // Expected: [{id, name, costs: [{id, name, cost, number_of_people}]}]
    rooms: Array,  // Expected: [{id, name (Hotel - Room), costs: [{id, name, cost, number_of_people}]}]
    guides: Array, // Expected: [{id, name, costs: [{id, name, cost, number_of_people}]}]
    transportations: Array, // Expected: [{id, name, costs: [{id, name, cost, number_of_people}]}]
    meals: Array, // Expected: [{id, name, costs: [{id, name, cost, number_of_people}]}]
    custom_costs: Array, // Expected: [{id, name, costs: [{id, name, cost, number_of_people}]}]
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
    prices: null, 
    discount_percent: 0,
    discount_datetime_start: null,
    discount_datetime_end: null,
    viewed: 0,
    recommended: false,
    isPublic: false,
    active: true,
    sort_order: null,
    images: [],
    included: [],
    non_included: [],
    detailedPrices: [], // Keeping this simple for now, can be expanded like days
    days: [
        {
            day_number: 1,
            title: 'Day 1',
            body: null,
            body_cn: null,
            cost_entries: []
        }
    ]
});

const currentStep = ref(1);
const stepStatus = ref('process');

const resourceTypeOptions = [
    { label: 'Place', value: 'Place' },
    { label: 'Room', value: 'Room' },
    { label: 'Guide', value: 'Guide' },
    { label: 'Transportation', value: 'Transportation' },
    { label: 'Meal', value: 'Meal' },
    { label: 'CustomCost', value: 'CustomCost' },
];

// Initialize days array based on total_days
const updateDaysArray = (newTotalDays) => {
    const currentDaysCount = form.days.length;
    if (newTotalDays > currentDaysCount) {
        for (let i = currentDaysCount + 1; i <= newTotalDays; i++) {
            form.days.push({
                day_number: i,
                title: `Day ${i}`,
                body: null,
                body_cn: null,
                cost_entries: []
            });
        }
    } else if (newTotalDays < currentDaysCount) {
        form.days.splice(newTotalDays);
    }
    // Ensure day_number is sequential if user manually reduces and then increases
    form.days.forEach((day, index) => day.day_number = index + 1);
};

watch(() => form.total_days, (newVal) => {
    updateDaysArray(newVal);
}, { immediate: true });

const getSpecificResourceOptions = (type) => {
    if (!type) return [];
    switch (type) {
        case 'Place': return props.places.map(p => ({ label: p.name, value: p.id, costs: p.costs }));
        case 'Room': return props.rooms.map(r => ({ label: r.name, value: r.id, costs: r.costs })); // Name is already Hotel - Room
        case 'Guide': return props.guides.map(g => ({ label: g.name, value: g.id, costs: g.costs }));
        case 'Transportation': return props.transportations.map(t => ({ label: t.name, value: t.id, costs: t.costs }));
        case 'Meal': return props.meals.map(m => ({ label: m.name, value: m.id, costs: m.costs }));
        case 'CustomCost': return props.custom_costs.map(cc => ({ label: cc.name, value: cc.id, costs: cc.costs }));
        default: return [];
    }
};

const handleResourceTypeChange = (costEntry) => {
    costEntry.specific_resource_id = null;
    costEntry.cost_id = null;
    costEntry.available_costs = [];
};

const handleSpecificResourceChange = (costEntry) => {
    costEntry.cost_id = null;
    costEntry.max_quantity = undefined; // Reset max quantity when resource changes
    const resourceOptions = getSpecificResourceOptions(costEntry.resource_type);
    const selectedResource = resourceOptions.find(r => r.value === costEntry.specific_resource_id);
    costEntry.available_costs = selectedResource && selectedResource.costs ? selectedResource.costs : [];
    costEntry.quantity = costEntry.quantity || 1; // Default quantity to 1 if not set
};

const handleCostOptionChange = (costEntry) => {
    if (costEntry.cost_id) {
        const selectedCost = costEntry.available_costs.find(cost => cost.id === costEntry.cost_id);
        if (selectedCost && typeof selectedCost.number_of_people === 'number') {
            costEntry.max_quantity = selectedCost.number_of_people;
            if (costEntry.quantity > costEntry.max_quantity) {
                costEntry.quantity = costEntry.max_quantity;
            }
        } else {
            costEntry.max_quantity = undefined; // No limit if number_of_people is not defined
        }
    } else {
        costEntry.max_quantity = undefined; // No cost selected, so no limit
    }
};

function submit() {
    form.post(route('admin.private_tours.store'), {
        onError: (pageErrors) => {
            console.error('Form submission error:', pageErrors);
            stepStatus.value = 'error';
            // Find the first day with an error to focus the step
            if (form.errors) {
                for (let i = 0; i < form.days.length; i++) {
                    if (Object.keys(form.errors).some(key => key.startsWith(`days.${i}`))) {
                        currentStep.value = i + 1;
                        break;
                    }
                }
            }
        },
        onSuccess: () => {
            form.reset(); // Reset form on success
            // Could redirect or show a persistent success message outside of flash
            // For now, flash message handled at the top
            currentStep.value = 1;
            stepStatus.value = 'finish';
            setTimeout(() => stepStatus.value = 'process', 3000); // Reset status
        }
    });
}

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 

<style scoped>
/* Add any component-specific styles here if needed */
</style> 