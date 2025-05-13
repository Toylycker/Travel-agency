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
                <n-button type="primary" size="large" @click="Inertia.get(route('tours'))">
                  {{ $t('Explore Tours') }}
                </n-button>
                <n-button ghost type="primary" size="large" @click="scrollToSection('about')">
                  {{ $t('Learn More') }}
                </n-button>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 d-flex justify-content-center">
              <div class="form-container w-100">
                <MainPageForm :countries="countries" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Container -->
    <div class="main-content-container">
      <!-- Features Section -->
      <div class="features-section py-5">
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
              <h2 class="display-5 mb-4 text-success">{{ $t('Why Choose Us') }}</h2>
              <div class="why-choose-item mb-4">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-wrapper me-3">
                    <i class="fas fa-check-circle text-success fa-2x"></i>
                  </div>
                  <h4 class="mb-0 text-success">{{ $t('Local Expertise') }}</h4>
                </div>
                <p class="ms-5 mb-0">{{ $t('Our team consists of experienced local guides with deep knowledge of Turkmenistan.') }}</p>
              </div>
              <div class="why-choose-item mb-4">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-wrapper me-3">
                    <i class="fas fa-check-circle text-success fa-2x"></i>
                  </div>
                  <h4 class="mb-0 text-success">{{ $t('Personalized Service') }}</h4>
                </div>
                <p class="ms-5 mb-0">{{ $t('We tailor each tour to match your interests, preferences, and travel style.') }}</p>
              </div>
              <div class="why-choose-item mb-4">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-wrapper me-3">
                    <i class="fas fa-check-circle text-success fa-2x"></i>
                  </div>
                  <h4 class="mb-0 text-success">{{ $t('Cultural Immersion') }}</h4>
                </div>
                <p class="ms-5 mb-0">{{ $t('Experience authentic local culture with our carefully curated activities and experiences.') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Popular Destinations -->
      <div id="destinations" class="destinations-section py-5">
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

      <!-- Testimonials Section -->
      <div class="testimonials-section py-5 position-relative">
        <div class="testimonial-bg-pattern"></div>
        <div class="container">
          <h2 class="text-center display-5 mb-5">{{ $t('What Our Travelers Say') }}</h2>
          <div class="testimonials-wrapper position-relative">
            <div class="row">
              <div class="col-md-4">
                <div class="testimonial-item left-testimonial">
                  <div class="testimonial-content">
                    <div class="quote-icon">
                      <i class="fas fa-quote-left fa-2x text-success"></i>
                    </div>
                    <p class="testimonial-text">{{ $t('The tour of Turkmenistan exceeded all my expectations. The ancient ruins of Merv and the modern architecture of Ashgabat created an unforgettable contrast. Our guide was incredibly knowledgeable and made the experience truly special.') }}</p>
                    <div class="testimonial-author d-flex align-items-center">
                      <div class="author-image">
                        <!-- <img src="/img/testimonials/traveler1.jpg" alt="Sarah Johnson" class="rounded-circle"> -->
                      </div>
                      <div class="author-info ms-3">
                        <h4 class="h5 mb-1">Sarah Johnson</h4>
                        <p class="text-muted mb-0">{{ $t('United States') }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="testimonial-item center-testimonial">
                  <div class="testimonial-content">
                    <div class="quote-icon">
                      <i class="fas fa-quote-left fa-2x text-success"></i>
                    </div>
                    <p class="testimonial-text">{{ $t('An amazing journey through the Silk Road history. The Darvaza Gas Crater was a spectacular sight at night. The local hospitality and traditional food made this trip truly authentic.') }}</p>
                    <div class="testimonial-author d-flex align-items-center">
                      <div class="author-image">
                        <!-- <img src="/img/testimonials/traveler2.jpg" alt="Liu Wei" class="rounded-circle"> -->
                      </div>
                      <div class="author-info ms-3">
                        <h4 class="h5 mb-1">Liu Wei</h4>
                        <p class="text-muted mb-0">{{ $t('China') }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="testimonial-item right-testimonial">
                  <div class="testimonial-content">
                    <div class="quote-icon">
                      <i class="fas fa-quote-left fa-2x text-success"></i>
                    </div>
                    <p class="testimonial-text">{{ $t('The custom tour package was perfectly tailored to our interests. From the ancient sites to the modern city life, everything was well-organized. The guides were friendly and professional throughout our journey.') }}</p>
                    <div class="testimonial-author d-flex align-items-center">
                      <div class="author-image">
                        <!-- <img src="/img/testimonials/traveler3.jpg" alt="Maria Garcia" class="rounded-circle"> -->
                      </div>
                      <div class="author-info ms-3">
                        <h4 class="h5 mb-1">Maria Garcia</h4>
                        <p class="text-muted mb-0">{{ $t('Spain') }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Why Turkmenistan Section -->
      <div class="why-turkmenistan-section py-5">
        <div class="container">
          <h2 class="text-center display-5 mb-5">{{ $t('Why Visit Turkmenistan') }}</h2>
          <div class="row g-4">
            <div class="col-md-6 col-lg-3">
              <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
                <i class="fas fa-landmark fa-3x text-success mb-3"></i>
                <h3 class="h4 mb-3">{{ $t('Rich History') }}</h3>
                <p>{{ $t('Explore ancient Silk Road cities and archaeological sites dating back thousands of years.') }}</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
                <i class="fas fa-horse fa-3x text-success mb-3"></i>
                <h3 class="h4 mb-3">{{ $t('Unique Culture') }}</h3>
                <p>{{ $t('Experience the legendary Akhal-Teke horses and traditional Turkmen hospitality.') }}</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
                <i class="fas fa-mountain fa-3x text-success mb-3"></i>
                <h3 class="h4 mb-3">{{ $t('Natural Wonders') }}</h3>
                <p>{{ $t('From the Karakum Desert to the Kopet Dag Mountains, discover diverse landscapes.') }}</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="feature-card text-center p-4 rounded-3 shadow-sm h-100">
                <i class="fas fa-city fa-3x text-success mb-3"></i>
                <h3 class="h4 mb-3">{{ $t('Modern Marvels') }}</h3>
                <p>{{ $t('Witness the stunning architecture of Ashgabat, the marble city of Central Asia.') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Travel Tips Section -->
    <div class="travel-tips-section py-5 position-relative overflow-hidden">
      <div class="tips-bg-overlay"></div>
      <div class="container">
        <h2 class="text-center display-5 mb-5 text-white">{{ $t('Essential Travel Tips') }}</h2>
        <div class="tips-container">
          <!-- Best Time Tip -->
          <div class="tip-item tip-timing">
            <div class="tip-icon-wrapper">
              <i class="fas fa-calendar-alt fa-3x"></i>
            </div>
            <div class="tip-content">
              <h3 class="h4">{{ $t('Best Time to Visit') }}</h3>
              <p>{{ $t('Spring (March-May) and Fall (September-November) offer the most pleasant weather for traveling.') }}</p>
            </div>
            <div class="tip-shape"></div>
          </div>

          <!-- Visa Tip -->
          <div class="tip-item tip-visa">
            <div class="tip-icon-wrapper">
              <i class="fas fa-passport fa-3x"></i>
            </div>
            <div class="tip-content">
              <h3 class="h4">{{ $t('Visa Information') }}</h3>
              <p>{{ $t('All visitors need a visa. We assist with invitation letters and visa processing.') }}</p>
            </div>
            <div class="tip-shape"></div>
          </div>

          <!-- Currency Tip -->
          <div class="tip-item tip-currency">
            <div class="tip-icon-wrapper">
              <i class="fas fa-money-bill-wave fa-3x"></i>
            </div>
            <div class="tip-content">
              <h3 class="h4">{{ $t('Currency & Payments') }}</h3>
              <p>{{ $t('Bring US dollars in cash. Credit cards are accepted in major hotels in Ashgabat.') }}</p>
            </div>
            <div class="tip-shape"></div>
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

.main-content-container {
  position: relative;
  background-color: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
}

.feature-card {
  transition: transform 0.3s ease;
  background: rgba(40, 167, 69, 0.1) !important;
  border: 1px solid rgba(40, 167, 69, 0.2);
  border-radius: 15px;
  
  &:hover {
    transform: translateY(-5px);
    background: rgba(40, 167, 69, 0.15) !important;
    border-color: rgba(40, 167, 69, 0.3);
  }

  i {
    transition: all 0.3s ease;
    color: #28a745;
  }

  &:hover i {
    transform: scale(1.1);
  }
}

.about-section .col-lg-6 {
  background: none;
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

.testimonial-item {
  padding: 2rem;
  position: relative;
  transition: all 0.4s ease;
  background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(255, 255, 255, 0.2)) !important;
  border: 1px solid rgba(40, 167, 69, 0.2);
  border-radius: 15px;

  &:hover {
    transform: translateY(-10px);
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(255, 255, 255, 0.25)) !important;
  }

  .quote-icon {
    color: rgba(40, 167, 69, 0.3);
  }

  .author-image img {
    border: 3px solid rgba(40, 167, 69, 0.2);
  }
}

.left-testimonial {
  clip-path: polygon(0% 0%, 95% 0%, 100% 100%, 5% 100%);
  box-shadow: -5px 5px 15px rgba(40, 167, 69, 0.1);
}

.center-testimonial {
  clip-path: polygon(5% 0%, 95% 0%, 100% 95%, 0% 100%);
  box-shadow: 0 5px 15px rgba(40, 167, 69, 0.1);
  margin-top: 2rem;
  background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(255, 255, 255, 0.2)) !important;
  border-color: rgba(0, 123, 255, 0.2);
}

.right-testimonial {
  clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%);
  box-shadow: 5px 5px 15px rgba(40, 167, 69, 0.1);
  background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(255, 255, 255, 0.2)) !important;
  border-color: rgba(220, 53, 69, 0.2);
}

.travel-tips-section {
  background: url('/img/ashgabat/Ashgabat.jpeg') center/cover no-repeat fixed;
  min-height: 600px;

  .tips-bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4));
  }

  .tips-container {
    position: relative;
    z-index: 2;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2rem;
  }
}

