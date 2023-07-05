<template>
  <Nav class='sticky-top' />
  <div class="container-fluid min-vh-100">
    <div :class="{ 'container-xxl g-0':$page.component != 'front/Welcome'&&$page.component != 'front/ContactUs'?true:false}">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import Nav from '@/Shared/Nav.vue';

</script>

<style>

</style>


<!-- style="background-image:url('/img/carpet.jpg');object-fit: cover; width: 100%;height: 100%;" -->