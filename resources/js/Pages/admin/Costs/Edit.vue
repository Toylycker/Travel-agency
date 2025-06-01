<template>
  <div class="page-header">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">
        Edit Cost
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
          <n-input v-model:value="form.name" placeholder="Enter cost name" />
        </n-form-item-gi>

        <n-form-item-gi label="Cost" path="cost">
          <n-input-number v-model:value="form.cost" placeholder="Enter cost" :min="0" :step="0.01" />
        </n-form-item-gi>

        <n-form-item-gi label="Self Cost" path="self_cost">
          <n-input-number v-model:value="form.self_cost" placeholder="Enter self cost" :min="0" :step="0.01" />
        </n-form-item-gi>

        <n-form-item-gi label="Number of People" path="number_of_people">
          <n-input-number
            v-model:value="form.number_of_people"
            :min="1"
            :precision="0"
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

      <n-divider>Related Item</n-divider>

      <n-grid :cols="2" :x-gap="24">
        <n-form-item-gi label="Item Type" path="costable_type">
          <n-select
            v-model:value="form.costable_type"
            :disabled="true"
            :options="costableTypes"
            placeholder="Select item type"
          />
        </n-form-item-gi>

        <n-form-item-gi label="Related Item ID" path="costable_id">
          <n-select
            v-model:value="form.costable_id"
            :options="costableOptions"
            placeholder="Select related item"
            :disabled="true"
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
        <n-button class="bg-info text-white" type="primary" attr-type="submit" :loading="form.processing">
          Update Cost
        </n-button>
      </div>
    </n-form>
  </n-card>
</template>

<script setup>
import { ref, watch } from 'vue'
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
  NDivider,
  NPageHeader
} from 'naive-ui'

const props = defineProps({
  cost: {
    type: Object,
    required: true
  },
  costableItems: {
    type: Object,
    required: true
  },
  costableTypes: {
    type: Array,
    required: true
  }
})

const form = useForm({
  name: props.cost.name,
  cost: parseFloat(props.cost.cost) || null,
  self_cost: parseFloat(props.cost.self_cost) || null,
  number_of_people: props.cost.number_of_people || 1,
  description: props.cost.description || '',
  costable_type: props.cost.costable_type,
  costable_id: props.cost.costable_id,
  is_active: props.cost.is_active ?? true
})

const costableOptions = ref([])

watch(() => form.costable_type, (newType) => {
  if (newType && props.costableItems[newType]) {
    costableOptions.value = props.costableItems[newType].map(item => ({
      label: item.name,
      value: item.id
    }))
  } else {
    costableOptions.value = []
  }
}, { immediate: true })

const rules = {
  name: {
    required: true,
    message: 'Please enter cost name',
    trigger: ['blur', 'change']
  },
  cost: {
    required: true,
    type: 'number',
    message: 'Please enter amount',
    trigger: ['blur', 'change']
  },
  number_of_people: {
    required: true,
    type: 'number',
    message: 'Please enter number of people',
    trigger: ['blur', 'change']
  }
}

const handleBack = () => {
  window.location = route('admin.costs.index')
}

const handleSubmit = () => {
  form.put(route('admin.costs.update', props.cost.id), {
    onSuccess: () => {
      alert('Cost updated successfully! 🎉')
    }
  })
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script>

 