.tip-item {
  flex: 0 1 350px;
  padding: 2rem;
  color: white;
  position: relative;
  overflow: hidden;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 20px;
  transition: all 0.4s ease;

  &:hover {
    transform: translateY(-10px);
    backdrop-filter: blur(15px);

    .tip-icon-wrapper {
      transform: scale(1.1);
    }
  }

  .tip-icon-wrapper {
    margin-bottom: 1.5rem;
    transition: transform 0.4s ease;
    color: #4CAF50;
  }

  .tip-content {
    position: relative;
    z-index: 2;
  }

  .tip-shape {
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    top: -100%;
    left: -100%;
    transition: all 0.6s ease;
  }

  &:hover .tip-shape {
    transform: translate(50%, 50%);
  }
}

@media (max-width: 768px) {
  .testimonial-item {
    margin-bottom: 2rem;
    clip-path: none !important;
  }

  .tip-item {
    flex: 0 1 100%;
    margin: 1rem;
  }
}

@media (max-width: 768px) {
  .footer-section {
    text-align: center;

    .footer-contact li,
    .social-links {
      justify-content: center;
    }
  }
}

.form-container {
  background-color: rgba(0, 0, 0, 0.4);
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  border: 1px solid rgba(255, 255, 255, 0.18);
}

.features-section,
.destinations-section,
.why-turkmenistan-section,
.testimonials-section {
  background: none;
  position: relative;
}

