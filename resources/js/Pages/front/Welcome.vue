<template>
  <div>
    <Head :title="$t('Welcome')">
      <meta name="description" content="Welcome to our travel company! Discover the wonders of Turkmenistan with our expertly guided tours and personalized travel experiences. Plan your unforgettable journey today.">
      <meta name="keywords" content="Turkmenistan travel, welcome to Turkmenistan, Turkmenistan tours, travel experiences, guided tours, explore Turkmenistan">
    </Head>
    
    <!-- Hero Section -->
    <div class="hero-section position-relative">
      <div class="hero-background" style="height: 85vh; background-image: url('/img/ashgabat/Ashgabat.jpeg'); background-size: cover; background-position: center; position: relative;">
        <div class="overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5);"></div>
        <div class="container h-100 position-relative">
          <div class="row h-100 align-items-center">
            <div class="col-lg-6 col-md-12 text-white mb-md-4 mb-lg-0">
              <h1 class="display-4 fw-bold mb-4">{{ $t('Discover Turkmenistan') }}</h1>
              <p class="lead mb-4">{{ $t('Experience the rich culture, stunning landscapes, and warm hospitality of Turkmenistan with our expertly crafted tours.') }}</p>
              <div class="d-flex gap-3">
                <n-button type="primary" size="large" @click="scrollToSection('tours')">
                  {{ $t('Explore Tours') }}
                </n-button>
                <n-button ghost type="primary" size="large" @click="scrollToSection('about')">
                  {{ $t('Learn More') }}
                </n-button>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 d-flex justify-content-center">
              <MainPageForm :countries="countries" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="features-section py-5 bg-light">
      <div class="container">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
              <i class="fas fa-map-marked-alt fa-3x text-success mb-3"></i>
              <h3 class="h4 mb-3">{{ $t('Customized Tours') }}</h3>
              <p>{{ $t('Create your perfect itinerary with our personalized tour planning service.') }}</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
              <i class="fas fa-users fa-3x text-success mb-3"></i>
              <h3 class="h4 mb-3">{{ $t('Expert Guides') }}</h3>
              <p>{{ $t('Travel with knowledgeable local guides who bring the destination to life.') }}</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
              <i class="fas fa-hotel fa-3x text-success mb-3"></i>
              <h3 class="h4 mb-3">{{ $t('Quality Accommodations') }}</h3>
              <p>{{ $t('Stay in carefully selected hotels that offer comfort and authentic experiences.') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- About Section -->
    <div id="about" class="about-section py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="/img/ashgabat/Ashgabat.jpeg" alt="About Turkmenistan" class="img-fluid rounded-3 shadow">
          </div>
          <div class="col-lg-6 p-4 rounded-3">
            <h2 class="display-5 mb-4">{{ $t('Why Choose Us') }}</h2>
            <div class="mb-4">
              <h4><i class="fas fa-check-circle text-success me-2"></i>{{ $t('Local Expertise') }}</h4>
              <p>{{ $t('Our team consists of experienced local guides with deep knowledge of Turkmenistan.') }}</p>
            </div>
            <div class="mb-4">
              <h4><i class="fas fa-check-circle text-success me-2"></i>{{ $t('Personalized Service') }}</h4>
              <p>{{ $t('We tailor each tour to match your interests, preferences, and travel style.') }}</p>
            </div>
            <div class="mb-4">
              <h4><i class="fas fa-check-circle text-success me-2"></i>{{ $t('Cultural Immersion') }}</h4>
              <p>{{ $t('Experience authentic local culture with our carefully curated activities and experiences.') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Popular Destinations -->
    <div id="destinations" class="destinations-section py-5 bg-light">
      <div class="container">
        <h2 class="text-center display-5 mb-5">{{ $t('Popular Destinations') }}</h2>
        <div class="row g-4">
          <div v-for="tour in popularTours" :key="tour.id" class="col-md-4">
            <div class="destination-card position-relative rounded-3 overflow-hidden">
              <img :src="'/storage/tours/' + tour.main_image" :alt="tour.name" class="img-fluid w-100">
              <div class="destination-overlay position-absolute w-100 h-100 top-0 start-0 d-flex align-items-end p-3">
                <div class="text-white">
                  <h3 class="h4 mb-2">{{ tour.name }}</h3>
                  <p class="mb-2">{{ $t('Duration') }}: {{ tour.total_days }} {{ $t('days') }}</p>
                  <p class="mb-0">{{ $t('Price') }}: {{ tour.tour_prices }}</p>
                  <n-button type="primary" size="small" class="mt-2" @click="goToTour(tour.id)">
                    {{ $t('View Details') }}
                  </n-button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import MainPageForm from '@/Shared/MainPageForm.vue';
import { NButton } from 'naive-ui';
import { onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineProps(['countries', 'popularTours']);

const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId);
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' });
  }
};

const goToTour = (tourId) => {
  Inertia.visit(route('tour.show', tourId));
};
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style lang="scss" scoped>
.hero-section {
  .hero-background {
    transition: all 0.3s ease;
  }
}

.feature-card {
  transition: transform 0.3s ease;
  background-color: rgba(255, 255, 255, 0.85) !important;
  
  &:hover {
    transform: translateY(-5px);
  }

  i {
    transition: all 0.3s ease;
  }

  &:hover i {
    transform: scale(1.1);
  }
}

.about-section .col-lg-6 {
  background-color: rgba(255, 255, 255, 0.85);
}

.destination-card {
  height: 300px;
  transition: transform 0.3s ease;

  img {
    height: 100%;
    object-fit: cover;
  }

  .destination-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
  }

  &:hover {
    transform: translateY(-5px);
  }
}

@media (max-width: 768px) {
  .hero-section .hero-background {
    height: auto !important;
    min-height: 100vh;
    padding: 2rem 0;
  }

  .destination-card {
    height: 250px;
  }
}
</style>