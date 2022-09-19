<template>

    <Head title="Blog" />

    <SearchForBlogVue :subjects='subjects' :search='search' :subject='subject' @for-posts='getPosts' />

    <div v-if="show">
        <transition-group class="row justify-content-center my-3" tag="div" :appear="true"
            @before-enter="beforeEnter" @enter="enter">
                <PostForBlogVue v-for="(post, i) in posts.data" :key="post.id" :data-i="i" :post="post" />
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
import SearchForBlogVue from '@/Shared/SearchForBlog.vue';
import gsap from 'gsap/all';
import PostForBlogVue from '@/Shared/PostForBlog.vue';


const props = defineProps(['posts', 'subject', 'subjects', 'search', 'show']);


function getPosts(imports){
    // console.log(imports);
    Inertia.get('/blog', { subject: imports.newsubject, search: imports.newsearch }, {replace: true });
}

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