<template>
    <div class="place-card">
        <div v-if="customTourStore.selection_mode" 
            class="selection-header"
            :class="{'is-selected': check}"
            @click.stop="checkExistenceOFId">
            <div class="selection-content">
                <span v-if="!check" class="selection-status">
                    <i class="fas fa-plus-circle"></i>
                    <span class="selection-text">Add to Tour</span>
                </span>
                <span v-else class="selection-status">
                    <i class="fas fa-check-circle"></i>
                    <span class="selection-text">Added to Tour!</span>
                </span>
            </div>
        </div>

        <div class="col-12 g-0 bg-white rounded-3" :style="{'opacity': '0.90'}" v-if="even" 
            @click="!customTourStore.selection_mode && showPLace(place.id)"
            :class="{'card-selected': check && customTourStore.selection_mode}">
            <div class="mb-3">
                <div class="row g-0">
                    <div class="col-lg-3 col-md-4 col-sm-12 order-1 order-md-2 ">
                        <n-carousel v-if="place.images.length >= 1" :direction="direction"
                            :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height:230px"
                            :draggable="place.images.length >= 2 ? true : false">
                            <img v-for="image in place.images" :src="'/storage/places/' + image.name" :key="image.id"
                                class="img-fluid rounded-start">
                        </n-carousel>
                        <n-carousel v-else keyboard :direction="direction"
                            :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                            <img :src="'/img/1.jpeg'" class="img-fluid rounded-start" alt="...">
                            <img :src="'/img/2.jpeg'" class="img-fluid rounded-start" alt="...">
                        </n-carousel>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12 order-2 order-md-1">
                        <div class="body overflow-hidden rounded-3">
                            <div class="container-fluid" style="height:230px">
                                <h3 class="title text-center h3">{{ $langName(place) }}</h3>
                                <h5 class="text h4">{{ $langBody(place) }}</h5>
                                <!-- <p class="text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-12 rounded-3 bg-white" v-else 
            @click="!customTourStore.selection_mode && showPLace(place.id)"
            :class="{'card-selected': check && customTourStore.selection_mode}">
            <div class="mb-3">
                <div class="row g-0 ">
                    <div class="col-lg-9 col-md-8 col-sm-12 order-2">
                        <div class="body overflow-hidden rounded-3">
                            <div class="container-fluid" style="height:230px">
                                <h3 class="title text-center h3">{{ $langName(place) }}</h3>
                                <h5 class="text overflow-hidden h4">{{ $langBody(place) }}
                                </h5>
                                <!-- <p class="text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 order-1">
                        <n-carousel v-if="place.images.length >= 1" keyboard :direction="direction"
                            :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                            <img v-for="image in place.images" :src="'/storage/places/' + image.name" :key="image.id"
                                class="img-fluid rounded-end" alt="...">
                        </n-carousel>
                        <n-carousel v-else keyboard :direction="direction"
                            :dot-placement="direction === 'vertical' ? 'right' : 'bottom'" style="height: 230px" draggable>
                            <img :src="'/img/1.jpeg'" class="img-fluid rounded-end" alt="...">
                            <img :src="'/img/2.jpeg'" class="img-fluid rounded-end" alt="...">
                        </n-carousel>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { Inertia } from '@inertiajs/inertia';
import { NCarousel, NCheckbox } from 'naive-ui';
import { ref, computed } from 'vue';
import { useCustomTourStore } from '@/Stores/customTourStore';
const props = defineProps(["place", "even"]);
const customTourStore = useCustomTourStore();

const check = computed(() => {return customTourStore.places.includes(props.place.id)}); 

const checkExistenceOFId = ()=>{
    customTourStore.toggleId(props.place.id)
}

let showPLace = (id) => {
    // console.log('clicked');
    Inertia.get('/places/show/' + id);
}

let direction = ref('vertical');
</script>

<style scoped>
.place-card {
    position: relative;
    margin-bottom: 1rem;
}

.selection-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
    border-radius: 8px 8px 0 0;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid #e4e7eb;
    border-bottom: none;
    padding: 0.7rem 0;
    text-align: center;
}

.selection-header:hover {
    background: linear-gradient(135deg, #e4e7eb 0%, #d5d9dd 100%);
    transform: translateY(-1px);
}

.selection-header.is-selected {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    border-color: #45a049;
}

.selection-header.is-selected:hover {
    background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
}

.selection-content {
    display: flex;
    justify-content: center;
    align-items: center;
}

.selection-status {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #4a5568;
    transition: all 0.3s ease;
}

.selection-text {
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.is-selected .selection-status {
    color: white;
}

.selection-status i {
    font-size: 1.2rem;
}

.card-selected {
    border: 1px solid #45a049;
    border-top: none;
    border-radius: 0 0 8px 8px !important;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.selection-header:active {
    transform: translateY(1px);
}
</style>
