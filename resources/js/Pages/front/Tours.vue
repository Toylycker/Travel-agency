<template>
    <Head title="Tours">
        <meta name="description" content="Explore Turkmenistan with our guided tours. Discover ancient cities, natural wonders, and vibrant culture with our expertly curated tour packages. Book your adventure today!">
        <meta name="keywords" content="Turkmenistan tours, guided tours Turkmenistan, Turkmenistan travel packages, explore Turkmenistan, Turkmenistan attractions, travel to Turkmenistan">
    </Head>
    <div class="tours-container">
        <div class="tours-grid">
            <Tour 
                v-for="(tour, index) in tours" 
                :key="tour.id" 
                :tour="tour" 
                :index="index" 
                @click="showTour(tour.id)"
            />
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Tour from '@/Shared/Tour.vue';
import { Inertia } from '@inertiajs/inertia';

defineProps(['tours']);

function showTour(id) {
    Inertia.get('tours/show/'+id);
}
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style scoped>
.tours-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.tours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

@media (max-width: 768px) {
    .tours-container {
        padding: 1rem;
    }
    
    .tours-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}
</style>