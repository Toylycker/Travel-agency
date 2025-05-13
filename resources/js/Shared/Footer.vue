<template>
  <div>
    <!-- Footer Section -->
    <footer class="footer-section py-5 bg-success text-white">
      <div class="container">
        <div class="row g-4 justify-content-center">
          <!-- Quick Links -->
          <div class="col-lg-5 col-md-6">
            <h3 class="h4 mb-4">{{ $t('Quick Links') }}</h3>
            <ul class="list-unstyled footer-links">
              <li class="mb-3">
                <Link :href="route('places')" class="text-white text-decoration-none d-flex align-items-center">
                  <i class="fas fa-map-marker-alt me-2"></i>
                  {{ $t('Places') }}
                </Link>
              </li>
              <li class="mb-3">
                <Link :href="route('tours')" class="text-white text-decoration-none d-flex align-items-center">
                  <i class="fas fa-route me-2"></i>
                  {{ $t('Tours') }}
                </Link>
              </li>
              <li class="mb-3">
                <Link :href="route('contact')" class="text-white text-decoration-none d-flex align-items-center">
                  <i class="fas fa-envelope me-2"></i>
                  {{ $t('ContactUs') }}
                </Link>
              </li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div class="col-lg-5 col-md-6">
            <h3 class="h4 mb-4">{{ $t('Contact Information') }}</h3>
            <ul class="list-unstyled footer-contact">
              <li class="mb-3 d-flex align-items-center">
                <i class="fas fa-phone me-2"></i>
                <a href="tel:+99365013013" class="text-white text-decoration-none">+993 65 01 30 13</a>
              </li>
              <li class="mb-3 d-flex align-items-center">
                <i class="fas fa-envelope me-2"></i>
                <a href="mailto:jahankeshdetm@gmail.com" class="text-white text-decoration-none">jahankeshdetm@gmail.com</a>
              </li>
              <li class="d-flex align-items-center">
                <i class="fas fa-map-marker-alt me-2"></i>
                <a href="https://goo.gl/maps/kugUViNptPXrhMpX9" class="text-white text-decoration-none" target="_blank">
                  {{ $t('Ashgabat, Turkmenistan') }}
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="footer-bottom text-center mt-5 pt-4 border-top border-white">
          <p class="mb-0">© {{ new Date().getFullYear() }} Jahankeshde. {{ $t('All rights reserved') }}.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<style lang="scss" scoped>
.footer-section {
  position: relative;
  overflow: hidden;

  &::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  }

  .footer-links {
    li {
      transition: transform 0.3s ease;

      &:hover {
        transform: translateX(5px);
      }
    }
  }

  .footer-contact {
    li {
      transition: transform 0.3s ease;

      &:hover {
        transform: translateX(5px);
      }

      a {
        &:hover {
          text-decoration: underline !important;
        }
      }
    }
  }
}

@media (max-width: 768px) {
  .footer-section {
    text-align: center;

    .footer-contact li {
      justify-content: center;
    }
  }
}
</style>