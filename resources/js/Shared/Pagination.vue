<template>
    <Component v-for="link in links" :href="link.url" v-html="link.label" :key="link.label"
        :is="link.url ? Link : 'span'" class="m-3 p-1" :class="{'text-secondary':link.url==null, 'fw-bold':link.active}"/>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    'links':Array
})

</script>
<style scoped>
    
</style>