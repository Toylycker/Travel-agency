<template>

    <Head title="Places">
      <meta name="description" content="Discover the top places to visit in Turkmenistan, including the ancient cities of Merv and Nisa, the stunning Darvaza Gas Crater, and the beautiful Köw Ata Underground Lake. Plan your adventure today!">
      <meta name="keywords" content="Turkmenistan travel, places to visit in Turkmenistan, Merv, Nisa, Darvaza Gas Crater, Köw Ata Underground Lake, Turkmenistan tourism, Turkmenistan attractions">
    </Head>
    <n-alert v-if="form.wasSuccessful" :title="$t('SuccessfullyApplied')" type="success" closable>
            {{$t('ThanksForChoosingUs')}}
        </n-alert>

    <div class="d-flex justify-content-between mb-3 g-0">
        <div class="">
            <h1>{{ $t('Places') }}</h1>
            <div class="bg-white container rounded-3 p-1">
                <div class="d-flex">
                    <button type="button" class="btn  btn-info btn-sm " @click="customTourStore.toggleMode">
                        {{
                            customTourStore.selection_mode ? $t('Places')+' '+ customTourStore.places.length : $t('customTour') }}
                    </button>
                    <n-tooltip v-if="!customTourStore.selection_mode" trigger="hover">
                        <template #trigger>
                            <n-button dashed class="ml-1" circle type="warning"> ? </n-button>
                        </template>
                        {{ $t('customTourChoosingExplanation') }}
                    </n-tooltip>
                    <n-tooltip v-if="customTourStore.selection_mode" trigger="hover">
                        <template #trigger>
                            <n-button @click="showModal=true" dashed class="ml-1" circle type="success"> {{$t('Done')}} </n-button>
                        </template>
                        {{$t('doneChoosing')}}
                    </n-tooltip>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <div class="mx-3">
                <n-input-group class="mt-3 d-flex">
                    <n-select class="d-none d-sm-block" v-model:value="location" label-field="name" value-field="id"
                        filterable :options="showlocations" />
                    <n-select class="d-none d-sm-block" v-model:value="category"
                        :label-field="$i18n.locale == 'eng' ? 'name' : 'name_cn'" value-field="name" filterable
                        :options="showcategories" />
                    <div>
                        <n-input v-model:value="vsearch" type="text" placeholder="search..." clearable>
                            <template #clear-icon>
                                <n-icon :component="TextClearFormatting16Regular" />
                            </template>
                        </n-input>
                    </div>
                    <n-button round @click="searchposts()"
                        :disabled="vsearch == null && category == null && location == null">
                        <span v-show="vsearch != null || category != null || location != null">{{
                            potentialSearchResultLength
                            }}</span>
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
            <Place class="place" v-for="(place, index) in places.data" :data-index="index" :key="place.id"
                :place="place" :even="(index % 2 === 0) ? true : false"></Place>
        </transition-group>

        <!-- Paginator  -->
        <Pagination :links='places.links' />
    </div>

    <div v-else class="text-center">
        <h3>Sorry. We could not find matching information.</h3>
        <img :src="'img/noMatch.png'" class="img-fluid rounded-start" alt="..." style="object-fit: contain;">
    </div>

    <n-modal v-model:show="showModal" preset="dialog" :title="$t('submitYourInformation')" negative-text="Cancel">
        <div class="container">
            <div class="shadow container rounded-3 p-1 my-2"> {{$t('selectedPlacesAre')}} {{ customTourStore.places.length }}</div>
            <n-form :label-width="80" :model="form" :rules="rules">
                <n-form-item :label="$t('WhereAreYouFrom')" path="country_id">
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.country_id" filterable
                        :placeholder="t('selectedPlacesAre')" :options="countries" />
                </n-form-item>
                <n-form-item :label="$t('Email')" path="email">
                    <n-auto-complete v-model:value="form.email" :options="CompleteOptions" placeholder="Email" />
                </n-form-item>
                <n-form-item :label="$t('AnyNotesOrQuestions')" path="note">
                    <n-input type="textarea" maxlength="300" show-count clearable v-model:value="form.note"
                        placeholder="" />
                </n-form-item>
            </n-form>
            <n-button
                @click="form.post(route('customTour.store'), { onSuccess: () => { 
                    showModal = false; 
                    customTourStore.toggleMode();
                    form.reset('country_id', 'email', 'note');
                    form.places = storedPlaces;
                     } })"
                class="w-100" ghost type="success"
                :disabled="form.country_id == null || form.country_id == '' || form.email == null || form.email == '' || form.places.length < 1 || form.processing">
                {{$t('Submit')}}
            </n-button>
            <n-alert class="my-2" v-if="Object.keys($page.props.errors).length != 0" title="Errors" type="error" closable>
                <ul>
                    <li v-for="error in $page.props.errors" :key="error.name">{{ error }}</li>
                </ul>
            </n-alert>
        </div>
    </n-modal>



</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import Place from '@/Shared/Place.vue';
import Pagination from '@/Shared/Pagination.vue';
import { computed, onMounted, ref, TransitionGroup, watch } from "vue";
import { Inertia } from '@inertiajs/inertia';
import gsap from 'gsap';
import { NInput, NInputGroup, NIcon, NButton, NTooltip, NProgress, NSteps, NStep, NTabs, NTabPane, NModal, NForm, NFormItem, NSelect, NAutoComplete, NInputNumber, NDatePicker, NAlert  } from 'naive-ui';
import { TextClearFormatting16Regular, Search16Regular } from '@vicons/fluent';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { useCustomTourStore } from '@/Stores/customTourStore';
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
gsap.globalTimeline.play()
gsap.registerPlugin(ScrollTrigger);

const customTourStore = useCustomTourStore()
const storedPlaces =  computed(() => {return customTourStore.places});

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
        'potentialSearchResultLength',
        'countries'
    ]
)
let onlyAllowNumber = (value) => !value || /^\d+$/.test(value);
let onlyLetter = (value) => !value || /^[a-zA-Z]+$/.test(value);
const rules = {
    'country_id': {
        type: 'number',
        required: true,
        message: 'Please select your country',
        trigger: ['blur', 'change']
    },
    'email': {
        required: true,
        message: 'Please input your email',
        trigger: 'blur'
    },
};

const showModal = ref(false);
const form = useForm({
    'country_id': null,
    'email': '',
    'note': null,
    'places': storedPlaces
});

const CompleteOptions = computed(() => {
    return ['@gmail.com', '@yandex.ru', '@163.com', '@qq.com'].map((suffix) => {
        const prefix = form.email.split('@')[0]
        return {
            label: prefix + suffix,
            value: prefix + suffix
        };
    });
});


let vsearch = ref(props.search);
let category = ref(props.category);
let location = ref(props.location ? props.location.id : props.location);


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


function searchposts() {
    Inertia.get('/places', { search: vsearch.value, category: category.value, location: location.value, count: props.potentialSearchResultLength }, { replace: true });
}

watch([vsearch, category, location], ([newsearch, newcategory, newlocation], [prevsearch, prevcategory, prevlocation],) => {
    Inertia.post('/places', { search: newsearch, category: newcategory, location: newlocation }, { preserveState: true, only: ['potentialSearchResultLength'], replace: true });
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