<template>
    <div class="container-fluid pt-3 text-center justify-content-center align-items-center bg-image"
        :class="{ 'tourleft': upplace == 'left', 'tourright': upplace == 'right' }"
        :style="{backgroundImage:`url(${'img/tour_background.png'})`}"
        style="background-size: contain;background-position: center;  background-repeat: no-repeat;" id="tour">
        <div class="d-md-flex ">
            <transition class="order-md-0 order-sm-2 bg-white" :appear="true" name="left">
                <div @mouseover="getleft($event)" @mouseleave="leaveCursor($event)" id="left"
                    class="col-md-6 col-lg-4 mr-3  shadow rounded-3 overflow-hidden" :class="'float'"
                    style="border-bottom-left-radius: 20px; height: 170px;text-align: left;">
                    <div class="mx-1">
                        <n-button class="my-2 w-100" style="text-align: center;" type="primary" dashed ghost>
                            <h5>{{ $langName(tour) }}</h5>
                        </n-button>
                        <!-- <h3 class="mt-2" style="text-align: center;">{{ tour.name }}</h3> -->
                        <div class="container">
                            <n-button-group class="w-100" vertical>
                                <n-button class="w-100" type="primary" round dashed>
                                    {{$t('TotalDays')}}:{{ tour.total_days }}
                                </n-button>


                                <n-button class="w-100" type="primary" ghost dashed>
                                    {{ $t('VisitingPlaces') }}:{{ total_places_count }}
                                </n-button>


                                <n-button class="w-100" type="primary" ghost round dashed>
                                    {{ $t('Price') }}:{{ tour.tour_prices }}$
                                </n-button>
                            </n-button-group>


                        </div>
                    </div>
                </div>
            </transition>
            <transition class="order-md-1 order-sm-0" :appear="true" name="center">
                <div @mouseover="getcenter()" @mouseleave="leaveCursor($event)"
                    class="col-md-6 col-lg-4 mx-3 bg-white shadow rounded-3" id="center" style="height: 170px;">
                    <!-- <iframe
                        src="https://www.google.com/maps/embed?pb=!1m52!1m12!1m3!1d3178032.860928466!2d58.36552423384894!3d38.934313986368686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m37!3e0!4m5!1s0x3f6ffe1bab3684d9%3A0x3cde013f62d3ade9!2sAshgabat%2C%20Turkmenistan!3m2!1d37.9600766!2d58.3260629!4m5!1s0x402c1a2c8507ce31%3A0xc0682af196323024!2sAwaza%20der%C3%BDa%2C%20Turkmenistan!3m2!1d39.958283099999996!2d52.8569665!4m5!1s0x3f62b4f7b4d79731%3A0x1b7a8833c89ceca!2sDerweze%2C%20Turkmenistan!3m2!1d40.173957099999996!2d58.4169385!4m5!1s0x3f4170abd6e93cc7%3A0xbbae37e82e0dccce!2sMerv%2C%20Turkmenistan!3m2!1d37.664426!2d62.1747186!4m5!1s0x3f44e0040d5c38dd%3A0x5ca437696975e741!2sTurkmenabat%2C%20Turkmenistan!3m2!1d39.0041313!2d63.568808!4m5!1s0x41ddad1280665aad%3A0xbc519b36baa4f375!2zS8O2bmXDvHJnZW5jaCwgVHVya21lbmlzdGFu!3m2!1d42.324218699999996!2d59.1818543!5e0!3m2!1sen!2sus!4v1662656011952!5m2!1sen!2sus"
                        width="100%" height="100%" style="border:0;"  class="rounded-3" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                    <img style="height: 170px;"  v-if="tour.main_image" class="rounded-3 img-fluid rounded-start w-100"
                        :src="'/storage/tours/' + tour.main_image" alt="...">
                    
                    <img style="height: 170px;" v-else class="rounded-3 img-fluid rounded-start w-100" :src="'/img/turkmenistan.jpeg'"
                        alt="...">
                
                </div>
            </transition>
            <transition class="order-md-2 order-sm-3" :appear="true" name="right">
                <div @mouseover="getright($event)" @mouseleave="leaveCursor($event)" id="right"
                    class="col-4 ml-3 bg-white shadow overflow-hidden rounded-3 d-none d-md-block" :class="'float'"
                    style="border-top-right-radius: 20px;height: 170px;">
                    <p class="m-3">{{ $langBody(tour)}}</p>
                </div>
            </transition>
        </div>
    </div>
</template>
<script setup>
import gsap from 'gsap';
import { isInteger } from 'lodash-es';
import { NImage, NButton, NButtonGroup } from 'naive-ui';
import { computed, onMounted, onUnmounted, onBeforeUnmount, ref, Transition, watch } from 'vue';
import { Sine } from 'gsap/all';
import { Inertia } from '@inertiajs/inertia';
let direction = ref('vertical');
const props = defineProps(['tour', 'index'])
let total_places = ref(0);
let upplace = ref('');

// onUnmounted(()=>{
//     gsap.globalTimeline.clear();
// });


// ^^^ here mounted finished

function getleft($e) {
    upplace.value = 'left'
    gsap.globalTimeline.pause();
}
function getcenter($e) {
    gsap.globalTimeline.pause();
}
function getright($e) {
    upplace.value = 'right'
    gsap.globalTimeline.pause();
}

function leaveCursor($event) {
    upplace.value = '';
    gsap.globalTimeline.resume();
}

const total_places_count = computed(() => {
    props.tour.days.forEach(day => {
        total_places.value += day.places_count;
    });
    return total_places;
})

onBeforeUnmount(() => {
    gsap.globalTimeline.resume();
});

</script>
<style>
/* enter start */
.left-enter-from {
    opacity: 0;
    transform: translateX(-300px);
}

.center-enter-from {
    opacity: 0;
    scale: 0;

}

.right-enter-from {
    opacity: 0;
    transform: translateX(300px);
}

/* .left-enter-to {}

.center-enter-to {}

.right-enter-to {} */

.left-enter-active {
    transition: all 1s ease;
}

.center-enter-active {
    transition: all 1s ease;
}

.right-enter-active {
    transition: all 1s ease;
}

/* enter end  */
/* leave start */

.left-leave-from {
    opacity: 1;
}

.center-leave-from {
    opacity: 1;
}

.right-leave-from {
    opacity: 1;
}

.left-leave-to {
    opacity: 0;
}

.center-leave-to {
    opacity: 0;
}

.right-leave-to {
    opacity: 0;
}

.left-leave-active {
    transition: all 1s ease;
}

.center-leave-active {
    transition: all 1s ease;
}

.right-leave-active {
    transition: all 1s ease;
}

.tourleft:hover {
    transform: rotate(3deg);
}

.tourright:hover {
    transform: rotate(-3deg);
}

/* .tourcenter:hover {
    transform: rotate(-3deg);
    scale: 1.05;
} */

#tour:hover {
    /* transform: rotate(-3deg); */
    scale: 1.1;
}
</style>