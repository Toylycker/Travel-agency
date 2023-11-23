<template>
  <div class="container">
    <h1>{{ tour.recommended }}</h1>
    <form>
      <div v-if="
      formname.recentlySuccessful == true ||
      formname_cn.recentlySuccessful == true ||
        formmain_image.recentlySuccessful == true ||
        formbody.recentlySuccessful == true ||
        formbody_cn.recentlySuccessful == true ||
        formtotal_days.recentlySuccessful == true ||
        formtour_prices.recentlySuccessful == true ||
        formviewed.recentlySuccessful == true ||
        formrecommended.recentlySuccessful == true ||
        formimages.recentlySuccessful == true ||
        formnotes.recentlySuccessful == true ||
        formprices.recentlySuccessful == true ||
        formdays.recentlySuccessful == true
        " class="container w-100 bg-success rounded fixed-top">
        <h2 class="">Successfully saved</h2>
      </div>
      <!-- NAME INPUT STARTs  -->
      <label for="exampleInputEmail1" class="form-label">name</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="text" v-model="formname.name">
        <div @click="formname.put(route('admin.tours.edit.name', [tour.id]))" class="btn btn-success ml-1"> save name
        </div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formname.errors.name">{{ formname.errors.name }}</div>
      <!-- NAME INPUT ends  -->

      <!-- NAME INPUT STARTs  -->
      <label for="exampleInputEmail1" class="form-label">name_cn</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="text" v-model="formname_cn.name_cn">
        <div @click="formname_cn.put(route('admin.tours.edit.name_cn', [tour.id]))" class="btn btn-success ml-1"> save
          name_cn
        </div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formname.errors.name_cn">{{ formname.errors.name_cn }}</div>
      <!-- NAME INPUT ends  -->

      <!-- Main_IMage INPUT STARTs  -->
      <label for="exampleInputEmail1" class="form-label">main image</label>
      <img class="img img-fluid w-50 my-1" style="object-fit: cover;" v-if="tour.main_image"
        :src="'/storage/tours/' + tour.main_image" alt="">
      <div class="container" v-else>no image</div>
      <!-- <progress v-if="formmain_image.progress" :value="formmain_image.progress.percentage" max="100">
        {{ formmain_image.progress.percentage }}%
      </progress> -->
      <!-- ----------------/ -->
      <div class="container g-0 d-flex">
        <input class="form-control" type="file" @input="formmain_image.main_image = $event.target.files[0]">
        <div @click="formmain_image.post(route('admin.tours.edit.main_image', tour.id), { _method: 'put' })"
          class="btn btn-success ml-1">
          save main image</div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formmain_image.errors.main_image">{{ formmain_image.errors.main_image }}
      </div>
      <!-- MAIN_IMAGE ENDS  -->

      <!-- IMAGES FOR TOUR ITSELF STARTS -->
      <div class="container border border-success rounded mt-2">
        <label for="exampleInputEmail1" class="form-label">images</label>
        <div v-if="tour.images.length > 0" class="col-md-4 mb-3 m-md-2 img-fluid img h-25">
          <div :id="'text_image' + tour.id" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div v-for="imag in tour.images" :key="imag.id" class="carousel-item active">
                <!-- <img src="..." class="d-block w-100" alt="..."> -->
                <img :src="'/storage/tours/' + imag.name" class="img-fluid d-block rounded w-100">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" :data-bs-target="'#text_image' + tour.id"
              data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" :data-bs-target="'#text_image' + tour.id"
              data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <progress v-if="formimages.progress" :value="formimages.progress.percentage" max="100">
          {{ formimages.progress.percentage }}%
        </progress>
        <div class="container g-0 d-flex">
          <input class="form-control mb-1" multiple type="file" @input="formimages.images = $event.target.files">
          <div @click="formimages.post(route('admin.tours.edit.images', [tour.id]), { _method: 'put' })"
            class="btn btn-success m-1"> save images</div>
        </div>
        <div class="bg-danger rounded mt-2" v-if="formimages.errors.images">{{ formimages.errors.images }}</div>
      </div>
      <!-- IMAGES FOR TOUR ITSELF ENDS  -->

      <!-- BODY INPUT STARTS  -->
      <label for="exampleInputEmail1" class="form-label">body</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="text" v-model="formbody.body">
        <div @click="formbody.put(route('admin.tours.edit.body', [tour.id]))" class="btn btn-success ml-1"> save body
        </div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formbody.errors.body">{{ formbody.errors.body }}</div>
      <!-- BODY INPUT ENDS  -->

      <!-- BODY INPUT STARTS  -->
      <label for="exampleInputEmail1" class="form-label">body_cn</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="text" v-model="formbody_cn.body_cn">
        <div @click="formbody_cn.put(route('admin.tours.edit.body_cn', [tour.id]))" class="btn btn-success ml-1"> save body_cn
        </div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formbody.errors.body">{{ formbody_cn.errors.body_cn }}</div>
      <!-- BODY INPUT ENDS  -->

      <!-- BODY INPUT STARTS  -->
      <label for="exampleInputEmail1" class="form-label">map</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="text" v-model="formmap.map">
        <div @click="formmap.put(route('admin.tours.edit.map', [tour.id]))" class="btn btn-success ml-1"> save map
        </div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formmap.errors.map">{{ formmap.errors.map }}</div>map
      <!-- map INPUT ENDS  -->

      <!-- TOTAL DAYS INPUT STARTS  -->
      <label for="exampleInputEmail1" class="form-label">total days</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="number" v-model="formtotal_days.total_days">
        <div @click="formtotal_days.put(route('admin.tours.edit.total_days', [tour.id]))" class="btn btn-success ml-1">
          save total days</div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formtotal_days.errors.total_days">{{ formtotal_days.errors.total_days }}
      </div>
      <!-- TOTAL DAYS INPUT ENDS  -->

      <!-- MAIN PRICES FROM CHEAP TO EXPENSIVE INPUT STARTS  -->
      <label for="exampleInputEmail1" class="form-label">Tour Main Prices In General</label>

      <div class="container g-0 d-flex">
        <input class="form-control" type="text" v-model="formtour_prices.tour_prices">
        <div @click="formtour_prices.put(route('admin.tours.edit.tour_prices', [tour.id]))" class="btn btn-success ml-1">
          save main prices</div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formtour_prices.errors.tour_prices">{{
        formtour_prices.errors.tour_prices
      }}</div>
      <!-- MAIN PRICES FROM CHEAP TO EXPENSIVE INPUT ENDS  -->

      <!-- NOT added to system YET STARTS -->
      <!-- <label for="exampleInputEmail1" class="form-label">discount_percent</label>
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
                form.errors.discount_datetime_end }}</div> -->
      <!-- NOT added to system YET ENDS  -->

      <!-- VIEWED INPUT STARTS  -->
      <label for="exampleInputEmail1" class="form-label">viewed</label>
      <div class="container g-0 d-flex">
        <input class="form-control" type="number" v-model="formviewed.viewed">
        <div @click="formviewed.put(route('admin.tours.edit.viewed', [tour.id]))" class="btn btn-success ml-1">
          save view</div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formviewed.errors.viewed">{{ formviewed.errors.viewed }}</div>
      <!-- VIEWED INPUT ENDS  -->

      <!-- included and non_included start  -->
      <label for="exampleInputEmail1" class="form-label">included</label>
      <div class="container g-0 d-flex">
        <n-select class="mb-2" label-field="name" value-field="id" v-model:value='formnotes.included' multiple filterable
          placeholder="Please Select Places" :options="notes" />
      </div>
      <div class="bg-danger rounded mt-2" v-if="formnotes.errors.included">{{
        formnotes.errors.included
      }}</div>
      <!-- --------------------------------------------------------------------------------- -->
      <label for="exampleInputEmail1" class="form-label">non included</label>

      <div class="container g-0 d-flex">
        <n-select class="mb-2" label-field="name" value-field="id" v-model:value="formnotes.non_included" multiple
          filterable placeholder="Please Select Places" :options="notes" />
      </div>
      <div @click="formnotes.put(route('admin.tours.edit.notes', [tour.id]))" class="btn btn-success m-2">
        save notes</div>
      <br>
      <div class="bg-danger rounded mt-2" v-if="formnotes.errors.non_included">{{
        formnotes.errors.non_included
      }}</div>
      <!-- included and non_included end  -->

      <!-- RECOMMENDED STARTS  -->
      <label for="exampleInputEmail1" class="form-label">recommended</label>
      <div class="container g-0 d-flex">
        <n-checkbox v-model:checked="formrecommended.recommended">
          recommended
        </n-checkbox>
        <div @click="formrecommended.put(route('admin.tours.edit.recommended', [tour.id]))" class="btn btn-success m-2">
          make recommended</div>
      </div>
      <div class="bg-danger rounded mt-2" v-if="formrecommended.errors.recommended">{{
        formrecommended.errors.recommended
      }}</div>
      <!-- RECOMMENDED ENDS  -->

      <!-- Days start  -->
      <div class="container border rounded border-warning">
        <div class="bg-danger rounded mt-2" v-if="formdays.errors.days">{{
          formdays.errors.days
        }}</div>
        <div class="d-flex">
          <label for="exampleInputEmail1" class="form-label">Days </label>
          <div @click="add_day" class="btn btn-primary mx-2 btn-sm w-25 mt-1">+ add a day</div>
          <div @click="formdays.put(route('admin.tours.edit.days', [tour.id]))" class="btn btn-success btn-sm w-25 mt-1">
            save changes</div>
        </div>

        <div class="border container rounded my-2" v-for="(day, index) in formdays.days" :key="index" data:index="index">
          <div @click="remove_day(index)" class=" col-12 btn btn-danger my-3">-</div>
          <label for="exampleInputEmail1" class="form-label">day_number</label>
          <input class="form-control" type="number" v-model="formdays.days[index].day_number">
          <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].day_number">{{
                    form.errors.days[index].day_number }}</div> -->
          <label for="exampleInputEmail1" class="form-label">title</label>
          <input class="form-control" type="text" v-model="formdays.days[index].title">
          <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].title">{{
                    form.errors.days[index].title }}</div> -->
          <label for="exampleInputEmail1" class="form-label">body</label>
          <input class="form-control" type="text" v-model="formdays.days[index].body">
          <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].body">{{
                    form.errors.days[index].body }}</div> -->
          <label for="exampleInputEmail1" class="form-label">body_cn</label>
          <input class="form-control" type="text" v-model="formdays.days[index].body_cn">
          <!-- <div class="bg-danger rounded mt-2" v-if="form.errors.days[index].body_cn">{{
                    form.errors.days[index].body }}</div> -->
          <label for="exampleInputEmail1" class="form-label">places</label>
          <n-select class="mb-2" label-field="name" value-field="id" v-model:value="formdays.days[index].places" multiple
            filterable placeholder="Please Select Places" :options="places" />
          <label for="exampleInputEmail1" class="form-label">hotels</label>
          <n-select class="mb-2" label-field="name" value-field="id" v-model:value="formdays.days[index].hotels" multiple
            filterable placeholder="Please Select Places" :options="hotels" />
        </div>
      </div>
      <!-- Days end  -->


      <!-- Prices start  -->
      <div class="container border border-success rounded my-2">
        <div class="bg-danger rounded mt-2" v-if="formprices.errors.detailedPrices">{{
          formprices.errors.detailedPrices
        }}</div>
        <div class="d-flex">
          <label for="exampleInputEmail1" class="form-label m-1">prices </label>
          <div @click="add_price" class="btn btn-primary mx-2 btn-sm w-25 mt-1">+ add a price</div>
          <div @click="formprices.put(route('admin.tours.edit.prices', [tour.id]))"
            class="btn btn-success btn-sm w-25 mt-1">
            save changes</div>
        </div>
        <div class="border container rounded my-2" v-for="(price, index) in formprices.detailedPrices" :key="index"
          data:index="index">
          <div @click="remove_price(index)" class=" col-12 btn btn-danger my-3">-</div>
          <label for="exampleInputEmail1" class="form-label">name</label>
          <input class="form-control" type="text" v-model="formprices.detailedPrices[index].name"><label
            for="exampleInputEmail1" class="form-label">name_cn</label>
          <input class="form-control" type="text" v-model="formprices.detailedPrices[index].name_cn">
          <label for="exampleInputEmail1" class="form-label">price</label>
          <input class="form-control mb-2" type="number" v-model="formprices.detailedPrices[index].price">
        </div>
      </div>
      <!-- Prices end  -->
    </form>
  </div>
