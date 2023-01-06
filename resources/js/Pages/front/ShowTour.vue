<template >
    <section class="tour">
        <div class="container rounded mt-3">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m52!1m12!1m3!1d3141354.3834198224!2d55.95944150248437!3d39.74574036457553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m37!3e0!4m5!1s0x3f7002275d506347%3A0xa3a1ece9c2b2f0ff!2sW8GR%2BMHR%20Wedding%20Palace%2C%20Ashgabat%2C%20Turkmenistan!3m2!1d37.926732!2d58.3413888!4m5!1s0x3f700281a6707c9d%3A0x98296aa2668c013c!2sBerkarar%2C%20Ataturk%20Street%2C%20Ashgabat%2C%20Turkmenistan!3m2!1d37.894030699999995!2d58.369871499999995!4m5!1s0x3f62b4f7b4d79731%3A0x1b7a8833c89ceca!2sDarvaza%2C%20Turkmenistan!3m2!1d40.173957099999996!2d58.4169385!4m5!1s0x402c1a2f5c774367%3A0x6a6b0727af24b1e0!2sAwaza%2C%20Turkmenistan!3m2!1d39.9730086!2d52.8511956!4m5!1s0x3f4176d3debc7375%3A0x3e87e3fcbafd3c8a!2sBa%C3%BDramaly%2C%20Turkmenistan!3m2!1d37.6156855!2d62.157134899999996!4m5!1s0x41ddad1280665aad%3A0xbc519b36baa4f375!2zS8O2bmXDvHJnZW5jaCwgVHVya21lbmlzdGFu!3m2!1d42.324218699999996!2d59.1818543!5e0!3m2!1sen!2shk!4v1663967113379!5m2!1sen!2shk"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="row mt-3" style="">
            <div class="col-lg-3 col-md-4 col-sm-12 order-1">
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
            <div class="col-lg-9 col-md-8 col-sm-12 order-2">
                <n-tabs type="line" trigger="hover" class="container">
                    <n-tab-pane name="oasis" tab="Description">
                        <div class="container h-50 overflow-auto border rounded">
                            {{ tour.body }}
                        </div>
                        <div class="container h-50 overflow-auto border rounded">
                            <div class="row">
                                <div class="col-10 border">
                                    <div class="row">
                                        <div class="col-6 border-bottom rounded-3" v-for="price in tour.prices"
                                            :key="price.id">
                                            <p>{{ price.name }}:{{ price.price }}$</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 border">
                                    <div class="col-12 container-fluid border-bottom h-50 w-100">places:{{ total_places
}}
                                    </div>
                                    <div class="col-12 container-fluid h-50 w-100">days:{{ days.length }}</div>
                                </div>
                            </div>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="includes" tab="includes">
                        <div v-for="(include) in tour.notes" :key=include.id data:a="a">
                            <h5 v-if="include.pivot.status === 'included'"> {{ '-' }}{{ include.name }}</h5>
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="non included" tab="Non included">
                        <div v-for="(include) in tour.notes" :key=include.name data:i="i">
                            <h5 v-if="include.pivot.status === 'non included'">{{ '-' }} {{ include.name }}</h5>
                        </div>
                    </n-tab-pane>
                </n-tabs>
            </div>
        </div>
    </section>
    <br>
    <section class="days">
        <div class="container mt-3">
            <div class="overflow-auto">
                <n-steps vertical v-model:current="current" :status="currentStatus" class="overflow m-3">
                    <n-step v-for="day in days" :key='day.id' title="-day">
                        <div class="row">
                            <div class=" col-6 container border rounded">
                                {{ day.body }}
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6 border-top rounded h-100">
                                        <h5 class="border-bottom">Places</h5>
                                        <p v-for="place in day.places" :key="place.id">
                                            <Link :href="route('place.show', place.id)" method="get" as="button">{{ place.name }}</Link>
                                        </p>
                                    </div>
                                    <!-- <div class="col-6 border-top rounded h-100">
                                        <h5 class="border-bottom">Hotels</h5>
                                        <p v-for="hotel in day.hotels" :key="hotel.id">
                                            {{hotel.name}}
                                        </p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </n-step>
                </n-steps>
            </div>
        </div>
    </section>
    <section class="apply container">
        <n-alert v-if="form.wasSuccessful" title="Successfully applied" type="success" closable>
            Thanks for choosing us. Our assistant will contact you via email.
        </n-alert>
        <n-button type="primary" class="w-100 my-3" @click="showModal = true" dashed>
            Apply for this Tour
        </n-button>
    </section>
    <n-modal v-model:show="showModal" preset="dialog" title="Please submit your information" negative-text="Cancel">
        <div class="container">
            <n-form :label-width="80" :model="form" :rules="rules">
                <n-form-item label="Name" path="name">
                    <n-input v-model:value="form.name" placeholder="Input Name" />
                </n-form-item>
                <n-form-item label="Surname" path="surname">
                    <n-input v-model:value="form.surname" placeholder="Input Surname" />
                </n-form-item>
                <n-form-item label="Where are you from?" path="country_id">
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.country_id"
                        filterable placeholder="Please Select Your Country" :options="countries" />
                </n-form-item>
                <n-form-item label="Email" path="email">
                    <n-auto-complete v-model:value="form.email" :options="CompleteOptions" placeholder="Email" />
                </n-form-item>
                <n-form-item label="Phone" path="phone">
                    <n-input v-model:value="form.phone" placeholder="Phone Number" />
                </n-form-item>
                <n-form-item label="Please choose desired tour" path="tour_id">
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.tour_id" filterable
                        placeholder="Please choose desired tour" :options="tours" />
                </n-form-item>
                <n-form-item label="How many people are in group? Please choose 1 if it is only you." path="quantity">
                    <n-input-number v-model:value="form.quantity" :min="0" placeholder="How many people?" />
                </n-form-item>
                <n-form-item label="Planned time of arrival" path="arrival">
                    <!-- <n-date-picker value-format="yyyy-MM-dd" v-model:value="form.arrival" type="date" /> -->
                    <input type="date" class="form-control" v-model="form.arrival">
                </n-form-item>
                <n-form-item label="Planned time of departure from Turkmenistan" path="departure">
                    <!-- <n-date-picker v-model:value="form.departure" type="date" /> -->
                    <input type="date" class="form-control" v-model="form.departure">
                </n-form-item>
                <n-form-item label="Any notes or any questions are highly appreciated" path="note">
                    <n-input type="textarea" maxlength="300" show-count clearable v-model:value="form.note" />
                </n-form-item>
            </n-form>
            <n-button
                @click="form.post(route('application.store'), { onSuccess: () => { form.reset(); showModal = false; } })"
                class="w-100" ghost type="success" :disabled="form.processing || form.name == null || form.surname == null || form.country_id == null || form.email == null || form.phone == null || form.tour_id == null">
                Submit
            </n-button>
            <n-alert class="my-2" v-if="Object.keys($page.props.errors).length != 0" title="Errors" type="error"
                closable>
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
const props = defineProps(['tour', 'days', 'countries', 'tours']);
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
        trigger: ['input']
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