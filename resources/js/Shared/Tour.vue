<template>
    <div class="container-fluid mt-3 pt-3 text-center justify-content-center align-items-center bg-image"
        :class="{'tourleft':leftup, 'tourright':leftup==false}" @mouseover="getCursor($event)"
        :style="{backgroundImage:`url(${'img/tour_background.png'})`}"
        style="object-fit: contain; background-repeat: no-repeat;">
        <div class="d-flex">
            <transition :appear="true" name="left">
                <div class="col-4 mr-3 bg-white shadow rounded-3" :class="'float'+props.index" id="left"
                    style="border-bottom-left-radius: 20px; height: 170px;text-align: left;">
                    <div class="mx-3">
                        <h3 class="mt-2" style="text-align: center;">{{tour.name}}/{{index}}/{{$page.component}}</h3>
                        <div class="row">
                            <h5 class="mx-3 col">total days:{{tour.total_days}}</h5>
                            <h5 class="my-3 col">total nights:{{tour.total_nights}}</h5>
                        </div>
                        <div class="row">
                            <h5 class="mx-3 col">visiting places:{{total_places_count}}</h5>
                            <h5 class="my-3 col">price:{{tour.price}}$</h5>
                        </div>
                    </div>
                </div>
            </transition>
            <transition :appear="true" name="center">
                <div class="col-4 mx-3 bg-white shadow rounded-3" id="center">
                    <n-carousel keyboard :direction="direction" class="rounded-3" autoplay
                        :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 170px" draggable>
                        <img :src="'img/1.jpeg'" class="img-fluid rounded-start" alt="..." style="object-fit: cover;">
                        <img :src="'img/2.jpeg'" class="img-fluid rounded-start" alt="..." style="object-fit: cover;">
                    </n-carousel>
                </div>
            </transition>
            <transition :appear="true" name="right">
                <div id="right" class="col-4 ml-3 bg-white shadow overflow-auto rounded-3" :class="'float'+props.index"
                    style="border-top-right-radius: 20px;height: 170px;">
                    <p class="m-3">{{tour.body}}</p>
                </div>
            </transition>
        </div>
    </div>
</template>
<script setup>
import gsap from 'gsap';
import { isInteger } from 'lodash-es';
import { NCarousel } from 'naive-ui';
import {computed, onMounted, onUnmounted,onBeforeUnmount, ref, Transition, watch} from 'vue';
import { Sine } from 'gsap/all';
import { Inertia } from '@inertiajs/inertia';
let direction = ref('vertical');
const props = defineProps(['tour', 'index'])
let total_places = ref(0);
let leftup = ref(false);
let page = ref(Inertia.page.component);

// onUnmounted(()=>{
//     gsap.globalTimeline.clear();
// });
onBeforeUnmount(()=>{
    gsap.globalTimeline.clear();
});
onMounted(() => {
    setTimeout(() => {
        // floating containers
    const can = Inertia.page.component=='front/Tours'?'.float'+props.index:null;
    const randomX = props.index % 2 === 0 ? random(10, 20) : random(10, 20);
    const randomY = props.index % 2 === 0 ? random(5, 10) : random(2, 6);
    const randomDelay = random(0, 1);
    const randomTime = props.index % 2 === 0 ? random(1,1) : random(1, 1);
    const randomTime2 = random(1, 1);
    const randomAngle = random(5, 2);
    
    // call functions 
    moveX(can, 1);
    moveY(can, -1);
    rotate(can, 1);
    // end call function 
    
    gsap.set(can, {
      x: 0,
      y: 0,
      rotation: 0
    });
    
    function rotate(target, direction) {
        if(target){
            gsap.to(target, {duration: randomTime2(), 
              rotation: randomAngle(direction),
              // delay: randomDelay(),
              ease: "slow(0.7, 0.7, false)",
              onComplete: rotate,
              onCompleteParams: [target, direction * -1]
            });
        }
    }
    
    function moveX(target, direction) {
        if(target){ 
            gsap.to(target, {duration:randomTime(),
              x: randomX(direction),
              ease: "slow(0.7, 0.7, false)",
              onComplete: moveX,
              onCompleteParams: [target, direction * -1]
            });
        }
    }
    
    function moveY(target, direction) {
        console.log(target);
        if(target){
            gsap.to(target, {duration:randomTime(),
              y: randomY(direction),
              ease: "slow(0.7, 0.7, false)",
              onComplete: moveY,
              onCompleteParams: [target, direction * -1]
            });
        }
    }
    
    function random(min, max) {
      const delta = max - min;
      return (direction = 1) => (min + delta * Math.random()) * direction;
    }
    }, 2000);
    console.log('mounted');
});
// ^^^ here mounted finished

const total_places_count = computed(() => {
    props.tour.days.forEach(day => {
        total_places.value += day.places_count;
    });
    return total_places;
})

function getCursor(e){
    // console.log(e.screenX);
    let divided_width = screen.width / 2;
    if (e.screenX>divided_width) {
        leftup.value = false;
    }else{
        leftup.value = true;
    }
    return console.log(leftup.value);
        
}

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
    transition: all 2s ease;
}

.center-enter-active {
    transition: all 2s ease;
}

.right-enter-active {
    transition: all 2s ease;
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
    scale: 1.05;
}

.tourright:hover {
    transform: rotate(-3deg);
    scale: 1.05;
}
</style>