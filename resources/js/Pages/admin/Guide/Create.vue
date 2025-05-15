<template>
  <div class="page-header">
    <n-page-header>
      <template #title>
        Add Guide
      </template>
      <template #extra>
        <n-button @click="handleBack">
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
      label-width="100"
      require-mark-placement="right-hanging"
      size="medium"
      :style="{
        maxWidth: '640px'
      }"
    >
      <n-form-item label="Name" path="name">
        <n-input v-model:value="form.name" placeholder="Enter guide name" />
      </n-form-item>

      <n-form-item label="中文名称" path="name_cn">
        <n-input v-model:value="form.name_cn" placeholder="输入导游中文名称" />
      </n-form-item>

      <n-form-item label="Phone" path="phone">
        <n-input v-model:value="form.phone" placeholder="Enter phone number" />
      </n-form-item>

      <n-form-item label="Email" path="email">
        <n-input v-model:value="form.email" placeholder="Enter email address" />
      </n-form-item>

      <n-form-item label="Status" path="status">
        <n-select
          v-model:value="form.status"
          :options="[
            { label: 'Active', value: 'active' },
            { label: 'Inactive', value: 'inactive' }
          ]"
        />
      </n-form-item>

      <n-form-item label="Languages" path="languages">
        <n-select
          v-model:value="form.languages"
          multiple
          :options="[
            { label: 'English', value: 'en' },
            { label: 'Chinese', value: 'zh' },
            { label: 'Japanese', value: 'ja' },
            { label: 'Korean', value: 'ko' }
          ]"
        />
      </n-form-item>

      <n-form-item>
        <n-button type="primary" @click="handleSubmit">
          Create Guide
        </n-button>
      </n-form-item>
    </n-form>
  </n-card>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const formRef = ref(null)

const form = useForm({
  name: '',
  name_cn: '',
  phone: '',
  email: '',
  status: 'active',
  languages: []
})

const rules = {
  name: {
    required: true,
    message: 'Please enter guide name',
    trigger: 'blur'
  },
  name_cn: {
    required: true,
    message: '请输入导游中文名称',
    trigger: 'blur'
  },
  phone: {
    required: true,
    message: 'Please enter phone number',
    trigger: 'blur'
  },
  email: {
    required: true,
    type: 'email',
    message: 'Please enter a valid email address',
    trigger: ['blur', 'input']
  },
  status: {
    required: true,
    message: 'Please select status',
    trigger: 'change'
  },
  languages: {
    type: 'array',
    required: true,
    message: 'Please select at least one language',
    trigger: 'change'
  }
}

const handleBack = () => {
  Inertia.visit(route('admin.guides.index'))
}

const handleSubmit = (e) => {
  e.preventDefault()
  formRef.value?.validate((errors) => {
    if (!errors) {
      form.post(route('admin.guides.store'), {
        onSuccess: () => {
          window.location = route('admin.guides.index')
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