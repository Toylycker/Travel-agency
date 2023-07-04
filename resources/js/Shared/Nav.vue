<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
              :href="route('home')">Home</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Places' }" :href="route('places')">
            Places
            </Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Tours' }" :href="route('tours')"
              tabindex="-1" aria-disabled="true">Tours</Link>
          </li>
          <!-- <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Blog' }" :href="route('blog')">Blog
            </Link>
          </li> -->
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/ContactUs' }" :href="route('contact')">
            Contact Us</Link>
          </li>
          <li class="nav-item" v-if="$page.props.auth != null">
            <Link class="nav-link" :class="{ 'active': $page.component == 'Auth/Logout' }" :href="route('logout')"
              method="post" as="button">
            logout</Link>
          </li>
        </ul>
        Feel TKM vibe with songs
        <div class="d-flex ml-1">
          <button @click="changeSong">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" fill="currentColor" class="bi bi-skip-forward 1"
              viewBox="0 0 16 16">
              <path
                d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z" />
            </svg>
          </button>
          <audio class="rounded-3 bg-white" controls :src="song"></audio>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/runtime-core';


const song = ref('/songs/Hajy Yazmammedow - Watanym | 2023.mp3');
const changeSong = ()=>{
  if (song.value == '/songs/Hajy Yazmammedow - Watanym | 2023.mp3') {
    song.value = '/songs/Mähri Pirgulyýewa - Watan ( Türkmenistan ) | Gopuz FM.mp3';
  }else if(song.value == '/songs/Mähri Pirgulyýewa - Watan ( Türkmenistan ) | Gopuz FM.mp3'){
    song.value = '/songs/Türkmenistan,Mahri Allakowa.mp3';
  }else if(song.value == '/songs/Türkmenistan,Mahri Allakowa.mp3'){
    song.value = '/songs/Hajy Yazmammedow - Watanym | 2023.mp3'
  }
  }
</script>
