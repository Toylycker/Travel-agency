<template >
    <div class="row">
        <div class="col-10">
            <h1>customTours</h1>
        </div>
    </div>
    <n-table :bordered="true" :single-line="false" striped>
        <thead>
            <tr>
                <th>Id</th>
                <th>email</th>
                <th>country</th>
                <th>note</th>
                <th>ip</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="customTour in customTours.data" :key="customTour.id">
                <td>{{customTour.id}}</td>
                <td>{{customTour.email}}</td>
                <td>{{customTour.country.name}}</td>
                <td>{{customTour.note}}</td>
                <td>{{customTour.ip}}</td>
                <td>
                </td>
            </tr>
        </tbody>
    </n-table>

    <Pagination :links='customTours.links' />
</template>


<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3'
const props = defineProps(['customTours']);
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>