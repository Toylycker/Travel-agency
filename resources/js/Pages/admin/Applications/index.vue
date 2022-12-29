<template >
    <div class="row">
        <div class="col-10">
            <h1>Applications</h1>
        </div>
    </div>
    <n-table :bordered="true" :single-line="false" striped>
        <thead>
            <tr>
                <th>Id</th>
                <th>name</th>
                <th>surname</th>
                <th>email</th>
                <th>phone</th>
                <th>country</th>
                <th>tour</th>
                <th>arrival</th>
                <th>departure</th>
                <th>note</th>
                <th>ip</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="application in applications.data" :key="application.id">
                <td>{{application.id}}</td>
                <td>{{application.name}}</td>
                <td>{{application.surname}}</td>
                <td>{{application.email}}</td>
                <td>{{application.phone}}</td>
                <td>{{application.country.name}}</td>
                <td>{{application.tour.name}}</td>
                <td>{{application.arrival}}</td>
                <td>{{application.departure}}</td>
                <td>{{application.note}}</td>
                <td>{{application.ip}}</td>
                <td>
                    <!-- <Link @click="this.$inertia.delete(route('admin.applications.destroy', application.id))" as="button"
                        class="btn btn-danger btn-sm w-100 my-2">Delete</Link> -->
                </td>
            </tr>
        </tbody>
    </n-table>

    <Pagination :links='applications.links' />
</template>


<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3'
const props = defineProps(['applications']);
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>