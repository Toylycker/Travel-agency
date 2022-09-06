<template>

    <Head title="Tours" />
    <div>
        <Tour v-for="(tour, index) in tours.data" :key="tour.id" :tour="tour" :index="index" :data-index="index"/>
    </div>
<div class="container position-absolute bottom-0 start-25 my-3">
    <Pagination :links='tours.links'></Pagination>
</div>

</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Tour from '@/Shared/Tour.vue';
import Pagination from '@/Shared/Pagination.vue';

defineProps(['tours']);

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>