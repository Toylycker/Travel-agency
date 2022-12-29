<template >
  <div class="row m-3">
    <div class="col-10">
      <h3>Tours</h3>
    </div>
    <div class="col-2 d-grid gap-2">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create Tour
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create Tour</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="form.post(route('admin.tours.store'), {onSuccess: () => form.reset()})">
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
                <label for="exampleInputEmail1" class="form-label">map</label>
                <input class="form-control" type="text" v-model="form.map">
                <div class="bg-danger rounded mt-2" v-if="form.errors.map">{{ form.errors.map }}</div>
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
                  filterable placeholder="Please Select Places" :options="notes" />
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
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <n-table :bordered="true" :single-line="false" striped>
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>main_image</th>
        <th>body</th>
        <th>total_days</th>
        <th>prices</th>
        <th>discount_percent</th>
        <th>discount_datetime_start</th>
        <th>discount_datetime_end</th>
        <th>viewed</th>
        <th>recommended</th>
        <th>actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="tour in tours.data" :key="tour.id">
        <td>{{tour.id}}</td>
        <td>{{tour.name}}</td>
        <td>{{tour.main_image}}</td>
        <td>{{tour.body}}</td>
        <td>
          <n-dropdown trigger="hover" :options="tour.days" @select="handleSelect" key-field="id" label-field="title">
            {{tour.total_days}}</n-dropdown>
        </td>
        <td>{{tour.prices}}</td>
        <td>{{tour.discount_percent}}</td>
        <td>{{tour.discount_datetime_start}}</td>
        <td>{{tour.discount_datetime_end}}</td>
        <td>{{tour.viewed}}</td>
        <td>{{tour.recommended}}</td>
        <td>
          <Link @click="this.$inertia.delete(route('admin.tours.destroy', tour.id))" as="button"
            class="btn btn-danger btn-sm w-100 my-2">Delete</Link>
            <Link @click="this.$inertia.get(route('admin.tours.edit', tour.id))" as="button"
            class="btn btn-warning btn-sm w-100 my-2">Edit</Link>
        </td>
      </tr>
    </tbody>
  </n-table>
  <Pagination :links='tours.links' />


</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3'
const props = defineProps(['tours', 'places', 'hotels', 'notes']);

const form = useForm({
  name: null,
  main_image: null,
  body: null,
  map: null,
  total_days: null,
  prices: null,
  discount_percent: null,
  discount_datetime_start: null,
  discount_datetime_end: null,
  viewed: null,
  recommended: null,
  images: [],
  included: [],
  non_included: [],
  detailedPrices: [{ 'name': null, 'price': null }],
  days: [{ 'day_number': null, 'title': null, 'body': null, 'places': [], 'hotels': [] }]
})
let handleSelect = (key) => { console.log(key); }
let add_day = () => { form.days.push({ 'day_number': null, 'title': null, 'body': null, 'places': [] }) }
let add_price = () => { form.detailedPrices.push({ 'name': null, 'price': null }) }
let remove_day = (index) => { form.days.splice(index, 1) }
let remove_price = (index) => { form.detailedPrices.splice(index, 1) }
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from '@vue/runtime-core';
export default { layout: AdminLayout }
</script>