</template>
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect, NCheckbox } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps(['tour', 'places', 'hotels', 'notes', 'days', 'included', 'non_included']);

const formname = useForm({ name: props.tour.name });
const formname_cn = useForm({ name_cn: props.tour.name_cn });
const formmain_image = useForm({ main_image: null });
const formbody = useForm({ body: props.tour.body });
const formbody_cn = useForm({ body_cn: props.tour.body_cn });
const formmap = useForm({ map: props.tour.map });
const formtotal_days = useForm({ total_days: props.tour.total_days });
const formtour_prices = useForm({ tour_prices: props.tour.tour_prices });
const formdiscount_percent = useForm({ discount_percent: props.tour.discount_percent });
const formdiscount_datetime_start = useForm({ discount_datetime_start: props.tour.discount_datetime_start });
const formdiscount_datetime_end = useForm({ discount_datetime_end: props.tour.discount_datetime_end });
const formviewed = useForm({ viewed: props.tour.viewed });
const formrecommended = useForm({ recommended: props.tour.recommended ? true : false });
const formimages = useForm({ images: props.tour.images });
const formnotes = useForm({ included: props.included, non_included: props.non_included });
const formprices = useForm({ detailedPrices: props.tour.prices });
const formdays = useForm({ days: props.days.data });

let add_day = () => { formdays.days.push({ 'day_number': null, 'title': null, 'body': null, 'body_cn': null, 'places': [] }) }
let add_price = () => { formprices.detailedPrices.push({ 'name': null, 'name_cn': null, 'price': null,}) }
let remove_day = (index) => { formdays.days.splice(index, 1) }
let remove_price = (index) => { formprices.detailedPrices.splice(index, 1) }
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { computed } from '@vue/runtime-core';
export default { layout: AdminLayout }
</script>