<template>
    <div class="d-none d-md-block container bg-white rounded-3">
            <Component v-for="link in links" v-html="link.label" :href="link.url" :key="link.label"
                :is="link.url ? Link : 'span'" class="m-3 p-1 btn"
                :class="{ 'text-secondary': link.url == null, 'fw-bold btn-outline-success': link.active }">
            </Component>
    </div>
    <div class="d-block d-md-none d-flex bg-white rounded-3" >
        <div v-for="link in links" :key="link.label">
            <Component v-html="link.label" class="m-3 p-1 btn"
                :class="{ 'text-secondary': link.url == null, 'fw-bold btn-outline-success': link.active }"
                v-if="link.active || link.label != 1 && link.label != 2 && link.label != 3 && link.label != 4 && link.label != 5 && link.label != 6 && link.label != 7"
                :href="link.url" :is="link.url ? Link : 'span'" />
        </div>
    </div>
    <div class="container" style="height: 5px;"></div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    'links': Array
})

</script>
<style scoped></style>

//&laquo; Previous", "active": false