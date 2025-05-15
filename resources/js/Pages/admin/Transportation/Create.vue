<template>
    <div class="page-header">
      <n-page-header>
        <template #title>
          Create Transportation
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
import AdminLayout from '@/Layouts/AdminLayout.vue'

const formRef = ref(null)
const loading = ref(false)

const form = useForm({
  name: '',
  name_cn: '',
  description: '',
  description_cn: ''
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
      form.post(route('admin.transportations.store'), {
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

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 