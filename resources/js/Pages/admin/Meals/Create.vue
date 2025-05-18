<template>
    <div class="page-header">
      <n-page-header>
        <template #title>
          Create Meal
        </template>
        <template #extra>
          <n-button @click="Inertia.back()">
            Back
          </n-button>
        </template>
      </n-page-header>
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
        <n-form-item label="Name" path="name">
          <n-input v-model:value="form.name" placeholder="Enter name" />
        </n-form-item>

        <n-form-item label="Chinese Name" path="name_cn">
          <n-input v-model:value="form.name_cn" placeholder="Enter Chinese name" />
        </n-form-item>

        <n-form-item label="Type" path="type">
          <n-select
            v-model:value="form.type"
            :options="mealTypes"
            placeholder="Select meal type"
          />
        </n-form-item>

        <n-form-item label="Cuisine" path="cuisine">
          <n-input v-model:value="form.cuisine" placeholder="Enter cuisine type" />
        </n-form-item>

        <n-form-item label="Description" path="description">
          <n-input
            v-model:value="form.description"
            type="textarea"
            placeholder="Enter description"
          />
        </n-form-item>

        <n-form-item label="Chinese Description" path="description_cn">
          <n-input
            v-model:value="form.description_cn"
            type="textarea"
            placeholder="Enter Chinese description"
          />
        </n-form-item>

        <div class="flex justify-end gap-2">
          <n-button @click="Inertia.back()">
            Cancel
          </n-button>
          <n-button type="primary" attr-type="submit" :loading="loading">
            Create Meal
          </n-button>
        </div>
      </n-form>
    </n-card>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { NButton, NForm, NFormItem, NInput, NSelect, NCard, NPageHeader } from 'naive-ui'

const formRef = ref(null)
const loading = ref(false)

const mealTypes = [
  { label: 'Breakfast', value: 'breakfast' },
  { label: 'Lunch', value: 'lunch' },
  { label: 'Dinner', value: 'dinner' },
  { label: 'Snack', value: 'snack' }
]

const form = useForm({
  name: '',
  name_cn: '',
  type: null,
  cuisine: '',
  description: '',
  description_cn: ''
})

const rules = {
  name: {
    required: true,
    message: 'Please enter name',
    trigger: 'blur'
  },
  type: {
    required: true,
    message: 'Please select meal type',
    trigger: 'change'
  }
}

const handleSubmit = () => {
  formRef.value?.validate((errors) => {
    if (!errors) {
      loading.value = true
      form.post(route('admin.meals.store'), {
        onSuccess: () => {
          loading.value = false
        },
        onError: () => {
          loading.value = false
        }
      })
    }
  })
}
</script> 

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 