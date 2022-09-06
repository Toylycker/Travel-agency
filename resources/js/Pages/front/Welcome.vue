<template>

  <Head title="Welcome" />
  <transition @before-enter="beforeEnter" @enter="enter" :appear="true">
    <p id="hello">hello</p>
  </transition>
  <h6>hellow osds</h6>
  <h5>hello worlds</h5>
  <div class="float" id="float">hello worlds</div>
  <h3 class="big">hello worlds</h3>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Place from '@/Shared/Place.vue';
import gsap from "gsap";
import { Sine } from 'gsap/all';

const beforeEnter = (el)=>{
el.style.transform = 'translateY(-60px)'
el.style.opacity = 0
}
const enter = (el)=>{
  gsap.to(el, {
    duration:1,
    y:0,
    opacity:1,
    ease:'bounce.out'
  })
}
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style>
  #hello{
    font-size: 40px;
  }
</style>