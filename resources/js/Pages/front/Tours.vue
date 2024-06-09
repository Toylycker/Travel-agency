<template>

    <Head title="Tours" >
    <meta name="description" content="Explore Turkmenistan with our guided tours. Discover ancient cities, natural wonders, and vibrant culture with our expertly curated tour packages. Book your adventure today!">
    <meta name="keywords" content="Turkmenistan tours, guided tours Turkmenistan, Turkmenistan travel packages, explore Turkmenistan, Turkmenistan attractions, travel to Turkmenistan">
    </Head>
    <div >
        <Tour @click="showTour(tour.id)" v-for="(tour, index) in tours" :key="tour.id" :tour="tour" :index="index" :data-index="index"/>
        <!-- <div class="container position-absolute bottom-0 start-25 my-3">
        </div> -->
        <!-- <Pagination :links='tours.links'></Pagination> -->
    </div>

</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import gsap from 'gsap';
import Tour from '@/Shared/Tour.vue';
import Pagination from '@/Shared/Pagination.vue';
import { computed, onMounted, onUnmounted, onBeforeUnmount, ref, Transition, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';


defineProps(['tours']);

function showTour(id){
    Inertia.get('tours/show/'+id);
}

onBeforeUnmount(() => {
    gsap.globalTimeline.clear();
});
onMounted(() => {
    setTimeout(() => {
            // floating containers
            // const can = Inertia.page.component=='front/Tours'?'.float'+props.index:null;
            const can = '.float';
            const randomX = random(3, 6);//props.index % 2 === 0 ? random(10, 20) : random(15, 25);
            // const randomY = random(0);//props.index % 2 === 0 ? random(5, 10) : random(2, 6);
            const randomDelay = random(0, 1);
            const randomTime = 1;
            const randomTime2 = 1;
            const randomAngle = random(1, 5);
    
                // call functions 
                moveX(can, 1);
                // moveY(can, -1);
                // rotate(can, 1);
                // end call function 
    
            gsap.set(can, {
                x: 0,
                y: 0,
                rotation: 0
            });
    
            function rotate(target, direction) {
                if (target) {
                    gsap.to(target, {
                        duration: randomTime2,
                        rotation: randomAngle(direction),
                        // delay: randomDelay(),
                        ease: "slow(0.1, 0.1, false)",
                        onComplete: rotate,
                        onCompleteParams: [target, direction * -1]
                    });
                }
            }
    
            function moveX(target, direction) {
                if (target) {
                    gsap.to(target, {
                        duration: randomTime,
                        x: randomX(direction),
                        ease: "slow(0.1, 0.1, false)",
                        onComplete: moveX,
                        onCompleteParams: [target, direction * -1]
                    });
                }
            }
    
            function moveY(target, direction) {
                if (target) {
                    gsap.to(target, {
                        duration: randomTime,
                        // y: randomY(direction),
                        ease: "slow(0.1, 0.1, false)",
                        onComplete: moveY,
                        onCompleteParams: [target, direction * -1]
                    });
                }
            }
    
            function random(min, max) {
                const delta = max - min;
                return (direction = 1) => (min + delta * Math.random()) * direction;
            }

    }, 1200);
});

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>