<template>
  <div class="page-header">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">
        Transportations
      </h2>
      <n-button type="primary" @click="handleCreate">
        Add Transportation
      </n-button>
    </div>
  </div>

  <n-card>
    <n-data-table
      :columns="columns"
      :data="transportations"
      :pagination="pagination"
      :bordered="false"
      striped
    />
  </n-card>
</template>

<script setup>
import { h, ref } from 'vue'
import { NButton, NPopconfirm, NSpace, NCard, NDataTable, NTag } from 'naive-ui'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/inertia-vue3'

const props = defineProps({
  transportations: {
    type: Array,
    required: true
  }
})

const pagination = {
  pageSize: 10
}

const columns = [
  {
    title: 'ID',
    key: 'id'
  },
  {
    title: 'Type',
    key: 'type'
  },
  {
    title: 'Brand',
    key: 'brand'
  },
  {
    title: 'Model',
    key: 'model'
  },
  {
    title: 'Year',
    key: 'year'
  },
  {
    title: 'Seats',
    key: 'seats'
  },
  {
    title: 'License Plate',
    key: 'license_plate'
  },
  {
    title: 'Color',
    key: 'color'
  },
  {
    title: 'Features',
    key: 'features',
    render(row) {
      if (!row.features) return '-'
      return Array.isArray(row.features) ? row.features.join(', ') : row.features
    }
  },
  {
    title: 'Amenities',
    key: 'amenities',
    render(row) {
      const amenities = []
      if (row.has_wifi) amenities.push('WiFi')
      if (row.has_ac) amenities.push('AC')
      if (row.has_tv) amenities.push('TV')
      return amenities.join(', ') || '-'
    }
  },
  {
    title: 'Insurance Expiry',
    key: 'insurance_expiry'
  },
  {
    title: 'Technical Inspection',
    key: 'technical_inspection_expiry'
  },
  {
    title: 'Status',
    key: 'is_active',
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
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(
            Link,
            {
              href: route('admin.transportations.edit', row.id),
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
  window.location = route('admin.transportations.create')
}

const handleDelete = (id) => {
  Inertia.delete(route('admin.transportations.destroy', id))
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 