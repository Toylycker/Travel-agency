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
            <SplideSlide v-if="location!=null || location!=undefined" @click="f_location = location.id">
                <h5 class="mx-3" :class="{'border-bottom':f_location==location.id}" style="align-self:center;">
                    {{location.name}}</h5>
            </SplideSlide>
            <SplideSlide v-for="location in locations" :key="location.id" @click="f_location = location.id">
                <h5 class="mx-3 text-dark" :class="{'border-bottom':f_location==location.id}"
                    style="align-self:center;">
                    {{location.name}}</h5>
            </SplideSlide>
        </Splide>
    </div>
    <div class="row mt-2">
        <div class="col-6" v-for="hotel in hotels.data" :key="hotel.id">
            <div class="d-flex">
                <img :src="'img/2.jpeg'" class="img-fluid shadow rounded w-50" alt="..."
                    style="object-fit:cover;height:400px;">
                <div class="rounded-3 container m-2 w-50">
                    <h3 class="rounded-3 container shadow m-3  rounded-pill"> {{hotel.name}}</h3>
                    <div class="rounded-3 container shadow m-3 rounded-pill">
                        <n-rate readonly :default-value="hotel.stars" />
                    </div>
                    <div class="rounded-3 container-fluid shadow m-3" style="height:350px;">
                        <div class="container overflow-auto" style="height:300px;">
                            {{hotel.body}}
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium iste non ducimus
                            itaque sapiente? Modi minus ipsam expedita reprehenderit temporibus a soluta dolore,
                            repudiandae sint esse, nisi quos aperiam voluptates.
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium iste non ducimus
                            itaque sapiente? Modi minus ipsam expedita reprehenderit temporibus a soluta dolore,
                            repudiandae sint esse, nisi quos aperiam voluptates.
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium iste non ducimus
                            itaque sapiente? Modi minus ipsam expedita reprehenderit temporibus a soluta dolore,
                            repudiandae sint esse, nisi quos aperiam voluptates.
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium iste non ducimus
                            itaque sapiente? Modi minus ipsam expedita reprehenderit temporibus a soluta dolore,
                            repudiandae sint esse, nisi quos aperiam voluptates.
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
                                                <div id="carouselExampleIndicators" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button"
                                                            data-bs-target="#carouselExampleIndicators"
                                                            data-bs-slide-to="0" class="active" aria-current="true"
                                                            aria-label="Slide 1"></button>
                                                        <button type="button"
                                                            data-bs-target="#carouselExampleIndicators"
                                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button"
                                                            data-bs-target="#carouselExampleIndicators"
                                                            data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <!-- <img src="..." class="d-block w-100" alt="..."> -->
                                                            <img :src="'/img/1.jpeg'"
                                                                class="img-fluid d-block rounded-start w-100">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img :src="'/img/noMatch.png'"
                                                                class="img-fluid d-block rounded-start w-100">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img :src="'/img/2.jpeg'"
                                                                class="img-fluid d-block rounded-start w-100">
                                                        </div>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#carouselExampleIndicators"
                                                        data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button"
                                                        data-bs-target="#carouselExampleIndicators"
                                                        data-bs-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-4 rounded my-2" style="height:400px;">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0" style="height:100px;">Room name</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0" style="height:200px;">Description</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0" style="height:100px;">Price</div>
                                                </div>
                                                <div class="col-4 rounded my-2" style="height:400px;">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0" style="height:100px;">Room name</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0" style="height:200px;">Description</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0" style="height:100px;">Price</div>
                                                </div>
                                                <div class="col-4 rounded my-2" style="height:400px;">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0" style="height:100px;">Room name</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0" style="height:200px;">Description</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0" style="height:100px;">Price</div>
                                                </div>
                                                <div class="col-4 rounded my-2" style="height:400px;">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0" style="height:100px;">Room name</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0" style="height:200px;">Description</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0" style="height:100px;">Price</div>
                                                </div>
                                                <div class="col-4 rounded my-2" style="height:400px;">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0" style="height:100px;">Room name</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0" style="height:200px;">Description</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0" style="height:100px;">Price</div>
                                                </div>
                                                <div class="col-4 rounded my-2" style="height:400px;">
                                                    <div class="container bg-success rounded-top border-primary border border-bottom-0" style="height:100px;">Room name</div>
                                                    <div class="container bg-primary  border border-primary border-top-0 border-bottom-0" style="height:200px;">Description</div>
                                                    <div class="container bg-danger rounded-bottom border-primary border border-top-0" style="height:100px;">Price</div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
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
import { NRate, NScrollbar } from 'naive-ui';
import Pagination from '@/Shared/Pagination.vue';
import '@splidejs/vue-splide/css';
import { ref, watch } from '@vue/runtime-core';
let f_location = ref(0);
const props = defineProps(['hotels', 'locations', 'location']);

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style>

</style>