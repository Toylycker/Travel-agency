<template >
    <section class="tour">
        <div class="container rounded mt-3">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m52!1m12!1m3!1d3141354.3834198224!2d55.95944150248437!3d39.74574036457553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m37!3e0!4m5!1s0x3f7002275d506347%3A0xa3a1ece9c2b2f0ff!2sW8GR%2BMHR%20Wedding%20Palace%2C%20Ashgabat%2C%20Turkmenistan!3m2!1d37.926732!2d58.3413888!4m5!1s0x3f700281a6707c9d%3A0x98296aa2668c013c!2sBerkarar%2C%20Ataturk%20Street%2C%20Ashgabat%2C%20Turkmenistan!3m2!1d37.894030699999995!2d58.369871499999995!4m5!1s0x3f62b4f7b4d79731%3A0x1b7a8833c89ceca!2sDarvaza%2C%20Turkmenistan!3m2!1d40.173957099999996!2d58.4169385!4m5!1s0x402c1a2f5c774367%3A0x6a6b0727af24b1e0!2sAwaza%2C%20Turkmenistan!3m2!1d39.9730086!2d52.8511956!4m5!1s0x3f4176d3debc7375%3A0x3e87e3fcbafd3c8a!2sBa%C3%BDramaly%2C%20Turkmenistan!3m2!1d37.6156855!2d62.157134899999996!4m5!1s0x41ddad1280665aad%3A0xbc519b36baa4f375!2zS8O2bmXDvHJnZW5jaCwgVHVya21lbmlzdGFu!3m2!1d42.324218699999996!2d59.1818543!5e0!3m2!1sen!2shk!4v1663967113379!5m2!1sen!2shk"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="row mt-3" style="">
            <div class="col-3">
                <div class="container">
                    <swiper :effect="'cube'" :grabCursor="true" :cubeEffect="{
                      shadow: true,
                      slideShadows: true,
                      shadowOffset: 20,
                      shadowScale: 0.94,
                    }" :pagination="true" :modules="modules" class="mySwiper">
                        <swiper-slide><img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                        <swiper-slide><img src="https://swiperjs.com/demos/images/nature-2.jpg" /></swiper-slide>
                        <swiper-slide><img src="https://swiperjs.com/demos/images/nature-3.jpg" /></swiper-slide>
                        <swiper-slide><img src="https://swiperjs.com/demos/images/nature-4.jpg" /></swiper-slide>
                    </swiper>
                </div>
            </div>
            <div class="col-9">
                <n-tabs type="line" trigger="hover">
                    <n-tab-pane name="oasis" tab="Description">
                        <div class="container h-50 overflow-auto border rounded">
                            {{tour.body}}
                        </div>
                        <div class="container h-50 overflow-auto border rounded">
                            <div class="row">
                                <div class="col-10 border">
                                    <div class="row">
                                        <div class="col-6 border-bottom rounded-3" v-for="price in tour.prices" :key="price.id">
                                            <p>{{price.name}}:{{price.price}}$</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 border">
                                    <div class="col-12 container-fluid border-bottom h-50 w-100">places:{{total_places}}</div>
                                    <div class="col-12 container-fluid h-50 w-100">days:{{days.length}}</div>
                                </div>
                            </div>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="includes" tab="includes">
                        <div v-for="(include, a) in tour.notes" :key=include.id data:a="a">
                            <h5 v-if="include.pivot.status ==='included'"> {{a+1}}){{include.name}}</h5>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="non included" tab="Non included">
                        <div v-for="(include, i) in tour.notes" :key=include.name data:i="i">
                            <h5 v-if="include.pivot.status ==='non included'">{{i+1}}) {{include.name}}</h5>
                        </div>
                    </n-tab-pane>
                </n-tabs>
            </div>
        </div>
    </section>
    <br>
    <section class="days">
        <div class="container mt-3">
            <div class="overflow-auto">
                <n-steps vertical v-model:current="current" :status="currentStatus" class="overflow m-3">
                    <n-step v-for="day in days" :key='day.id' title="-day">
                        <div class="row">
                            <div class=" col-6 container border rounded">
                                {{day.body}}
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6 border-top rounded h-100">
                                        <h5 class="border-bottom">Places</h5>
                                        <p v-for="place in day.places" :key="place.id">
                                            {{place.name}}
                                        </p>
                                    </div>
                                    <div class="col-6 border-top rounded h-100">
                                        <h5 class="border-bottom">Hotels</h5>
                                        <p v-for="hotel in day.hotels" :key="hotel.id">
                                            {{hotel.name}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </n-step>
                </n-steps>
            </div>
        </div>
    </section>
</template>
<script setup>
import { NProgress, NSteps, NStep, NTabs, NTabPane } from 'naive-ui';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import { ref,computed } from '@vue/runtime-core';
import "swiper/css/effect-cube";
import "swiper/css/pagination";
import { EffectCube, Pagination } from "swiper";
const props = defineProps(['tour', 'days']);
const percentage = ref(20);
let modules = [EffectCube, Pagination];
const currentStatus = ref("process");
const current = ref(1);

let total = ref(0);

const total_places = computed(()=>{
    props.days.forEach(day => {
        total.value += day.places.length;
    });
    return total.value;
});

</script>
<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>