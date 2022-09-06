<template>

    <Head title="Places" />

    <div class="d-flex justify-content-between">
        <div class="">
            <p id="hello">Places</p>
        </div>
        <div class="d-flex">
            <div class="mx-3">
                <n-input-group class="mt-3 d-flex">
                    <n-select v-model:value="category" label-field="name" value-field="name" filterable
                        :options="showcategories" />
                    <n-input v-model:value="search" type="text" placeholder="search..." />
                </n-input-group>
            </div>
        </div>
    </div>
    <transition-group tag="div" name="plist" :appear="true" @before-enter="beforeEnter" @enter="enter">
        <Place class="mx-3 place" v-for="(place, index) in places.data" :data-index="index" :key="place.id" :place="place"
            :even="true ? (index % 2 === 0) :false"></Place>
    </transition-group>

    <!-- Paginator  -->
    <span>{{plalen}}</span>
    <Pagination :links='places.links'/>



</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Place from '@/Shared/Place.vue';
import Pagination from '@/Shared/Pagination.vue';
import { computed, onMounted, ref, TransitionGroup, watch } from "vue";
import { Inertia } from '@inertiajs/inertia';
import gsap from 'gsap';
import { NSelect, NInput, NInputGroup } from 'naive-ui';
import {ScrollTrigger} from 'gsap/ScrollTrigger'
gsap.registerPlugin(ScrollTrigger);

let props = defineProps(
    {
        'places': Object,
        'categories': Array,
        'title': String,
        'search': String,
        'category': String
    }
)

let search = ref(props.search);
let category = ref(props.category);
let some = ref([]);

const showcategories = computed(() => {
    some=props.categories
    some.splice(0,0,{'id':0, 'name':'all'});
    return some;
})

const plalen = computed(()=>{
    return props.places.data.length
})


watch([search, category],([newsearch, newcategory], [prevsearch, prevcategory]) => {
    console.log(newsearch);
    console.log(newcategory);
    Inertia.get('/places', { search: newsearch, category: newcategory}, { preserveState: true, replace: true });
})

// animation stuff start

const beforeEnter = (el) => {
    gsap.from(el, {
        x: el.dataset.index % 2 === 0 ? 300 : -300,
        opacity:0
    })
    // el.style.transform = el.dataset.index % 2 === 0 ? 'translateX(300px)' : 'translateX(-300px)'
    // el.style.opacity = 0
}

const enter = (el, done) => {
    gsap.to(el, {
        scrollTrigger: {
            trigger: el,
            // scrub: true,
            // start: 'top 90',
            // end: 'top 80%',
            // markers: true,
            onUpdate: (self) => {
                ScrollTrigger.refresh();
    }
        },
        duration: 1.2,
        x: 0,
        y: 0,
        // opacity: 1,
        ease: 'bounce.out',
        // onComplete: done,
        // delay: 0.2,
    })
}
// animation stuff end
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style scoped>
#hello {
    font-size: 50px;
}

/* .plist-move{
    opacity: 0;
    transition: all 0.6 ease;
} */
/*.plist-enter-to{
    opacity: 1;
    transform: scale(1);
}
.plist-enter-active{
    transition: all 0.7s ease;
} */
</style>