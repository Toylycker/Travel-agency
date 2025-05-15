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
        <n-form-item label="Name" path="name">
          <n-input v-model:value="form.name" placeholder="Enter name" />
        </n-form-item>

        <n-form-item label="Chinese Name" path="name_cn">
          <n-input v-model:value="form.name_cn" placeholder="Enter Chinese name" />
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
            Update Transportation
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
  NCard,
  NForm,
  NFormItem,
  NInput,
  NButton
} from 'naive-ui'

const props = defineProps({
  transportation: {
    type: Object,
    required: true
  }
})

const formRef = ref(null)
const loading = ref(false)

const form = useForm({
  name: props.transportation.name,
  name_cn: props.transportation.name_cn,
  description: props.transportation.description,
  description_cn: props.transportation.description_cn
})

const rules = {
  name: {
    required: true,
    message: 'Please enter name',
    trigger: 'blur'
  }
}

const handleBack = () => {
  Inertia.visit(route('admin.transportations.index'))
}

const handleSubmit = () => {
  formRef.value?.validate((errors) => {
    if (!errors) {
      loading.value = true
      form.put(route('admin.transportations.update', props.transportation.id), {
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