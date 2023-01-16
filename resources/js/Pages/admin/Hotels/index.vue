<template >
    <div class="row">
        <div class="col-10">
            <h1>Hotels</h1>
        </div>
        <div class="col-2">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create hotel
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-name" id="exampleModalLabel">Create hotel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="hotel"
                                @submit.prevent="form.post(route('admin.hotels.store'), {onSuccess: () => form.reset()})">
                                <div class="container border rounded my-1">
                                    <label for="" class="form-label">name</label>
                                    <input type="text" class="form-control my-1" v-model="form.name">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.name">{{ form.errors.name }}
                                    </div>
                                </div>
                                <div class="container border rounded my-1">
                                    <label for="" class="form-label">stars</label>
                                    <input type="number" class="form-control my-1" v-model="form.stars">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.stars">{{ form.errors.stars }}
                                    </div>
                                </div>
                                <div class="container border rounded my-1">

                                    <label for="exampleInputEmail1" class="form-label">main image</label>
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                        {{ form.progress.percentage }}%
                                    </progress>
                                    <input class="form-control" type="file"
                                        @input="form.main_image = $event.target.files[0]">
                                </div>
                                <div class="container border rounded my-1">
                                    <label for="exampleInputEmail1" class="form-label">location</label>
                                    <n-select  class="mb-2" label-field="name" value-field="id"
                                        v-model:value="form.location" filterable hotelholder="Please Select location"
                                        :options="locations" />
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.location">{{
                                    form.errors.location }}</div>
                                </div>
                                <div class="container border rounded my-1">
                                    <label for="" class="form-label">body</label>
                                    <input type="text" class="form-control my-1" v-model="form.body">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.body">{{ form.errors.body }}
                                    </div>
                                </div>
                                <div class="container border rounded my-1">
                                    <label for="" class="form-label">viewed</label>
                                    <input type="number" class="form-control my-1" v-model="form.viewed">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.viewed">{{ form.errors.viewed
                                    }}
                                    </div>
                                </div>
                                <div class="container border border-info rounded mt-2">
                                    <label for="exampleInputEmail1" class="form-label">images for hotel</label>
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                        {{ form.progress.percentage }}%
                                    </progress>
                                    <input class="form-control mb-1" multiple type="file"
                                        @input="form.images = $event.target.files">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.images">{{ form.errors.images
                                    }}</div>
                                </div>
                                <div class="container border rounded my-1">
                                    <label for="" class="form-label">recommended</label>
                                    <input type="checkbox" class="form-check-input mx-2" v-model="form.recommended">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.recommended">{{
                                    form.errors.recommended }}</div>
                                </div>
                                <div class="container border rounded my-1">
                                    <div class="container d-flex">

                                        <h4>rooms</h4>
                                        <div class="btn btn-primary w-25 mb-2 mx-2" @click="add_room">+</div>
                                    </div>
                                    <div class="container border rounded border-warning my-2"
                                        v-for="(room, index) in form.rooms" data:index="index" :key="index">
                                        <div class="btn btn-danger col-12 my-1" @click="remove_room(index)">-</div>

                                        <label for="" class="form-label">name</label>
                                        <input type="text" class="form-control my-2"
                                            v-model="form.rooms[index].name">

                                        <label for="" class="form-label">body</label>
                                        <textarea type="text" class="form-control my-2" v-model="form.rooms[index].body"></textarea>

                                        <label for="" class="form-label">room_quan</label>
                                        <input type="number" class="form-control my-2" v-model="form.rooms[index].room_quan">

                                        <label for="" class="form-label">price</label>
                                        <input type="number" class="form-control my-2" v-model="form.rooms[index].price">

                                        <label for="" class="form-label">viewed</label>
                                        <input type="number" class="form-control my-2" v-model="form.rooms[index].viewed">

                                        <div class="bg-danger rounded mt-2" v-if="form.errors.rooms">{{ form.errors.rooms}}
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success col-12 my-3" type="submit">Submit</button>
                                <div v-if="form.recentlySuccessful == true" class="container w-100 bg-success rounded">
                                    <h2 class="">Successfully saved</h2>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div class="container">{{form.errors}}</div>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
                <th>main_image</th>
                <th>name</th>
                <th>stars</th>
                <th>body</th>
                <th>viewed</th>
                <th>recommended</th>
                <th>location</th>
                <th>rooms</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="hotel in hotels.data" :key="hotel.id">
                <td>{{hotel.id}}</td>
                <td>
                    <div class="w-25 h-25">
                        <img class="img img-fluid w-50 h-50" style="object-fit: cover;" v-if="hotel.main_image" :src="'/storage/hotels/'+hotel.main_image" alt="">
                        <div class="container" v-else>no image</div>
                    </div>
                </td>
                <td>{{hotel.name}}</td>
                <td>{{hotel.stars}}</td>
                <td>{{hotel.body}}</td>
                <td>{{hotel.viewed}}</td>
                <td>0</td>
                <td>
                    {{hotel.location.name}}
                </td>
                <td>
                    <div v-if="hotel.rooms.length" class="overflow-auto container" style="height:200px;">
                        <div class="container border border-warning my-1" v-for="room in hotel.rooms" :key="room.id">
                            <h6>{{room.name}}</h6>
                            <p>{{room.body}}</p>
                        </div>
                    </div>
                    <div v-else class="overflow-auto container">no rooms
                    </div>
                </td>
                <!-- <td>
              <n-dropdown trigger="hover" :options="hotel.days" @select="handleSelect" key-field="id" label-field="name">
                {{hotel.total_days}}</n-dropdown>
            </td> -->
                <td>
                    <Link @click="this.$inertia.delete(route('admin.hotels.destroy', hotel.id))" as="button"
                        class="btn btn-danger btn-sm w-100 my-2">Delete</Link>
                </td>
            </tr>
        </tbody>
    </n-table>

    <Pagination :links='hotels.links' />
</template>


<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3'
const props = defineProps(['hotels', 'locations']);
const form = useForm(
    {
        'name': null,
        'stars': null,
        'main_image': null,
        'body': null,
        'viewed': null,
        'recommended': null,
        'images': [],
        'location': [],
        'rooms': [{ 'name': null, 'body': null, 'room_quan': null, 'price': null, 'viewed':null }],

    }
);
let add_room = () => { form.rooms.push({ 'name': null, 'body': null, 'room_quan': null, 'price': [], 'viewed':null }); }
let remove_room = (index) => { form.rooms.splice(index, 1); }
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>