.why-choose-item {
  position: relative;
  padding: 1.5rem;
  border-radius: 15px;
  background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(255, 255, 255, 0.2));
  border: 1px solid rgba(40, 167, 69, 0.2);
  transition: all 0.3s ease;

  &:hover {
    transform: translateX(10px);
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(255, 255, 255, 0.25));
  }

  .icon-wrapper {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(40, 167, 69, 0.1);
    transition: all 0.3s ease;
  }

  &:hover .icon-wrapper {
    background: rgba(40, 167, 69, 0.2);
    transform: scale(1.1);
  }

  h4 {
    font-size: 1.25rem;
    font-weight: 600;
  }

  p {
    color: #666;
    line-height: 1.6;
  }
}

// Form responsive fixes
.form-container {
  @media (max-width: 768px) {
    margin: 1rem;
    padding: 1.5rem;
    width: calc(100% - 2rem) !important;

    :deep(.n-form) {
      .n-form-item {
        margin-bottom: 1rem;
      }

      .n-input,
      .n-auto-complete,
      .n-select {
        width: 100%;
      }

      textarea {
        min-height: 100px;
      }

      .n-button {
        width: 100%;
        margin-top: 1rem;
        position: static !important;
        opacity: 1 !important;
        visibility: visible !important;
      }
    }
  }

  :deep(.n-button) {
    position: relative !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
  }
}

// Improve hero section responsiveness
.hero-section {
  @media (max-width: 768px) {
    .hero-background {
      min-height: 100vh !important;
      height: auto !important;
      padding: 2rem 0;
    }

    .text-white {
      text-align: center;
      margin-bottom: 2rem;

      .d-flex {
        justify-content: center;
      }
    }
  }
}
</style>