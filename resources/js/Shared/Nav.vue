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
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Tours' }" :href="route('tours')"
              tabindex="-1" aria-disabled="true">{{ $t('Tours') }}</Link>
          </li>
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
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useMainStore } from '@/Stores/mainStore';
import { Link } from '@inertiajs/inertia-vue3';

const mainStore = useMainStore()

</script>