<template >
    <div class="row">
        <div class="col-10">
            <h1>Messages</h1>
        </div>
    </div>
    <n-table :bordered="true" :single-line="false" striped>
        <thead>
            <tr>
                <th>Id</th>
                <th>email</th>
                <th>message</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="message in messages.data" :key="message.id">
                <td>{{message.id}}</td>
                <td>{{message.email}}</td>
                <td>{{message.message}}</td>
            </tr>
        </tbody>
    </n-table>

    <Pagination :links='messages.links' />
</template>


<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
const props = defineProps(['messages']);
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>