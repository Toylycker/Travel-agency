<template>
    <div>

        <div v-if="customTourStore.selection_mode" class="container rounded-3 p-1 col-lg-1 col-md-2 col-sm-2 col-4" :class="check?'bg-info':'bg-white'">
            <n-checkbox v-if="customTourStore.selection_mode" v-model:checked="check" :on-update:checked="checkExistenceOFId" :checked="true" :default-checked="check">
                {{check?$t('selected'):$t('select')}}
            </n-checkbox>
        </div>
    
        <div class="col-12  g-0 bg-white rounded-3" style="opacity:0.90;" v-if="even" @click="showPLace(place.id)"
            onmouseover="this.style.background='rgb(240,248,255)';" onmouseout="this.style.background='white';">
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
    
        <div class="col-12 rounded-3 bg-white rounded-3" v-else @click="showPLace(place.id)" style="background:white; opacity:0.90;"
            onmouseover="this.style.background='rgb(240,248,255)';" onmouseout="this.style.background='white';">
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
