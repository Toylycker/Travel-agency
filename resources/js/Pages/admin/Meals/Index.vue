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
import { NButton, NPopconfirm, NSpace, NTag, NCard, NDataTable, NPageHeader } from 'naive-ui'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

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
    key: 'id',
    width: 60
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
    title: 'Description',
    key: 'description',
    ellipsis: true
  },
  {
    title: 'Type',
    key: 'type',
    render(row) {
      const typeColors = {
        breakfast: 'success',
        lunch: 'info',
        dinner: 'warning',
        snack: 'default'
      }
      return h(NTag, {
        type: typeColors[row.type] || 'default',
        bordered: false
      }, { default: () => row.type })
    }
  },
  {
    title: 'Cuisine',
    key: 'cuisine',
    render(row) {
      return h(NTag, {
        type: 'info',
        bordered: false
      }, { default: () => row.cuisine })
    }
  },
  {
    title: 'Dietary Info',
    key: 'dietary',
    render(row) {
      const tags = []
      if (row.is_vegetarian) tags.push(h(NTag, { type: 'success', style: 'margin-right: 4px' }, { default: () => 'Vegetarian' }))
      if (row.is_vegan) tags.push(h(NTag, { type: 'success', style: 'margin-right: 4px' }, { default: () => 'Vegan' }))
      if (row.is_halal) tags.push(h(NTag, { type: 'info', style: 'margin-right: 4px' }, { default: () => 'Halal' }))
      return h(NSpace, { size: 'small' }, { default: () => tags })
    }
  },
  {
    title: 'Allergens',
    key: 'allergens_info',
    render(row) {
      const tags = []
      if (row.contains_nuts) tags.push(h(NTag, { type: 'warning', style: 'margin-right: 4px' }, { default: () => 'Nuts' }))
      if (row.contains_dairy) tags.push(h(NTag, { type: 'warning', style: 'margin-right: 4px' }, { default: () => 'Dairy' }))
      if (row.contains_gluten) tags.push(h(NTag, { type: 'warning', style: 'margin-right: 4px' }, { default: () => 'Gluten' }))
      if (row.allergens && row.allergens.length) {
        row.allergens.forEach(allergen => {
          tags.push(h(NTag, { type: 'error', style: 'margin-right: 4px' }, { default: () => allergen }))
        })
      }
      return h(NSpace, { size: 'small' }, { default: () => tags })
    }
  },
  {
    title: 'Calories',
    key: 'calories',
    render(row) {
      return row.calories ? `${row.calories} kcal` : '-'
    }
  },
  {
    title: 'Price',
    key: 'price',
    render(row) {
      return row.price ? `$${row.price}` : '-'
    }
  },
  {
    title: 'Prep Time',
    key: 'preparation_time',
    render(row) {
      return row.preparation_time ? `${row.preparation_time} min` : '-'
    }
  },
  {
    title: 'Status',
    key: 'is_active',
    render(row) {
      return h(NTag, {
        type: row.is_active ? 'success' : 'error',
        bordered: false
      }, { default: () => row.is_active ? 'Active' : 'Inactive' })
    }
  },
  {
    title: 'Actions',
    key: 'actions',
    fixed: 'right',
    width: 150,
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