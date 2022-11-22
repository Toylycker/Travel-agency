<template>
<h1>{{tour.name}}</h1>
<h1>{{tour.included}}</h1>
<div class="container">
    <form @submit.prevent="form.post(route('admin.tours.update'), {onSuccess: () => form.reset()})">
                <label for="exampleInputEmail1" class="form-label">name</label>
                <input class="form-control" type="text" v-model="form.name">
                <div class="bg-danger rounded mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                <label for="exampleInputEmail1" class="form-label">main image</label>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{ form.progress.percentage }}%
                </progress>
                <input class="form-control" type="file" @input="form.main_image = $event.target.files[0]">

                <div class="container border border-success rounded mt-2">
                  <label for="exampleInputEmail1" class="form-label">images</label>
                  <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                  </progress>
                  <input class="form-control mb-1" multiple type="file" @input="form.images = $event.target.files">
                  <div class="bg-danger rounded mt-2" v-if="form.errors.images">{{ form.errors.images }}</div>
                </div>
                <div class="bg-danger rounded mt-2" v-if="form.errors.password">{{ form.errors.main_image }}</div>
                <label for="exampleInputEmail1" class="form-label">body</label>
                <input class="form-control" type="text" v-model="form.body">
                <div class="bg-danger rounded mt-2" v-if="form.errors.body">{{ form.errors.body }}</div>
                <label for="exampleInputEmail1" class="form-label">total days</label>
                <input class="form-control" type="number" v-model="form.total_days">
                <div class="bg-danger rounded mt-2" v-if="form.errors.total_days">{{ form.errors.total_days }}</div>
                <label for="exampleInputEmail1" class="form-label">Prices</label>
                <input class="form-control" type="text" v-model="form.prices">
                <div class="bg-danger rounded mt-2" v-if="form.errors.prices">{{ form.errors.prices }}</div>
                <label for="exampleInputEmail1" class="form-label">discount_percent</label>
                <input class="form-control" type="number" v-model="form.discount_percent">
                <div class="bg-danger rounded mt-2" v-if="form.errors.discount_percent">{{
                form.errors.discount_percent}}</div>
                <label for="exampleInputEmail1" class="form-label">discount_datetime_start</label>
                <input class="form-control" type="date" v-model="form.discount_datetime_start">
                <div class="bg-danger rounded mt-2" v-if="form.errors.discount_datetime_start">{{
                form.errors.discount_datetime_start }}</div>
                <label for="exampleInputEmail1" class="form-label">discount_datetime_end</label>
                <input class="form-control" type="date" v-model="form.discount_datetime_end">
                <div class="bg-danger rounded mt-2" v-if="form.errors.discount_datetime_end">{{
                form.errors.discount_datetime_end }}</div>
                <label for="exampleInputEmail1" class="form-label">viewed</label>
                <input class="form-control" type="number" v-model="form.viewed">
                <!-- included and non_included start  -->
                <label for="exampleInputEmail1" class="form-label">included</label>
                <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.included" multiple
                  filterable placeholder="Please Select Places" :options="notes" on-update:value="handleSelect"  />
                <div class="bg-danger rounded mt-2" v-if="form.errors.included">{{
                form.errors.included }}</div>

                <label for="exampleInputEmail1" class="form-label">non included</label>
                <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.non_included" multiple
                  filterable placeholder="Please Select Places" :options="notes" />
                  <div class="bg-danger rounded mt-2" v-if="form.errors.non_included">{{
                form.errors.non_included }}</div>
                <!-- included and non_included end  -->
                <div class="bg-danger rounded mt-2" v-if="form.errors.viewed">{{ form.errors.viewed }}</div>
                <label for="exampleInputEmail1" class="form-label">recommended</label>
                <input class="form-check-input" type="checkbox" v-model="form.recommended">
                <div class="bg-danger rounded mt-2" v-if="form.errors.recommended">{{ form.errors.recommended }}</div>

                <!-- Places start  -->
                <div class="container border rounded border-warning">
                  <div class="bg-danger rounded mt-2" v-if="form.errors.days">{{
                  form.errors.days }}</div>
                  <label for="exampleInputEmail1" class="form-label col-12">Days <div @click="add_day"
                      class="btn btn-primary mx-2 btn-sm w-25 mt-1">+</div> </label>
                  <div class="border container rounded my-2" v-for="(day, index) in form.days" :key="index"
                    data:index="index">
                    <div @click="remove_day(index)" class=" col-12 btn btn-danger my-3">-</div>
                    <label for="exampleInputEmail1" class="form-label">day_number</label>
                    <input class="form-control" type="number" v-model="form.days[index].day_number">
                    <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].day_number">{{
                    form.errors.days[index].day_number }}</div> -->
                    <label for="exampleInputEmail1" class="form-label">title</label>
                    <input class="form-control" type="text" v-model="form.days[index].title">
                    <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].title">{{
                    form.errors.days[index].title }}</div> -->
                    <label for="exampleInputEmail1" class="form-label">body</label>
                    <input class="form-control" type="text" v-model="form.days[index].body">
                    <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].body">{{
                    form.errors.days[index].body }}</div> -->
                    <label for="exampleInputEmail1" class="form-label">places</label>
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.days[index].places"
                      multiple filterable placeholder="Please Select Places" :options="places" />
                    <label for="exampleInputEmail1" class="form-label">hotels</label>
                    <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.days[index].hotels"
                      multiple filterable placeholder="Please Select Places" :options="hotels" />
                  </div>
                </div>
                <!-- Places end  -->
                <!-- Prices start  -->
                <div class="container border border-success rounded my-2">
                  <div class="bg-danger rounded mt-2" v-if="form.errors.detailedPrices">{{
                  form.errors.detailedPrices }}</div>
                  <label for="exampleInputEmail1" class="form-label col-12">prices <div @click="add_price"
                      class="btn btn-primary mx-2 btn-sm w-25 mt-1">+</div> </label>
                  <div class="border container rounded my-2" v-for="(price, index) in form.detailedPrices" :key="index"
                    data:index="index">
                    <div @click="remove_price(index)" class=" col-12 btn btn-danger my-3">-</div>
                    <label for="exampleInputEmail1" class="form-label">name</label>
                    <input class="form-control" type="text" v-model="form.detailedPrices[index].name">
                    <label for="exampleInputEmail1" class="form-label">price</label>
                    <input class="form-control mb-2" type="number" v-model="form.detailedPrices[index].price">
                  </div>
                </div>
                <!-- Prices end  -->
                <button type="submit" class=" col-12 btn btn-primary my-3">submit</button>
                <div v-if="form.recentlySuccessful == true" class="container w-100 bg-success rounded">
                  <h2 class="">Successfully saved</h2>
                </div>
              </form>
</div>
</template>
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3'
const props = defineProps(['tour', 'places', 'hotels', 'notes']);
const form = useForm({
  name: props.tour.name,
  main_image: null,
  body: props.tour.body,
  total_days: props.tour.total_days,
  prices: props.tour.price,
  discount_percent: props.tour.discount_percent,
  discount_datetime_start: props.tour.discount_datetime_start,
  discount_datetime_end: props.tour.discount_datetime_end,
  viewed: props.tour.viewed,
  recommended: props.tour.recommended,
  images: [],
  included: props.tour.included,
  non_included: props.tour.non_included,
  detailedPrices: props.tour.prices,
  days: props.tour.days
})

let handleSelect = (key) => { console.log(key); }
let add_day = () => { form.days.push({ 'day_number': null, 'title': null, 'body': null, 'places': [] }) }
let add_price = () => { form.detailedPrices.push({ 'name': null, 'price': null }) }
let remove_day = (index) => { form.days.splice(index, 1) }
let remove_price = (index) => { form.detailedPrices.splice(index, 1) }
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>