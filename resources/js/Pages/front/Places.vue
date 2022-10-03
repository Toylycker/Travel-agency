<template>

    <Head title="Places" />

    <div class="d-flex justify-content-between">
        <div class="">
            <h1>Places</h1>
        </div>
        <div class="d-flex">
            <div class="mx-3">
                <n-input-group class="mt-3 d-flex">
                    <n-select v-model:value="location" label-field="name" value-field="id" filterable
                        :options="showlocations" />
                    <n-select v-model:value="category" label-field="name" value-field="name" filterable
                        :options="showcategories" />
                    <n-input v-model:value="vsearch" type="text" placeholder="search..." clearable>
                        <template #clear-icon>
                            <n-icon :component="TextClearFormatting16Regular" />
                        </template>
                    </n-input>
                    <n-button round @click="searchposts()" :disabled="vsearch == null && category ==null && location==null">
                        <span v-show="vsearch != null || category !=null||location!=null">{{potentialSearchResultLength}}</span>
                        <template #icon>
                            <n-icon :component="Search16Regular">
                            </n-icon>
                        </template>
                    </n-button>
                </n-input-group>
            </div>
        </div>
    </div>

    <div v-if="show">
        <transition-group tag="div" name="plist" :appear="true" @before-enter="beforeEnter" @enter="enter">
            <Place @click="showPLace(place.id)" class="mx-3 place" v-for="(place, index) in places.data" :data-index="index" :key="place.id"
                :place="place" :even="(index % 2 === 0)?true :false"></Place>
        </transition-group>

        <!-- Paginator  -->
        <Pagination :links='places.links' />
    </div>

    <div v-else class="text-center">
        <h3>Sorry. We could not find matching information.</h3>
        <img :src="'img/noMatch.png'" class="img-fluid rounded-start" alt="..." style="object-fit: contain;">
    </div>



</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Place from '@/Shared/Place.vue';
import Pagination from '@/Shared/Pagination.vue';
import { computed, onMounted, ref, TransitionGroup, watch } from "vue";
import { Inertia } from '@inertiajs/inertia';
import gsap from 'gsap';
import { NSelect, NInput, NInputGroup, NIcon, NButton } from 'naive-ui';
import { TextClearFormatting16Regular, Search16Regular } from '@vicons/fluent';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);

let props = defineProps(
    [
        'places',
        'categories',
        'title',
        'search',
        'category',
        'show',
        'locations',
        'location',
        'potentialSearchResultLength'
]
)

let vsearch = ref(props.search);
let category = ref(props.category);
let location = ref(props.location?props.location.id:props.location);


let categoriesWithAll = ref([]);
const showcategories = computed(() => {
    categoriesWithAll = props.categories
    categoriesWithAll.splice(0, 0, { 'id': 0, 'name': 'all' });
    return categoriesWithAll;
})

let locationWithAll = ref([]);
const showlocations = computed(() => {
    locationWithAll = props.locations
    locationWithAll.splice(0, 0, { 'id': 0, 'name': 'all' });
    return locationWithAll;
})

let showPLace = (id)=>{
    // console.log('clicked');
    Inertia.get('places/show/'+id);
}

function searchposts(){
    Inertia.get('/places', { search: vsearch.value, category: category.value, location:location.value, count:props.potentialSearchResultLength }, { replace: true });
    console.log(category.value + '/////'+vsearch.value);
}

watch([vsearch, category, location], ([newsearch, newcategory, newlocation], [prevsearch,  prevcategory, prevlocation], ) => {
    console.log(newsearch+''+newcategory+''+newlocation);
    Inertia.get('/places/resultlength', { search: newsearch, category: newcategory, location:newlocation }, { preserveState: true, only: ['potentialSearchResultLength'], replace: true });
})



// animation stuff start

const beforeEnter = (el) => {
    gsap.from(el, {
        x: el.dataset.index % 2 === 0 ? 300 : -300,
        opacity: 0
    })
    // el.style.transform = el.dataset.index % 2 === 0 ? 'translateX(300px)' : 'translateX(-300px)'
    // el.style.transform = 'translateX(100px)';
    // el.style.opacity = 0;
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
        opacity: 1,
        duration: 1.2,
        x: 0,
        y: 0,
        ease: 'bounce.out',
        // onComplete: ScrollTrigger.disable(),
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