<template >
    <h5>{{ form }}</h5>
    <form action=""
        @submit.prevent="form.post(route('admin.places.update.this', place.id), {_method:'put'})">
        <div class="container border rounded my-1">
            <label for="" class="form-label">name</label>
            <input type="text" class="form-control my-1" v-model="form.name">
            <div class="bg-danger rounded mt-2" v-if="form.errors.name">{{ form.errors.name }}
            </div>
        </div>
        <div class="container border rounded my-1">
            <label for="exampleInputEmail1" class="form-label">location</label>
            <n-select class="mb-2" label-field="name" value-field="id" v-model:value="form.location_id" filterable
                placeholder="Please Select location" :options="locations" />
            <div class="bg-danger rounded mt-2" v-if="form.errors.location_id">{{
                form.errors.location_id }}</div>
        </div>
        <div class="container border rounded my-1">
            <label for="exampleInputEmail1" class="form-label">categories</label>
            <n-select multiple class="mb-2" label-field="name" value-field="id" v-model:value="form.categories" filterable
                postholder="Please Select categories" :options="categories" />
            <div class="bg-danger rounded mt-2" v-if="form.errors.categories">{{
                form.errors.categories }}</div>
        </div>
        <div class="container border rounded my-1">
            <label for="" class="form-label">body</label>
            <textarea type="text" class="form-control my-1" v-model="form.body"></textarea>
            <div class="bg-danger rounded mt-2" v-if="form.errors.body">{{ form.errors.body }}
            </div>
        </div>
        <div class="container border rounded my-1">
            <label for="" class="form-label">map</label>
            <input type="text" class="form-control my-1" v-model="form.map">
            <div class="bg-danger rounded mt-2" v-if="form.errors.map">{{ form.errors.map }}
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
            <label for="exampleInputEmail1" class="form-label">images for place (these photos will be added)</label>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <input class="form-control mb-1" multiple type="file" @input="form.images = $event.target.files">
            <div class="bg-danger rounded mt-2" v-if="form.errors.images">{{ form.errors.images
            }}</div>
        </div>
        <div class="container border rounded my-1">
            <label for="" class="form-label">recommended</label>
            <input type="checkbox" class="form-check-input mx-2" v-model="form.recommended">
            <div class="bg-danger rounded mt-2" v-if="form.errors.recommended">{{
                form.errors.recommended }}</div>
        </div>
        <button class="btn btn-success col-12 my-3" type="submit">Update Place </button>
        <div v-if="form.recentlySuccessful == true" class="container w-100 bg-success rounded">
            <h2 class="">Successfully saved</h2>
        </div>
        <div class="container border rounded my-1">
            <div class="container d-flex">
                <h4>Texts</h4>
                            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create Text
            </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                    <label for="" class="form-label">text_number</label>
                                    <input type="number" class="form-control my-2" v-model="textForm.text_number">

                                    <label for="" class="form-label">title</label>
                                    <input type="text" class="form-control my-2" v-model="textForm.title">

                                    <label for="" class="form-label">body</label>
                                    <textarea type="text" class="form-control my-2" v-model="textForm.body"></textarea>

                                    <div class="container border border-success my-1 rounded mt-2">
                                        <label for="exampleInputEmail1" class="form-label">images for text</label>
                                        <progress v-if="textForm.progress" :value="form.progress.percentage" max="100">
                                            {{ textForm.progress.percentage }}%
                                        </progress>
                                        <input class="form-control mb-1" multiple type="file"
                                            @input="textForm.images = $event.target.files">
                                        <div class="bg-danger rounded mt-2" v-if="textForm.errors.images">{{
                                            textForm.errors.images
                                        }}</div>
                                    </div>

                                    <div class="bg-danger rounded mt-2" v-if="textForm.errors">{{ textForm }}
                                    </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" @click="textForm.post(route('admin.texts.store'))" class="btn btn-primary">Create text</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Finished -->
            </div>
            <div class="container border rounded border-warning my-2" v-for="(text, index) in form.texts" data:index="index"
                :key="index">
                <span>{{ text }}</span>
                <div class="btn btn-danger col-12 my-1" @click="remove_text(text.textable_id)">-</div>
                <label for="" class="form-label">text_number</label>
                <input type="number" class="form-control my-2" v-model="form.texts[index].text_number">

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

                <div class="bg-danger rounded mt-2" v-if="form.errors.texts">{{ form.texts }}
                </div>
            </div>
        </div>
    </form>
</template>


<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'

const props = defineProps(['place', 'placeCategories', 'categories', 'locations']);


const form = useForm(
    {
        'name': props.place.name,
        'location_id': props.place.location_id,
        'categories': props.placeCategories,
        'body': props.place.body,
        'map': props.place.map,
        'viewed': props.place.viewed,
        'recommended': props.place.recommended?'true':false,
        'images': [],
        'texts': props.place.texts,

    }
);

const textForm = useForm(
    {
        'title':null,
        'text_number':null,
        'body': '',
        'images': [],
        'textable_id':props.place.id

    }
);
// let add_text = () => { form.texts.push({ 'text_number': null, 'title': null, 'body': null, 'images': [] }); }
let remove_text = (textable_id) => {
    Inertia.delete(route('admin.texts.destroy', textable_id), { preserveState: false });
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>