<template>
    <div class="col-lg-4 col-md-6 col-sm-12 my-3">
        <div class="position-relative tm-thumbnail-container">
            <img :src="'img/1.jpeg'" class="img-fluid rounded-start img" alt="...">
        </div>
        <div class="p-4 overflow-hidden shadow content rounded-start">
            <div class="rounded-3 overflow-hidden" style="height: 250px;">
                <h3 class="tm-text-primary mb-3 overflow-hidden tm-catalog-item-title">{{post.title}}</h3>
                <p class="tm-catalog-item-text overflow-hidden" style="word-wrap: break-word;">{{post.body}}
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps(['post']);
console.log(props.post);


</script>
<style>

</style>