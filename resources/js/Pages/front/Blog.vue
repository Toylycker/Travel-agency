<template>

    <Head title="Blog" />

    <div class="d-flex container-fluid justify-content-center mt-3" style="align-items:center">
        <Splide class="border-3 container-fluid border-top" :options="{ 
                    rewind : true,
                   perPage: 3,
                   height: '4.1rem',
                   width: '50rem',
                   draggable: true,
                    arrows: false,
                    type   : 'loop',
                    breakpoints: {
            1024: {
              perPage: 3,
             
            },
            767: {
              perPage: 2,
          
            },
            640: {
              perPage: 2,
        
            },
          },
        }" aria-label="My Favorite Subjects">
            <SplideSlide @click="f_subject = 0">
                <h5 class="mx-3" :class="{'border-bottom':f_subject==false || f_subject==0 || f_subject==undefined}"
                    style="align-self:center;">
                    All</h5>
            </SplideSlide>
            <SplideSlide v-for="subject in subjects" :key="subject.id" @click="f_subject = subject.id">
                <h5 class="mx-3" :class="{'border-bottom':f_subject==subject.id}" style="align-self:center;">
                    {{subject.name}}</h5>
            </SplideSlide>
        </Splide>
    </div>

    <div class="d-flex justify-content-center" style="align-items:center;">
        <n-input type="text" placeholder="Search" v-model:value="search" round clearable autosize
            style="min-width: 50%;">
            <template #clear-icon>
                <n-icon :component="TextClearFormatting16Regular" />
            </template>
        </n-input>
    </div>

    <div v-if="show">
        <transition-group class="row justify-content-center my-3" tag="div" :appear="true"
            @before-enter="beforeEnter" @enter="enter">
            <div v-for="(post, i) in posts.data" :key="post.id" :data-i="i"
                class="col-lg-4 col-md-6 col-sm-12 my-3">
                <div class="position-relative tm-thumbnail-container">
                    <img :src="'img/1.jpeg'" class="img-fluid rounded-start img" alt="...">
                </div>
                <div class="p-4 overflow-hidden shadow content rounded-start">
                    <div class="rounded-3 overflow-hidden" style="height: 250px;">
                        <h3 class="tm-text-primary mb-3 overflow-hidden tm-catalog-item-title">{{post.title}}</h3>
                        <p class="tm-catalog-item-text overflow-hidden" style="word-wrap: break-word;">{{post.body}}
                        </p>
                    </div>
                </div>
            </div>
        </transition-group>

        <div class="my-3">
            <Pagination :links='posts.links'></Pagination>
        </div>
    </div>


    <div v-else class="text-center">
        <h3>Sorry. We could not find matching information.</h3>
        <img :src="'img/noMatch.png'" class="img-fluid rounded-start" alt="..." style="object-fit: contain;">
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, watch } from '@vue/runtime-core';
import '@splidejs/vue-splide/css';
import Pagination from '@/Shared/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import { NInput, NIcon } from 'naive-ui';
import { TextClearFormatting16Regular } from '@vicons/fluent';
import gsap from 'gsap/all';

const props = defineProps(['posts', 'f_subject', 'subjects', 'search', 'show']);

let f_subject = ref(props.f_subject);
let search = ref(props.search);

watch([f_subject, search,], ([newsubject, newsearch,], [oldsubject, oldsearch,]) => {
    console.log('wacthed');
    Inertia.get('/blog', { subject: newsubject, search: newsearch }, { preserveState: true, replace: true });
})

// staggered animation effect start
const beforeEnter = (el) =>{
    el.style.opacity = 0;
    el.style.transform = 'translateY(100px)';
}
const enter = (el, done) =>{
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 1.2,
        onComplete: done,
        delay: el.dataset.i * 0.2,
        repeatRefresh: true
    }
    );

}
// staggered animation effect end


</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
import { secondsInDay } from 'date-fns';
export default { layout: FrontLayout }
</script>

<style>
.img:hover {
    scale: 1.05;
    transform: rotate(3deg);
}

.content:hover {
    transform: translateY(10px);
    transform: rotate(-3deg);
}
</style>