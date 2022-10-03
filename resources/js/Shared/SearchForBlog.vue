<template>
    <div class="d-flex container-fluid justify-content-center mt-3" style="align-items:center">
        <Splide class="border-3 container-fluid border-top rounded-3" :options="{ 
                    rewind : true,
                   perPage: 3,
                   height: '4.1rem',
                   width: '50rem',
                   draggable: true,
                    arrows: false,
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
                <SplideSlide v-if="subject!=null || subject!=undefined" @click="f_subject = subject.id">
                    <h5 class="mx-3" :class="{'border-bottom':f_subject==subject.id}"
                        style="align-self:center;">
                        {{subject.name}}</h5>
                </SplideSlide>
                <SplideSlide v-for="ssubject in subjects" :key="ssubject.id" @click="f_subject = ssubject.id">
                    <h5 class="mx-3 text-dark" :class="{'border-bottom':f_subject==ssubject.id}"
                        style="align-self:center;">
                        {{ssubject.name}}</h5>
                </SplideSlide>
                <!-- <SplideSlide v-for="subject in subjects" :key="subject.name" @click="f_subject = subject.id">
                    <h5 class="mx-3 text-dark" :class="{'border-bottom':f_subject==subject.id}" style="align-self:center;">
                        {{subject.name}}</h5>
            </SplideSlide> -->
        </Splide>
    </div>

    <div class="d-flex justify-content-center" style="align-items:center;">
        <n-input ref="searchforposts" type="text" placeholder="Search" v-model:value="vsearch" round clearable autosize
            style="min-width: 50%;">
            <template #clear-icon>
                <n-icon :component="TextClearFormatting16Regular" />
            </template>
        </n-input>
    </div>
</template>

<script setup>
import '@splidejs/vue-splide/css';
import { NInput, NIcon } from 'naive-ui';
import { TextClearFormatting16Regular } from '@vicons/fluent';
import { onMounted, ref, watch } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';


const props = defineProps(['subject', 'subjects', 'search']);
const emits = defineEmits(['forPosts'])

let vsearch = ref(props.search);
let f_subject = ref(props.subject?props.subject.id:props.subject);
let searchforposts = ref(null);

onMounted(() => {
    searchforposts.value.focus();
}),
watch([f_subject, vsearch,], ([newsubject, newsearch,], [oldsubject, oldsearch,]) => {
     emits('forPosts', { newsubject, newsearch });
})

</script>