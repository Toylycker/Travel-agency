<template >
    <section class="tour">
        <div v-if="tour.map != undefined" class="container rounded mt-3">
            <iframe :src='tour.map' width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="row mt-3" style="">
            <div v-if="tour.images.length >= 1" class="col-lg-3 col-md-4 col-sm-12 order-1">
                <div class="container">
                    <swiper :effect="'cube'" :grabCursor="true" :cubeEffect="{
                        shadow: true,
                        slideShadows: true,
                        shadowOffset: 20,
                        shadowScale: 0.94,
                    }" :pagination="true" :modules="modules" class="mySwiper">
                        <swiper-slide v-for="image in tour.images" :key="image.id">
                            <img :src="'/storage/tours/' + image.name" />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
            <div :class="tour.images.length >= 1?'col-lg-9 col-md-8':'col-lg-12 col-md-12'" class="col-sm-12 order-2">
                <n-tabs type="line" trigger="hover" class="container">
                    <n-tab-pane name="oasis" :tab="$t('Description')">
                        <div class="container h-50 overflow-auto border rounded mb-1">
                            {{ $langBody(tour)}}
                        </div>
                        <div class="container h-50 overflow-auto border rounded">
                            <div class="row m-1">
                                <div class="col-lg-10 col-md-8 col-sm-12 ">
                                    <div class="row">
                                        <div class="col-6 border-bottom rounded-3" v-for="price in tour.prices"
                                            :key="price.id">
                                            <p>{{ $langName(price) }}:{{ price.price }}$</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12 my-3 border-start">
                                    <div class="col-12 container-fluid border-bottom h-50 w-100">places:{{ total_places }}
                                    </div>
                                    <div class="col-12 container-fluid h-50 w-100">days:{{ days.length }}</div>
                                </div>
                            </div>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="includes" :tab="$t('Includes')">
                        <div v-for="(include) in tour.notes" :key=include.id data:a="a">
                            <h5 v-if="include.pivot.status === 'included'"> {{ '-' }}{{ $langName(include)}}</h5>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="non included" :tab="$t('NonIncluded')">
                        <div v-for="(include) in tour.notes" :key=include.name data:i="i">
                            <h5 v-if="include.pivot.status === 'non included'">{{ '-' }} {{ $langName(include) }}</h5>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="What should i know" :tab="$t('WhatShouldIKnow')">
                        <span>{{$t('WhatShouldIKnow1text')}}</span>
                        <br>
                        <span>{{$t('Cash')}}</span>
                        <br>
                        <span>{{$t('WhatShouldIKnow2text')}}</span>
                    </n-tab-pane>
                </n-tabs>
            </div>
        </div>
    </section>
    <br>
    <section class="days">
        <div class="container mt-3">
            <div class="overflow-auto p-3">
                <n-steps vertical v-model:current="current" :status="currentStatus" class="overflow m-3">
                    <n-step v-for="day in days" :key='day.id' :title="'-'+$t('Day')">
                        <div class="">
                            <div class=" container border border-success rounded">
                                {{ $langBody(day) }}
                            </div>
                            <div v-if="day.places.length > 0">
                                <div>
                                    <div class=" border-start border-success rounded">
                                        <h5 class="border-bottom">{{$t('Places')}}</h5>
                                        <p v-for="(place, index) in day.places" :key="place.id">
                                            <Link :href="route('place.show', place.id)" method="get" as="button">{{
                                               index+1 + ')'+' '+ $langName(place) }}</Link>
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
    <section class="apply container">
        <n-alert v-if="form.wasSuccessful" :title="$t('SuccessfullyApplied')" type="success" closable>
            {{$t('ThanksForChoosingUs')}}
        </n-alert>
        <n-button type="primary" class="w-100 my-3" @click="showModal = true" dashed>
            {{$t('ApplyForThisTour')}}
        </n-button>
    </section>
    <n-modal v-model:show="showModal" preset="dialog" title="Please submit your information" negative-text="Cancel">
        <div class="container">
            <n-form :label-width="80" :model="form" :rules="rules">
                <n-form-item :label="$t('Name')" path="name">
                    <n-input v-model:value="form.name" placeholder="Input Name" type="text" :allow-input="onlyLetter" />
                </n-form-item>
                <n-form-item :label="$t('Surname')" path="surname">
                    <n-input v-model:value="form.surname" placeholder="Input Surname" type="text"
                        :allow-input="onlyLetter" />
                </n-form-item>
                <n-form-item :label="$t('WhereAreYouFrom')" path="country_id">
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.country_id" filterable
                        placeholder="Please Select Your Country" :options="countries" />
                </n-form-item>
                <n-form-item :label="$t('Email')" path="email">
                    <n-auto-complete v-model:value="form.email" :options="CompleteOptions" placeholder="Email" />
                </n-form-item>
                <n-form-item :label="$t('Phone')" path="phone">
                    <n-input v-model:value="form.phone" placeholder="Phone Number" :allow-input="onlyAllowNumber"
                        :minlength=7 />
                </n-form-item>
                <n-form-item :label="$t('PleaseChooseDesiredTour')" path="tour_id">
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.tour_id" filterable
                        placeholder="Please choose desired tour" :options="tours" />
                </n-form-item>
                <n-form-item :label="$t('HowManyPeople')" path="quantity">
                    <n-input-number v-model:value="form.quantity" :min="0" placeholder="How many people?" />
                </n-form-item>
                <n-form-item :label="$t('PlannedArrivalTime')" path="arrival">
                    <!-- <n-date-picker value-format="yyyy-MM-dd" v-model:value="form.arrival" type="date" /> -->
                    <input type="date" class="form-control" v-model="form.arrival">
                </n-form-item>
                <n-form-item :label="$t('PlannedDepartureTime')" path="departure">
                    <!-- <n-date-picker v-model:value="form.departure" type="date" /> -->
                    <input type="date" class="form-control" v-model="form.departure">
                </n-form-item>
                <n-form-item :label="$t('AnyNotesOrQuestions')" path="note">
                    <n-input type="textarea" maxlength="300" show-count clearable v-model:value="form.note"
                        placeholder="" />
                </n-form-item>
            </n-form>
            <n-button
                @click="form.post(route('application.store'), { onSuccess: () => { form.reset(); showModal = false; } })"
                class="w-100" ghost type="success"
                :disabled="form.processing || form.name == null || form.name == '' || form.surname == null || form.surname == '' || form.country_id == null || form.country_id == '' || form.email == null || form.email == '' || form.phone == null || form.phone == '' || form.tour_id == null">
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
import { NProgress, NSteps, NStep, NTabs, NTabPane, NButton, NModal, NForm, NFormItem, NInput, NSelect, NAutoComplete, NInputNumber, NDatePicker, NAlert } from 'naive-ui';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import { ref, computed } from '@vue/runtime-core';
import "swiper/css/effect-cube";
import "swiper/css/pagination";
import { EffectCube, Pagination } from "swiper";
const props = defineProps(['tour', 'days', 'countries', 'tours', 'images']);
const form = useForm({
    'name': null,
    'surname': null,
    'country_id': null,
    'email': '',
    'phone': null,
    'tour_id': props.tour.id,
    'quantity': null,
    'arrival': null,
    'departure': null,
    'note': null,
});

let onlyAllowNumber = (value) => !value || /^\d+$/.test(value);
let onlyLetter = (value) => !value || /^[a-zA-Z]+$/.test(value);
const rules = {
    'name': {
        required: true,
        message: 'Please input your name',
        trigger: 'blur'
    },
    'surname': {
        required: true,
        message: 'Please input your name',
        trigger: 'blur'
    },
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
    'phone': {
        required: true,
        message: 'Please input your phone number',
        trigger: 'input'
    },
    'tour_id': {
        type: 'number',
        required: true,
        message: 'Please choose your desired tour',
        trigger: 'blur'
    },
};

const showModal = ref(false);
let modules = [EffectCube, Pagination];
const currentStatus = ref("process");
const current = ref(1);

let total = ref(0);

const total_places = computed(() => {
    total.value = 0;
    props.days.forEach(day => {
        total.value += day.places.length;
    });
    return total.value;
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


</script>
<script>
import { Link } from '@inertiajs/inertia-vue3';
import FrontLayout from '@/Layouts/frontLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default { layout: FrontLayout }
</script>


<!-- @positive-click="form.post(route('admin.places.store'), {onSuccess: () => form.reset()})"
@negative-click="cancelCallback" -->