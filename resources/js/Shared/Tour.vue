<template>
    <div class="tour-card" :class="{ 'tour-card--hover': isHovered }" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
        <div class="tour-card__image">
            <img v-if="tour.main_image" :src="'/storage/tours/' + tour.main_image" :alt="$langName(tour)">
            <img v-else :src="'/img/turkmenistan.jpeg'" :alt="$langName(tour)">
            <div class="tour-card__overlay">
                <h3 class="tour-card__title">{{ $langName(tour) }}</h3>
            </div>
        </div>
        
        <div class="tour-card__content">
            <div class="tour-card__stats row">
                <div class="stat col-4">
                    <n-icon size="20"><calendar-outline/></n-icon>
                    <span>{{ tour.total_days }} {{ $t('TotalDays') }}</span>
                </div>
                <div class="stat col-4">
                    <n-icon size="20"><location-outline/></n-icon>
                    <span>{{ total_places_count }} {{ $t('VisitingPlaces') }}</span>
                </div>
                <div class="stat col-4">
                    <n-icon size="20"><cash-outline/></n-icon>
                    <span>{{ tour.tour_prices }}$</span>
                </div>
            </div>
            
            <p class="tour-card__description">{{ $langBody(tour) }}</p>
            
            <n-button class="tour-card__button bg-success text-white w-100" ghost>
                {{ $t('View Details') }}
            </n-button>
        </div>
    </div>
</template>

<script setup>
import { NButton, NIcon } from 'naive-ui';
import { CalendarOutline, LocationOutline, CashOutline } from '@vicons/ionicons5';
import { ref, computed } from 'vue';

const props = defineProps(['tour', 'index']);
const isHovered = ref(false);
const total_places = ref(0);

const total_places_count = computed(() => {
    props.tour.days.forEach(day => {
        total_places.value += day.places_count;
    });
    return total_places.value;
});
</script>

<style scoped>
.tour-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.tour-card--hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

.tour-card__image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.tour-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.tour-card--hover .tour-card__image img {
    transform: scale(1.05);
}

.tour-card__overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
}

.tour-card__title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.tour-card__content {
    padding: 1.5rem;
}

.tour-card__stats {
    margin-bottom: 1rem;
}

.stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #666;
}

.tour-card__description {
    margin: 1rem 0;
    font-size: 0.875rem;
    color: #666;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.tour-card__button {
    margin-top: 1rem;
}

@media (max-width: 768px) {
    .stat {
        font-size: 0.75rem;
    }
    
    .stat span {
        white-space: nowrap;
    }
}
</style>