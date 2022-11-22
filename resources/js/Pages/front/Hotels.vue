<template>

    <Head title="Hotels" />
    <div class="d-flex rounded-3 container-fluid justify-content-center mt-3" style="align-items:center">
        <Splide class="border-3 rounded-3 container-fluid border-top" :options="{ 
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
        }" aria-label="My Favorite locations">
            <SplideSlide @click="f_location = 0">
                <h5 class="mx-3" :class="{'border-bottom':f_location==false || f_location==0 || f_location==undefined}"
                    style="align-self:center;">
                    All</h5>
            </SplideSlide>
            <!-- <SplideSlide v-if="location!=null || location!=undefined" @click="f_location = location.id">
                <h5 class="mx-3" :class="{'border-bottom':f_location==location.id}" style="align-self:center;">
                    {{location.name}}</h5>
            </SplideSlide> -->
            <SplideSlide v-for="location in locations" :key="location.id" @click="f_location = location.id">
                <h5 class="mx-3 text-dark" :class="{'border-bottom':f_location==location.id}"
                    style="align-self:center;">
                    {{location.name}}</h5>
            </SplideSlide>
        </Splide>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 col-sm-12" v-for="hotel in hotels.data" :key="hotel.id">
            <div class="d-flex">
                <img v-if="hotel.main_image" :src="'/storage/hotels/'+hotel.main_image"
                    class="img-fluid shadow rounded w-50" alt="..." style="object-fit:cover;height:300px;">

                <img v-else :src="'img/2.jpeg'" class="img-fluid shadow rounded w-50" alt="..."
                    style="object-fit:cover;height:300px;">
                <div class="rounded-3 container m-2 w-50">
                    <h3 class="rounded-3 container shadow m-3  rounded-pill"> {{hotel.name}}</h3>
                    <div class="rounded-3 container shadow m-3 rounded-pill">
                        <n-rate readonly :default-value="hotel.stars" />
                    </div>
                    <div class="rounded-3 container-fluid shadow m-3" style="height:250px;">
                        <div class="container overflow-auto" style="height:200px;">
                            {{hotel.body}}
                        </div>
                        <div class=" text-center d-grid gap-2">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary my-2" data-bs-toggle="modal"
                                :data-bs-target='("#exampleModal"+hotel.id)'>
                                see more
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" :id='("exampleModal"+hotel.id)' tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{hotel.name}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12">
                                                <n-carousel show-arrow>
                                                    <img v-for="image in hotel.images" data:ind="ind" :key="image.id"
                                                        :src="'/storage/hotels/'+image.name"
                                                        class="img-fluid d-block rounded w-100 carousel-img">
                                                </n-carousel>
                                            </div>
                                            <div class="col-12">
                                                <p>{{hotel.body}}</p>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-4 rounded my-2" style="height:400px;"
                                                    v-for="room in hotel.rooms" :key="room.id">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0"
                                                        style="height:100px;">{{room.name}}</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0"
                                                        style="height:200px;">{{room.body}}</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0"
                                                        style="height:100px;">{{room.price}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Pagination :links='hotels.links' />

</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { NRate, NScrollbar, NCarousel } from 'naive-ui';
import Pagination from '@/Shared/Pagination.vue';
import '@splidejs/vue-splide/css';
import { ref, watch } from '@vue/runtime-core';
const props = defineProps(['hotels', 'locations', 'location']);
let f_location = ref(props.location);

watch([f_location], ([newlocation], [prevlocation],) => {
    Inertia.get('/hotels', { location: newlocation }, { preserveState: true, only: ['hotels'], replace: true });
})

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style>

</style>