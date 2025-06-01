<template>
    <div class="page-header">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">
          Create Meal
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
          <n-form-item-gi label="Name" path="name">
            <n-input v-model:value="form.name" placeholder="Enter meal name" />
          </n-form-item-gi>

          <n-form-item-gi label="Type" path="type">
            <n-select
              v-model:value="form.type"
              :options="mealTypes"
              placeholder="Select meal type"
            />
          </n-form-item-gi>

          <n-form-item-gi label="Cuisine" path="cuisine">
            <n-input v-model:value="form.cuisine" placeholder="Enter cuisine type" />
          </n-form-item-gi>

          <n-form-item-gi label="Calories" path="calories">
            <n-input-number
              v-model:value="form.calories"
              placeholder="Enter calories"
              :min="0"
              suffix="kcal"
            />
          </n-form-item-gi>

          <n-form-item-gi label="Preparation Time" path="preparation_time">
            <n-input-number
              v-model:value="form.preparation_time"
              placeholder="Enter preparation time"
              :min="1"
              suffix="min"
            />
          </n-form-item-gi>
        </n-grid>

        <n-form-item label="Description" path="description">
          <n-input
            v-model:value="form.description"
            type="textarea"
            placeholder="Enter description"
            :rows="3"
          />
        </n-form-item>

        <n-divider>Dietary Information</n-divider>

        <n-grid :cols="3" :x-gap="24">
          <n-form-item-gi label="Vegetarian" path="is_vegetarian">
            <n-switch v-model:value="form.is_vegetarian" />
          </n-form-item-gi>

          <n-form-item-gi label="Vegan" path="is_vegan">
            <n-switch v-model:value="form.is_vegan" />
          </n-form-item-gi>

          <n-form-item-gi label="Halal" path="is_halal">
            <n-switch v-model:value="form.is_halal" />
          </n-form-item-gi>
        </n-grid>

        <n-divider>Allergen Information</n-divider>

        <n-grid :cols="3" :x-gap="24">
          <n-form-item-gi label="Contains Nuts" path="contains_nuts">
            <n-switch v-model:value="form.contains_nuts" />
          </n-form-item-gi>

          <n-form-item-gi label="Contains Dairy" path="contains_dairy">
            <n-switch v-model:value="form.contains_dairy" />
          </n-form-item-gi>

          <n-form-item-gi label="Contains Gluten" path="contains_gluten">
            <n-switch v-model:value="form.contains_gluten" />
          </n-form-item-gi>
        </n-grid>

        <n-form-item label="Additional Allergens" path="allergens">
          <n-select
            v-model:value="form.allergens"
            multiple
            :options="allergenOptions"
            placeholder="Select additional allergens"
          />
        </n-form-item>

        <n-form-item label="Status" path="is_active">
          <n-switch v-model:value="form.is_active" />
        </n-form-item>

        <div class="flex justify-end gap-2 mt-4">
          <n-button @click="handleBack">
            Cancel
          </n-button>
          <n-button class="bg-success text-white" type="primary" attr-type="submit" :loading="form.processing">
            Create Meal
          </n-button>
        </div>
      </n-form>
    </n-card>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
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

const mealTypes = [
  { label: 'Breakfast', value: 'breakfast' },
  { label: 'Lunch', value: 'lunch' },
  { label: 'Dinner', value: 'dinner' },
  { label: 'Snack', value: 'snack' }
]

const allergenOptions = [
  { label: 'Eggs', value: 'eggs' },
  { label: 'Fish', value: 'fish' },
  { label: 'Shellfish', value: 'shellfish' },
  { label: 'Soy', value: 'soy' },
  { label: 'Peanuts', value: 'peanuts' },
  { label: 'Tree Nuts', value: 'tree_nuts' },
  { label: 'Wheat', value: 'wheat' },
  { label: 'Sesame', value: 'sesame' },
  { label: 'Mustard', value: 'mustard' }
]

const form = useForm({
  name: '',
  type: null,
  description: '',
  cuisine: '',
  calories: null,
  preparation_time: null,
  is_vegetarian: false,
  is_vegan: false,
  is_halal: true,
  contains_nuts: false,
  contains_dairy: false,
  contains_gluten: false,
  allergens: [],
  is_active: true
})

const rules = {
  name: {
    required: true,
    message: 'Please enter meal name',
    trigger: ['blur', 'change']
  },
  type: {
    required: true,
    message: 'Please select meal type',
    trigger: ['blur', 'change']
  },
  cuisine: {
    required: true,
    message: 'Please enter cuisine type',
    trigger: ['blur', 'change']
  },
  calories: {
    type: 'number',
    message: 'Please enter valid calories',
    trigger: ['blur', 'change']
  },
  preparation_time: {
    type: 'number',
    message: 'Please enter valid preparation time',
    trigger: ['blur', 'change']
  }
}

const handleBack = () => {
  window.location = route('admin.meals.index')
}

const handleSubmit = () => {
  form.post(route('admin.meals.store'), {
    onSuccess: () => {
      alert('Meal created successfully! 🎉')
      form.reset()
    }
  })
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script> 