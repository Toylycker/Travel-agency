<template>
    <div class="page-header">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">
          Create Transportation
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
          <n-button class="bg-success" type="primary" attr-type="submit" :loading="form.processing">
            Create Transportation
          </n-button>
        </div>
      </n-form>
    </n-card>
</template>

<script setup>
import { ref } from 'vue'
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

function formatDate(date) {
  if (!date) return null;
  const d = new Date(date);
  return d.toISOString().slice(0, 10); // Returns YYYY-MM-DD format
}

const form = useForm({
  type: null,
  brand: '',
  model: '',
  year: null,
  seats: null,
  license_plate: '',
  color: '',
  features: [],
  has_wifi: false,
  has_ac: true,
  has_tv: false,
  insurance_expiry: null,
  technical_inspection_expiry: null,
  is_active: true
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
  form.post(route('admin.transportations.store'));
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script> 