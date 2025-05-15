<template>
    <div class="page-header">
      <n-page-header>
        <template #title>
          Meals
        </template>
        <template #extra>
          <n-button type="primary" @click="handleCreate">
            Add Meal
          </n-button>
        </template>
      </n-page-header>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="meals"
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
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  meals: {
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
    title: 'Type',
    key: 'type',
    render(row) {
      return h(NTag, {
        type: 'success',
        bordered: false
      }, { default: () => row.type })
    }
  },
  {
    title: 'Cuisine',
    key: 'cuisine'
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
              href: route('admin.meals.edit', row.id),
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
  window.location = route('admin.meals.create')
}

const handleDelete = (id) => {
  Inertia.delete(route('admin.meals.destroy', id))
}
</script> 

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script> 