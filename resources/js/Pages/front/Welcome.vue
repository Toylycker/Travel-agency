<template>
  <div>
    <Head :title="$t('Welcome')">
      <meta name="description" content="Welcome to our travel company! Discover the wonders of Turkmenistan with our expertly guided tours and personalized travel experiences. Plan your unforgettable journey today.">
      <meta name="keywords" content="Turkmenistan travel, welcome to Turkmenistan, Turkmenistan tours, travel experiences, guided tours, explore Turkmenistan">
    </Head>
    <div style="height: 35vh; background-image: url('/img/ashgabat/Ashgabat.jpeg'); background-size: cover; background-position: center;" class="d-flex justify-content-center align-items-center">
      <MainPageForm :countries="countries" />
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import MainPageForm from '@/Shared/MainPageForm.vue';
import { Observer } from 'gsap/Observer';
import { onMounted, onBeforeUnmount, onUnmounted, ref } from 'vue';

defineProps(['countries']);
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style lang="scss" scoped>

</style>