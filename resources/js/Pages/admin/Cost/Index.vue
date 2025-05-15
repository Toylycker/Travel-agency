<template>
  <div class="page-header">
    <n-page-header>
      <template #title>
        Costs
      </template>
      <template #extra>
        <n-button type="primary" @click="handleCreate">
          Add Cost
        </n-button>
      </template>
    </n-page-header>
  </div>

  <n-card>
    <n-data-table
      :columns="columns"
      :data="costs"
      :pagination="pagination"
      :bordered="false"
      striped
    />
  </n-card>
</template>

<script setup>
import { h, ref } from 'vue'
import { NButton, NPopconfirm, NSpace, NTag } from 'naive-ui'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import AdminLayout from '@/Layouts/AdminLayout.vue'

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

const columns = [
  {
    title: 'ID',
    key: 'id'
  },
  {
    title: 'Name',
    key: 'name'
  },
  {
    title: 'Chinese Name',
    key: 'name_cn'
  },
  {
    title: 'Type',
    key: 'type',
    render(row) {
      const typeColors = {
        transportation: 'info',
        accommodation: 'success',
        activity: 'warning',
        meal: 'error',
        other: 'default'
      }
      return h(
        NTag,
        {
          type: typeColors[row.type] || 'default',
          size: 'small'
        },
        { default: () => row.type }
      )
    }
  },
  {
    title: 'Amount',
    key: 'amount',
    render(row) {
      return formatCurrency(row.amount)
    }
  },
  {
    title: 'Actions',
    key: 'actions',
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
                    size: 'small'
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
              default: () => 'Are you sure?',
              trigger: () =>
                h(
                  NButton,
                  {
                    type: 'error',
                    size: 'small'
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
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 