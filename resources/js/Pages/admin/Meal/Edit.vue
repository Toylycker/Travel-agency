<template>
    <div class="page-header">
      <n-page-header>
        <template #title>
          Edit Meal
        </template>
        <template #extra>
          <n-button @click="$router.back()">
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
          <n-button @click="$router.back()">
            Cancel
          </n-button>
          <n-button type="primary" attr-type="submit" :loading="loading">
            Update Meal
          </n-button>
        </div>
      </n-form>
    </n-card>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  meal: {
    type: Object,
    required: true
  }
})

const formRef = ref(null)
const loading = ref(false)

const mealTypes = [
  { label: 'Breakfast', value: 'breakfast' },
  { label: 'Lunch', value: 'lunch' },
  { label: 'Dinner', value: 'dinner' },
  { label: 'Snack', value: 'snack' }
]

const form = useForm({
  name: props.meal.name,
  name_cn: props.meal.name_cn,
  type: props.meal.type,
  cuisine: props.meal.cuisine,
  description: props.meal.description,
  description_cn: props.meal.description_cn
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
      form.put(route('admin.meals.update', props.meal.id), {
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