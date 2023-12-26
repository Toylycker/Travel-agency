<template>
    <div v-if="place.videos.length>0" class="container-fluid text-center border my-3">
        <h1>PLace For Video</h1>
    </div>
    <div class="row ">
        <div :class="place.map!=undefined?'col-6':'col-12'">
            <div id="placeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div v-for="image in place.images" :key="image.id" class="carousel-item active">
                        <!-- <img src="..." class="d-block w-100" alt="..."> -->
                        <img :src="'/storage/places/' + image.name" class="img-fluid d-block rounded w-100">
                    </div>
                </div>
                <button v-if="place.images.length > 1" class="carousel-control-prev" type="button"
                    data-bs-target="#placeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button v-if="place.images.length > 1" class="carousel-control-next" type="button"
                    data-bs-target="#placeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div v-if="place.map !=undefined" class="col-6">
            <iframe
                :src='place.map'
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>
    </div>
    <div>
        <div class="container g-0 bg-white rounded-3 mt-1" style="opacity: 0.90;" v-for="(text, i) in place.texts" :key="text.id" :data-i="i">
            <h3 v-if="text.title" class="text-center bold">{{ text.title }}</h3>
            <div class="clearfix m-3">
                <!-- <img :src="'/img/1.jpeg'" alt="..."
                    class="col-md-4 mb-3 m-md-2 img-fluid img h-25" :class="(i % 2===0)?'float-md-start':'float-md-end'"> -->
                <div v-if="text.images.length > 0" class="col-md-4 mb-3 m-md-2 img-fluid img h-25"
                    :class="(i % 2 === 0) ? 'float-md-start' : 'float-md-end'">
                    <n-carousel :dot-placement="direction === 'vertical' ? 'right' : 'bottom'"  :draggable="text.images.length>=2?true:false" :show-arrow="text.images.length>=2?true:false">
                        <img v-for="imag in text.images" :key="imag.id" :src="'/storage/texts/'+imag.name" class="img-fluid rounded-start" >
                    </n-carousel>
                </div>
                <div >
                    <h4>
                        {{ $langBody(text) }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
</template>



<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NCarousel } from 'naive-ui';
import { ref } from 'vue';
const props = defineProps(['place']);
let direction = ref('vertical');

</script>
<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>