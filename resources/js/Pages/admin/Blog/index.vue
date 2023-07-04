<template >
    <div class="row">
        <div class="col-10">
            <h1>Blog</h1>
        </div>
        <div class="col-2">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create post
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post"
                                @submit.prevent="form.post(route('admin.posts.store'), {onSuccess: () => form.reset()})">
                                <div class="container border rounded my-1">
                                    <label for="" class="form-label">title</label>
                                    <input type="text" class="form-control my-1" v-model="form.title">
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.name">{{ form.errors.title }}
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
                                    <label for="exampleInputEmail1" class="form-label">subjects</label>
                                    <n-select multiple class="mb-2" label-field="name" value-field="id"
                                        v-model:value="form.subjects" filterable postholder="Please Select subjects"
                                        :options="subjects" />
                                    <div class="bg-danger rounded mt-2" v-if="form.errors.subjects">{{
                                    form.errors.subjects }}</div>
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
                                    <label for="exampleInputEmail1" class="form-label">images for post</label>
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

                                        <h4>Texts</h4>
                                        <div class="btn btn-primary w-25 mb-2 mx-2" @click="add_text">+</div>
                                    </div>
                                    <div class="container border rounded border-warning my-2"
                                        v-for="(text, index) in form.texts" data:index="index" :key="index">
                                        <div class="btn btn-danger col-12 my-1" @click="remove_text(index)">-</div>
                                        <label for="" class="form-label">text_number</label>
                                        <input type="number" class="form-control my-2"
                                            v-model="form.texts[index].text_number">

                                        <label for="" class="form-label">title</label>
                                        <input type="text" class="form-control my-2" v-model="form.texts[index].title">

                                        <label for="" class="form-label">body</label>
                                        <input type="text" class="form-control my-2" v-model="form.texts[index].body">

                                        <div class="container border border-success my-1 rounded mt-2">
                                            <label for="exampleInputEmail1" class="form-label">images for text</label>
                                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                {{ form.progress.percentage }}%
                                            </progress>
                                            <input class="form-control mb-1" multiple type="file"
                                                @input="form.texts[index].images = $event.target.files">
                                            <div class="bg-danger rounded mt-2" v-if="form.errors.texts">{{
                                            form.errors.texts
                                            }}</div>
                                        </div>

                                        <div class="bg-danger rounded mt-2" v-if="form.errors.texts">{{ form.texts}}
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
                <th>title</th>
                <th>body</th>
                <th>viewed</th>
                <th>recommended</th>
                <th>subjects</th>
                <th>texts</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="post in posts.data" :key="post.id">
                <td>{{post.id}}</td>
                <td>
                    <div class="container w-25 h-25">

                        <img class="img img-fluid" style="object-fit: cover;" v-if="post.main_image" :src="'/storage/blog/'+post.main_image" alt="">
                        <div class="container" v-else>no image</div>
                    </div>
                </td>
                <td>{{post.title}}</td>
                <td>{{post.body}}</td>
                <td>{{post.viewed}}</td>
                <td>0</td>
                <td>
                    <n-dropdown trigger="hover" :options="post.subjects" key-field="id" label-field="name">
                        {{ post.subjects.length}}</n-dropdown>
                </td>
                <td>
                    <div v-if="post.texts.length" class="overflow-auto container" style="height:200px;">
                        <div class="container border border-warning my-1" v-for="text in post.texts" :key="text.id">
                            <h6>{{text.title}}</h6>
                            <p>{{text.body}}</p>
                        </div>
                    </div>
                    <div v-else class="overflow-auto container">no texts
                    </div>
                </td>
                <!-- <td>
              <n-dropdown trigger="hover" :options="post.days" @select="handleSelect" key-field="id" label-field="title">
                {{post.total_days}}</n-dropdown>
            </td> -->splice
                <td>
                    <Link @click="Inertia.delete(route('admin.posts.destroy', post.id))" as="button"
                        class="btn btn-danger btn-sm w-100 my-2">Delete</Link>
                </td>
            </tr>
        </tbody>
    </n-table>

    <Pagination :links='posts.links' />
</template>


<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'
import Pagination from '@/Shared/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
const props = defineProps(['posts', 'subjects']);
const form = useForm(
    {
        'title': null,
        'main_image': null,
        'body': null,
        'viewed': null,
        'recommended': null,
        'images': [],
        'subjects': [],
        'texts': [{ 'text_number': null, 'title': null, 'body': null, 'images': [] }],

    }
);
let add_text = () => { form.texts.push({ 'text_number': null, 'title': null, 'body': null, 'images': [] }); }
let remove_text = (index) => { form.texts.splice(index, 1); }
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>