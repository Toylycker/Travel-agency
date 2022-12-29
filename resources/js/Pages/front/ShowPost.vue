<template>
    <div v-if="post.videos.length>0" class="container-fluid text-center border my-3">
        <h1>Place For Video</h1>
    </div>
    <div class="container h-50 ">
        <n-carousel :show-arrow="post.images.length>1" class="rounded my-3">
            <img v-for="image in post.images" :key="image.id" class="carousel-img" :src="'/storage/blog/'+image.name">
        </n-carousel>
    </div>
    <p class="">{{post.body}} Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio est laborum nobis unde vitae fuga veritatis a natus harum ab? A placeat velit vitae maiores esse, nihil maxime cumque iusto. </p>

</template>



<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NCarousel } from 'naive-ui';

const props = defineProps(['post']);

</script>
<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>