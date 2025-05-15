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
        ref="formRef"
        :model="form"
        :rules="rules"
        label-placement="left"
        label-width="160"
        require-mark-placement="right-hanging"
        @submit.prevent="handleSubmit"
      >
        <n-grid :cols="2" :x-gap="24">
          <n-form-item-gi label="Type" path="type">
            <n-select
              v-model:value="form.type"
              :options="vehicleTypes"
              placeholder="Select vehicle type"
            />
          </n-form-item-gi>

          <n-form-item-gi label="Brand" path="brand">
            <n-input v-model:value="form.brand" placeholder="Enter brand" />
          </n-form-item-gi>

          <n-form-item-gi label="Model" path="model">
            <n-input v-model:value="form.model" placeholder="Enter model" />
          </n-form-item-gi>

          <n-form-item-gi label="Year" path="year">
            <n-input-number
              v-model:value="form.year"
              placeholder="Enter year"
              :min="1950"
              :max="new Date().getFullYear()"
            />
          </n-form-item-gi>

          <n-form-item-gi label="Seats" path="seats">
            <n-input-number
              v-model:value="form.seats"
              placeholder="Enter number of seats"
              :min="1"
            />
          </n-form-item-gi>

          <n-form-item-gi label="License Plate" path="license_plate">
            <n-input v-model:value="form.license_plate" placeholder="Enter license plate" />
          </n-form-item-gi>

          <n-form-item-gi label="Color" path="color">
            <n-input v-model:value="form.color" placeholder="Enter color" />
          </n-form-item-gi>

          <n-form-item-gi label="Features" path="features">
            <n-select
              v-model:value="form.features"
              multiple
              :options="featureOptions"
              placeholder="Select features"
            />
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
            <n-date-picker
              v-model:value="form.insurance_expiry"
              type="date"
              clearable
              :default-time="[0, 0, 0, 0]"
              :is-date-disabled="(current) => current < Date.now()"
              placeholder="Select insurance expiry date"
            />
          </n-form-item-gi>

          <n-form-item-gi label="Technical Inspection" path="technical_inspection_expiry">
            <n-date-picker
              v-model:value="form.technical_inspection_expiry"
              type="date"
              clearable
              :default-time="[0, 0, 0, 0]"
              :is-date-disabled="(current) => current < Date.now()"
              placeholder="Select technical inspection expiry date"
            />
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
  NDatePicker,
  NGrid,
  NDivider
} from 'naive-ui'

const props = defineProps({
  transportation: {
    type: Object,
    required: true
  }
})

const formRef = ref(null)

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

const formatDateForPicker = (dateString) => {
  if (!dateString) return null;
  const date = new Date(dateString);
  return date.getTime();
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
  insurance_expiry: formatDateForPicker(props.transportation.insurance_expiry),
  technical_inspection_expiry: formatDateForPicker(props.transportation.technical_inspection_expiry),
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
  formRef.value?.validate((errors) => {
    if (!errors) {
      form.put(route('admin.transportations.update', props.transportation.id))
    }
  })
}

onMounted(() => {
  // Validate the form after it's mounted to clear initial validation messages
  nextTick(() => {
    formRef.value?.validate()
  })
})
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script> 