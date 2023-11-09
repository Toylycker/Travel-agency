<template>
  <span v-if="Object.keys($page.props.errors).length">{{ Inertia.page.props.errors }}</span>
  <div class="container-fluid d-flex justify-content-between">
      <h1 class="h2">Notes</h1>
      <div>
          <n-button @click="show = true">
          Create
        </n-button>
        <n-drawer v-model:show="show" :width="502">
          <n-drawer-content title="Create note" closable>
            <div class="container">
              <n-input-number class="my-1" v-model:value="form.note_id" clearable placeholder="note_id"/>
              <n-input class="my-1" v-model:value="form.name" type="text" placeholder="name" />
              <n-input class="my-1" v-model:value="form.name_cn" type="text" placeholder="name in chinese" />
              <div class="btn btn-success" @click="form.post(route('admin.notes.store'), {onSuccess:()=>{form.reset()}, preserveState:false})">Submit</div>
            </div>
          </n-drawer-content>
        </n-drawer>
      </div>
  </div>
  <div class="container-fluid d-flex">
          <n-data-table :key="(row) => row.id" :columns="columns" :data="data" :pagination="false" />

  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { NScrollbar,NAlert, NStatistic, NDataTable, NInput, NInputNumber, NDrawer, NDrawerContent, NButton } from 'naive-ui';
import { onMounted, h, ref } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['notes']);
let data = ref(props.notes);
let show = ref(false);
const form = useForm({
  'note_id':null,
  'name':null,
  'name_cn':null,
});


let columns = [
  {
      title: 'id',
      key: 'id',
  },
  {
      title: 'name',
      key: 'name',
      render(row, index) {
          return h(NInput, {
              value: row.name,
              onUpdateValue(v) {
                  data.value[index].name = v
              }
          })
      }
  },
  {
      title: 'name_cn',
      key: 'name_cn',
      render(row, index) {
          return h(NInput, {
              value: row.name_cn,
              onUpdateValue(v) {
                  data.value[index].name_cn = v
              }
          })
      }
  },
  {
'title': 'update', 'key': 'update',
render(row) {
  return h(
    'div',
    {
      class: 'btn btn-success',
      onClick: () => Inertia.put(route('admin.notes.update', row.id), 
      { note_id:row.note_id, 'name':row.name, 'name_cn':row.name_cn})
    },
    { default: () => "update" }
  );
}
},
{
'title': 'delete', 'key': 'delete',
render(row) {
  return h(
    'div',
    {
      class: 'btn btn-danger',
      onClick: () => Inertia.delete(route('admin.notes.destroy', row.id), {preserveState:false})
    },
    { default: () => "delete" }
  );
}
}

]

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>