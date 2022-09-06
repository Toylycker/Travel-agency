<template >

    <div class="col-12 shadow" v-if="even">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-3">
                    <n-carousel keyboard :direction="direction" :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                        <img :src="'img/1.jpeg'" class="img-fluid rounded-start" alt="...">
                        <img :src="'img/2.jpeg'" class="img-fluid rounded-start" alt="...">
                    </n-carousel>
                </div>
                <div class="col-9">
                    <div class="card-body">
                        <h5 class="card-title">{{ place.name }}</h5>
                        <p class="card-text">{{ place.body }}</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 shadow" v-else>
        <div class="card mb-3">
            <div class="row g-0 ">
                <div class="col-9">
                    <div class="card-body">
                        <h5 class="card-title">{{ place.name }}</h5>
                        <p class="card-text">{{ place.body }}</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="col-3">
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
</style>