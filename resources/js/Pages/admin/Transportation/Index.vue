<template>
  <div class="page-header">
    <n-page-header>
      <template #title>
        Transportations
      </template>
      <template #extra>
        <n-button type="primary" @click="handleCreate">
          Add Transportation
        </n-button>
      </template>
    </n-page-header>
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
import { NButton, NPopconfirm, NSpace } from 'naive-ui'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

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
    title: 'Name',
    key: 'name'
  },
  {
    title: 'Chinese Name',
    key: 'name_cn'
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