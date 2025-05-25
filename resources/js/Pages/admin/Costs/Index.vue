<template>
  <div class="page-header">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">
        Costs
      </h2>
      <n-button class="bg-success text-white" type="primary" @click="handleCreate">
        Add Cost
      </n-button>
    </div>
  </div>
  <n-card>
    <n-data-table
      :columns="columns"
      :data="costs"
      :pagination="pagination"
      :bordered="false"
      :scroll-x="1200"
      striped
    />
  </n-card>
</template>

<script setup>
import { h, ref } from 'vue'
import { NButton, NPopconfirm, NSpace, NTag, NText, NCard, NDataTable } from 'naive-ui'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  costs: {
    type: Array,
    required: true
  }
})

const pagination = {
  pageSize: 10
}

const formatCurrency = (amount, currency = 'CNY') => {
  return new Intl.NumberFormat('zh-CN', {
    style: 'currency',
    currency
  }).format(amount)
}

const getCostableType = (type) => {
  const types = {
    'App\\Models\\Transportation': 'Transportation',
    'App\\Models\\Room': 'Room',
    'App\\Models\\Guide': 'Guide',
    'App\\Models\\Meal': 'Meal',
    'App\\Models\\CustomCost': 'Custom Cost',
    'App\\Models\\Hotel': 'Hotel',
    'App\\Models\\Place': 'Place'
  }
  return types[type] || type.split('\\').pop() || 'Unknown'
}

const columns = [
  {
    title: 'ID',
    key: 'id',
    width: 80
  },
  {
    title: 'Name',
    key: 'name',
    width: 200
  },
  {
    title: 'Cost',
    key: 'cost',
    width: 120,
    render(row) {
      return formatCurrency(row.cost)
    }
  },
  {
    title: 'Linked To',
    key: 'costable',
    width: 150,
    render(row) {
      if (!row.costable_type) {
        return h(NText, { type: 'info' }, { default: () => 'None' })
      }
      const typeColors = {
        'App\\Models\\Transportation': 'info',
        'App\\Models\\Room': 'success',
        'App\\Models\\Guide': 'warning',
        'App\\Models\\Meal': 'error',
        'App\\Models\\CustomCost': 'default',
        'App\\Models\\Hotel': 'primary',
        'App\\Models\\Place': 'processing'
      }
      return h(
        NTag,
        {
          type: typeColors[row.costable_type] || 'default',
          size: 'small'
        },
        { default: () => getCostableType(row.costable_type) }
      )
    }
  },
  {
    title: 'Item ID',
    key: 'costable_id',
    width: 100,
    render(row) {
      return row.costable_id || '-'
    }
  },
  {
    title: 'Days',
    key: 'days',
    width: 200,
    render(row) {
      if (!row.days || row.days.length === 0) {
        return h(NText, { type: 'info' }, { default: () => 'Not assigned' })
      }
      return h(NSpace, { size: 'small' }, {
        default: () => row.days.map(day => 
          h(NTag, {
            type: 'info',
            size: 'small',
            bordered: true
          }, { default: () => `Day ${day.day_number} of ${day.tour.name}` })
        )
      })
    }
  },
  {
    title: 'Status',
    key: 'is_active',
    width: 100,
    render(row) {
      return h(
        NTag,
        {
          type: row.is_active ? 'success' : 'error',
          size: 'small'
        },
        { default: () => row.is_active ? 'Active' : 'Inactive' }
      )
    }
  },
  {
    title: 'Actions',
    key: 'actions',
    width: 200,
    fixed: 'right',
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(
            Link,
            {
              href: route('admin.costs.edit', row.id),
              class: 'no-underline'
            },
            {
              default: () =>
                h(
                  NButton,
                  {
                    type: 'primary',
                    size: 'small',
                    class: 'bg-info text-white'
                  },
                  { default: () => 'Edit' }
                )
            }
          ),
          h(
            NPopconfirm,
            {
              onPositiveClick: () => handleDelete(row.id)
            },
            {
              default: () => 'Are you sure you want to delete this cost?',
              trigger: () =>
                h(
                  NButton,
                  {
                    type: 'error',
                    size: 'small',
                    class: 'bg-danger text-white'
                  },
                  { default: () => 'Delete' }
                )
            }
          )
        ]
      })
    }
  }
]

const handleCreate = () => {
  window.location = route('admin.costs.create')
}

const handleDelete = (id) => {
  Inertia.delete(route('admin.costs.destroy', id))
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script> 