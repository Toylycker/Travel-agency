<template> 
<div class="container bg-info rounded-3 text-center">
    <h1 >welcome Admin</h1>
</div>
    <div>
        <a href='/admin/download_visitors_log' class="btn bg-success m-1" >Download visitors Log</a>
    <button @click="$inertia.get(route('admin.delete_visitors_log'))" class="btn bg-danger m-1" >Delete visitors Log</button>
  </div>
  <div class="container mt-3">
    <h2 class="mb-4">Visitor Log</h2>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Log Entry</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(entry, index) in log_entries" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ entry }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script setup>
const props = defineProps(['log_entries']);
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>
