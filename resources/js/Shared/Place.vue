<template >

    <div class="col-12 shadow contentt g-0"  v-if="even" style="background:white;" onmouseover="this.style.background='rgb(49, 208, 223)';" onmouseout="this.style.background='white';">
        <div class="mb-3">
            <div class="row g-0">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <n-carousel v-if="place.images.length>=1" keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img v-for="image in place.images" :src="'/storage/places/'+image.name" :key="image.id" class="img-fluid rounded-start" alt="...">
                    </n-carousel>
                    <n-carousel v-else keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img :src="'/img/1.jpeg'" class="img-fluid rounded-start" alt="...">
                        <img :src="'/img/2.jpeg'" class="img-fluid rounded-start" alt="...">
                    </n-carousel>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 ">
                    <div class="body overflow-auto rounded-3">
                        <div class="container-fluid" style="height:230px">
                            <h5 class="title text-center">{{ place.name }}</h5>
                            <p class="text">{{ place.body }}</p>
                            <p class="text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 shadow contentt" v-else style="background:white;" onmouseover="this.style.background='rgb(49, 208, 223)';" onmouseout="this.style.background='white';">
        <div class="mb-3">
            <div class="row g-0 ">
                <div class="col-lg-9 col-md-8 col-sm-12 ">
                    <div class="body overflow-auto rounded-3">
                        <div class="container-fluid" style="height:230px">
                            <h5 class="title text-center">{{ place.name }}</h5>
                            <p class="text overflow-auto">{{ place.body }}
                            </p>
                            <!-- <p class="text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <n-carousel v-if="place.images.length>=1" keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img v-for="image in place.images" :src="'/storage/places/'+image.name" :key="image.id" class="img-fluid rounded-end" alt="...">
                    </n-carousel>
                    <n-carousel v-else keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img :src="'/img/1.jpeg'" class="img-fluid rounded-end" alt="...">
                        <img :src="'/img/2.jpeg'" class="img-fluid rounded-end" alt="...">
                    </n-carousel>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { Inertia } from '@inertiajs/inertia';
import { NCarousel } from 'naive-ui';
import {ref} from 'vue';
let direction = ref('vertical');
defineProps(["place", "even"]);
</script>
<style>
    .contentt:hover{
        border-radius: 15px;
    }
</style>