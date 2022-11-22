<template>

    <Head title="Contact Us" />
    <div class="col-12 text-center">
        <div class="container rounded border border-warning">
            <form @submit.prevent="form.post(route('storeContact'), {onSuccess: () => form.reset()})" method="post" class="my-3">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input v-model="form.email" type="email" name="email" placeholder="somethingsomething@gmail.com"
                        class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Message</label>
                    <textarea v-model="form.message" type="text" placeholder="Hi, i have a question."
                        class="form-control" id="exampleInputPassword1"></textarea>
                </div>
                <button type="submit" :disabled="form.progressing" class="btn btn-primary">Submit</button>
                <div v-if="form.recentlySuccessful == true" class="container w-100 bg-success my-3 rounded">
                    <h2 class="">Received. Assistant will contact you shortly by email.</h2>
                </div>
            </form>
        </div>
    </div>

</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
const form = useForm({
    'email': null,
    'message': null
})

</script>
<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style>

</style>