<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-toggle="collapse"
        data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <Link class="navbar-brand" id="jahankeshde" :href="route('home')">Jahankeshde</Link>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('home')">{{ $t('Home') }}</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Places' }" :href="route('places')">
              {{ $t('Places') }}
            </Link>
          </li>
          <!-- <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Tours' }" :href="route('tours')"
              tabindex="-1" aria-disabled="true">{{ $t('Tours') }}</Link>
          </li> -->
          <!-- <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Blog' }" :href="route('blog')">Blog
            </Link>
          </li> -->
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/ContactUs' }" :href="route('contact')">
              {{ $t('ContactUs') }}</Link>
          </li>
          <li class="nav-item">
            <button class="nav-link btn" @click="mainStore.changeLang">
              {{ mainStore.lang=='ENG'?'中文':'ENG' }}</button>
          </li>
          <li class="nav-item" v-if="$page.props.auth != null">
            <Link class="nav-link" :class="{ 'active': $page.component == 'Auth/Logout' }" :href="route('logout')"
              method="post" as="button">
            logout</Link>
          </li>
        </ul>
        {{$t('Music')}} {{ counter }}/3
        <div class="d-flex ml-1">
          <button @click="changeSong">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" fill="currentColor"
              class="bi bi-skip-forward 1" viewBox="0 0 16 16">
              <path
                d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z" />
            </svg>
          </button>
          <div v-show="song === song1">

            <audio id="player1" class="rounded-3 bg-white" controls :src="song1"></audio>
          </div>
          <div v-show="song === song2">

            <audio id="player2" class="rounded-3 bg-white" controls :src="song2"></audio>
          </div>
          <div v-show="song === song3">

            <audio id="player3" class="rounded-3 bg-white" controls :src="song3"></audio>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useMainStore } from '@/Stores/mainStore';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/runtime-core';
import { useI18n } from 'vue-i18n'

const mainStore = useMainStore()

const song = ref('/songs/1.mp3');
const song1 = ref('/songs/1.mp3');
const song2 = ref('/songs/2.mp3');
const song3 = ref('/songs/3.mp3');
let counter = ref(1);

const changeSong = () => {
  // it should be exactly inside of function because so that ui first built then button clicked and then document actually can find id otherwise need to do it thoruh  ref and initialize players with 0(boring)
  const player1 = document.getElementById('player1');
  const player2 = document.getElementById('player2');
  const player3 = document.getElementById('player3');
  if (song.value == '/songs/1.mp3') {
    player1.pause();
    song.value = '/songs/2.mp3';
    player2.play()
    counter.value = 2
  } else if (song.value == '/songs/2.mp3') {
    player2.pause();
    song.value = '/songs/3.mp3';
    player3.play();
    counter.value = 3
  } else if (song.value == '/songs/3.mp3') {
    player3.pause();
    song.value = '/songs/1.mp3'
    player1.play();
    counter.value = 1
  }
}
</script>