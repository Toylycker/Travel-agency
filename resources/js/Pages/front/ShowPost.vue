<template>
    <div v-if="post.videos.length>0" class="container-fluid text-center border my-3">
        <h1>Place For Video</h1>
    </div>
    <div class="container h-50 ">
        <n-carousel :show-arrow="post.images.length>1" class="rounded my-3">
            <img v-for="image in post.images" :key="image.id" class="carousel-img" :src="'/storage/blog/'+image.name">
        </n-carousel>
    </div>
    <p class="container">{{post.body}} lorem</p>


    <div class="container g-0" v-for="(text, i) in post.texts" :key="text.id" :data-i="i">
            <h4 v-if="text.title" class="text-center">{{ text.title }}</h4>
            <div class="clearfix m-3">
                <!-- <img :src="'/img/1.jpeg'" alt="..."
                    class="col-md-4 mb-3 m-md-2 img-fluid img h-25" :class="(i % 2===0)?'float-md-start':'float-md-end'"> -->
                <div v-if="text.images.length > 0" class="col-md-4 mb-3 m-md-2 img-fluid img h-25"
                    :class="(i % 2 === 0) ? 'float-md-start' : 'float-md-end'">
                    <div :id="'text_image' + text.id" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div v-for="imag in text.images" :key="imag.id" class="carousel-item active">
                                <!-- <img src="..." class="d-block w-100" alt="..."> -->
                                <img :src="'/storage/texts/' + imag.name" class="img-fluid d-block rounded w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" :data-bs-target="'#text_image' + text.id"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" :data-bs-target="'#text_image' + text.id"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
                <div>
                    <p>
                        {{ text.body }}
                    </p>
                </div>
            </div>
        </div>
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