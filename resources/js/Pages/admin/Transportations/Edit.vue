<template>
    <div class="page-header">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">
          Edit Transportation
        </h2>
        <n-button @click="handleBack">
          Back
        </n-button>
      </div>
    </div>

    <n-card>
      <n-form
        :model="form"
        :rules="rules"
        label-placement="left"
        label-width="160"
        require-mark-placement="right-hanging"
        @submit.prevent="handleSubmit"
      >
        <div v-if="Object.keys(form.errors).length > 0" class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
          <p class="text-red-600 font-medium">Please correct the following errors:</p>
          <ul class="mt-2 list-disc list-inside">
            <li v-for="(error, key) in form.errors" :key="key" class="text-red-500">
              {{ error }}
            </li>
          </ul>
        </div>

        <n-grid :cols="2" :x-gap="24">
          <n-form-item-gi label="Type" path="type">
            <n-select
              v-model:value="form.type"
              :options="vehicleTypes"
              placeholder="Select vehicle type"
              :status="form.errors.type ? 'error' : undefined"
            />
            <div v-if="form.errors.type" class="text-red-500 text-sm mt-1">
              {{ form.errors.type }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Brand" path="brand">
            <n-input 
              v-model:value="form.brand" 
              placeholder="Enter brand"
              :status="form.errors.brand ? 'error' : undefined"
            />
            <div v-if="form.errors.brand" class="text-red-500 text-sm mt-1">
              {{ form.errors.brand }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Model" path="model">
            <n-input 
              v-model:value="form.model" 
              placeholder="Enter model"
              :status="form.errors.model ? 'error' : undefined"
            />
            <div v-if="form.errors.model" class="text-red-500 text-sm mt-1">
              {{ form.errors.model }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Year" path="year">
            <n-input-number
              v-model:value="form.year"
              placeholder="Enter year"
              :min="1950"
              :max="new Date().getFullYear()"
              :status="form.errors.year ? 'error' : undefined"
            />
            <div v-if="form.errors.year" class="text-red-500 text-sm mt-1">
              {{ form.errors.year }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Seats" path="seats">
            <n-input-number
              v-model:value="form.seats"
              placeholder="Enter number of seats"
              :min="1"
              :status="form.errors.seats ? 'error' : undefined"
            />
            <div v-if="form.errors.seats" class="text-red-500 text-sm mt-1">
              {{ form.errors.seats }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="License Plate" path="license_plate">
            <n-input 
              v-model:value="form.license_plate" 
              placeholder="Enter license plate"
              :status="form.errors.license_plate ? 'error' : undefined"
            />
            <div v-if="form.errors.license_plate" class="text-red-500 text-sm mt-1">
              {{ form.errors.license_plate }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Color" path="color">
            <n-input 
              v-model:value="form.color" 
              placeholder="Enter color"
              :status="form.errors.color ? 'error' : undefined"
            />
            <div v-if="form.errors.color" class="text-red-500 text-sm mt-1">
              {{ form.errors.color }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Features" path="features">
            <n-select
              v-model:value="form.features"
              multiple
              :options="featureOptions"
              placeholder="Select features"
              :status="form.errors.features ? 'error' : undefined"
            />
            <div v-if="form.errors.features" class="text-red-500 text-sm mt-1">
              {{ form.errors.features }}
            </div>
          </n-form-item-gi>
        </n-grid>

        <n-divider>Amenities</n-divider>

        <n-grid :cols="3" :x-gap="24">
          <n-form-item-gi label="WiFi" path="has_wifi">
            <n-switch v-model:value="form.has_wifi" />
          </n-form-item-gi>

          <n-form-item-gi label="AC" path="has_ac">
            <n-switch v-model:value="form.has_ac" />
          </n-form-item-gi>

          <n-form-item-gi label="TV" path="has_tv">
            <n-switch v-model:value="form.has_tv" />
          </n-form-item-gi>
        </n-grid>

        <n-divider>Important Dates</n-divider>

        <n-grid :cols="2" :x-gap="24">
          <n-form-item-gi label="Insurance Expiry" path="insurance_expiry">
            <input
              type="date"
              v-model="form.insurance_expiry"
              class="form-control"
              :class="{ 'is-invalid': form.errors.insurance_expiry }"
            />
            <div v-if="form.errors.insurance_expiry" class="invalid-feedback">
              {{ form.errors.insurance_expiry }}
            </div>
          </n-form-item-gi>

          <n-form-item-gi label="Technical Inspection" path="technical_inspection_expiry">
            <input
              type="date"
              v-model="form.technical_inspection_expiry"
              class="form-control"
              :class="{ 'is-invalid': form.errors.technical_inspection_expiry }"
            />
            <div v-if="form.errors.technical_inspection_expiry" class="invalid-feedback">
              {{ form.errors.technical_inspection_expiry }}
            </div>
          </n-form-item-gi>
        </n-grid>

        <n-form-item label="Status" path="is_active">
          <n-switch v-model:value="form.is_active" />
        </n-form-item>

        <div class="flex justify-end gap-2 mt-4">
          <n-button @click="handleBack">
            Cancel
          </n-button>
          <n-button class="bg-info" type="primary" attr-type="submit" :loading="form.processing">
            Update Transportation
          </n-button>
        </div>
      </n-form>
    </n-card>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import {
  NButton,
  NCard,
  NForm,
  NFormItem,
  NFormItemGi,
  NInput,
  NInputNumber,
  NSelect,
  NSwitch,
  NGrid,
  NDivider
} from 'naive-ui'

const props = defineProps({
  transportation: {
    type: Object,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const vehicleTypes = [
  { label: 'Bus', value: 'bus' },
  { label: 'Van', value: 'van' },
  { label: 'Car', value: 'car' }
]

const featureOptions = [
  { label: 'USB Charging', value: 'USB Charging' },
  { label: 'Bluetooth Audio', value: 'Bluetooth Audio' },
  { label: 'Leather Seats', value: 'Leather Seats' },
  { label: 'Panoramic Roof', value: 'Panoramic Roof' },
  { label: 'Luggage Space', value: 'Luggage Space' },
  { label: 'Mini Fridge', value: 'Mini Fridge' },
  { label: 'Reading Lights', value: 'Reading Lights' },
  { label: 'Reclining Seats', value: 'Reclining Seats' }
]

const parseDate = (dateString) => {
  if (!dateString) return null;
  const date = new Date(dateString);
  return !isNaN(date.getTime()) ? date : null;
};

const form = useForm({
  type: props.transportation.type,
  brand: props.transportation.brand,
  model: props.transportation.model,
  year: props.transportation.year ? parseInt(props.transportation.year) : null,
  seats: props.transportation.seats ? parseInt(props.transportation.seats) : null,
  license_plate: props.transportation.license_plate,
  color: props.transportation.color,
  features: (() => {
    if (Array.isArray(props.transportation.features)) {
      return props.transportation.features;
    }
    if (typeof props.transportation.features === 'string' && props.transportation.features !== 'Array') {
      try {
        return JSON.parse(props.transportation.features);
      } catch (e) {
        console.warn('Failed to parse features:', e);
        return [];
      }
    }
    return [];
  })(),
  has_wifi: Boolean(props.transportation.has_wifi),
  has_ac: props.transportation.has_ac ?? true,
  has_tv: Boolean(props.transportation.has_tv),
  insurance_expiry: formatDate(props.transportation.insurance_expiry),
  technical_inspection_expiry: formatDate(props.transportation.technical_inspection_expiry),
  is_active: props.transportation.is_active ?? true
})

const rules = {
  type: {
    required: true,
    message: 'Please select vehicle type',
    trigger: ['blur', 'change']
  },
  brand: {
    required: true,
    message: 'Please enter brand',
    trigger: ['blur', 'change']
  },
  model: {
    required: true,
    message: 'Please enter model',
    trigger: ['blur', 'change']
  },
  year: {
    required: true,
    type: 'number',
    message: 'Please enter year',
    trigger: ['blur', 'change']
  },
  seats: {
    required: true,
    type: 'number',
    message: 'Please enter number of seats',
    trigger: ['blur', 'change']
  },
  license_plate: {
    required: true,
    message: 'Please enter license plate',
    trigger: ['blur', 'change']
  }
}

const handleBack = () => {
  window.location = route('admin.transportations.index')
}

const handleSubmit = () => {
      form.put(route('admin.transportations.update', props.transportation.id));
}

function formatDate(timestamp) {
  if (!timestamp) return null;
  const date = new Date(timestamp);
  return date.toISOString().slice(0, 10); // Or any format you prefer
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script> 