<template>
    <div class="page-header">
      <n-page-header>
        <template #title>
          Add Cost
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
          <n-input v-model:value="form.name" placeholder="Enter cost name" />
        </n-form-item>

        <n-form-item label="中文名称" path="name_cn">
          <n-input v-model:value="form.name_cn" placeholder="输入费用中文名称" />
        </n-form-item>

        <n-form-item label="Type" path="type">
          <n-select
            v-model:value="form.type"
            :options="[
              { label: 'Transportation', value: 'transportation' },
              { label: 'Accommodation', value: 'accommodation' },
              { label: 'Activity', value: 'activity' },
              { label: 'Meal', value: 'meal' },
              { label: 'Other', value: 'other' }
            ]"
          />
        </n-form-item>

        <n-form-item label="Amount" path="amount">
          <n-input-number
            v-model:value="form.amount"
            :min="0"
            :precision="2"
            :show-button="false"
            prefix="¥"
          />
        </n-form-item>

        <n-form-item label="Description" path="description">
          <n-input
            v-model:value="form.description"
            type="textarea"
            placeholder="Enter cost description"
          />
        </n-form-item>

        <n-form-item label="备注" path="description_cn">
          <n-input
            v-model:value="form.description_cn"
            type="textarea"
            placeholder="输入费用说明"
          />
        </n-form-item>

        <n-form-item>
          <n-button type="primary" @click="handleSubmit">
            Create Cost
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
  type: 'other',
  amount: 0,
  description: '',
  description_cn: ''
})

const rules = {
  name: {
    required: true,
    message: 'Please enter cost name',
    trigger: 'blur'
  },
  name_cn: {
    required: true,
    message: '请输入费用中文名称',
    trigger: 'blur'
  },
  type: {
    required: true,
    message: 'Please select cost type',
    trigger: 'change'
  },
  amount: {
    required: true,
    type: 'number',
    message: 'Please enter amount',
    trigger: ['blur', 'change']
  }
}

const handleBack = () => {
  Inertia.visit(route('admin.costs.index'))
}

const handleSubmit = (e) => {
  e.preventDefault()
  formRef.value?.validate((errors) => {
    if (!errors) {
      form.post(route('admin.costs.store'), {
        onSuccess: () => {
          window.location = route('admin.costs.index')
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