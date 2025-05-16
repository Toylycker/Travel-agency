<template>
  <div class="page-header">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">
        Guides
      </h2>
      <n-button class="bg-info" type="primary" @click="handleCreate">
        Add Guide
      </n-button>
    </div>
  </div>

  <n-card>
    <n-data-table
      :columns="columns"
      :data="guides"
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
import { NCard, NDataTable } from 'naive-ui'

const props = defineProps({
  guides: {
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
    title: 'Name',
    key: 'name'
  },
  {
    title: 'Surname',
    key: 'surname'
  },
  {
    title: 'Phone',
    key: 'phone'
  },
  {
    title: 'Email',
    key: 'email'
  },
  {
    title: 'Bio',
    key: 'bio',
    render(row) {
      return row.bio ? row.bio.substring(0, 50) + (row.bio.length > 50 ? '...' : '') : ''
    }
  },
  {
    title: 'Years of Experience',
    key: 'years_of_experience'
  },
  {
    title: 'Languages',
    key: 'languages',
    render(row) {
      return row.languages ? row.languages.join(', ') : ''
    }
  },
  {
    title: 'License Number',
    key: 'license_number'
  },
  {
    title: 'License Expiry',
    key: 'license_expiry'
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
              href: route('admin.guides.edit', row.id),
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
  window.location = route('admin.guides.create')
}

const handleDelete = (id) => {
  Inertia.delete(route('admin.guides.destroy', id))
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 