<template >

    <div class="col-12 shadow contentt" v-if="even">
        <div class="mb-3">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <n-carousel keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img :src="'img/1.jpeg'" class="img-fluid rounded-start" alt="...">
                        <img :src="'img/2.jpeg'" class="img-fluid rounded-start" alt="...">
                    </n-carousel>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="body m-3 overflow-auto rounded-3">
                        <h5 class="title text-center">{{ place.name }}</h5>
                        <p class="text">{{ place.body }}</p>
                        <p class="text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 shadow contentt" v-else>
        <div class="mb-3">
            <div class="row g-0 ">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="body m-3 overflow-auto rounded-3">
                        <h5 class="title text-center">{{ place.name }}</h5>
                        <p class="text">{{ place.body }}</p>
                        <p class="text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <n-carousel keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img :src="'img/1.jpeg'" class="img-fluid rounded-start" alt="...">
                        <img :src="'img/2.jpeg'" class="img-fluid rounded-start" alt="...">
                    </n-carousel>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { NCarousel } from 'naive-ui';
import {ref} from 'vue';
let direction = ref('vertical');
defineProps(["place", "even"])
</script>
<style>
    .contentt:hover{
        border-radius: 15%;
        background: rgb(246, 244, 244);
    }
</style>