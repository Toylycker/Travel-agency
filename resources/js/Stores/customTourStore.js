import { defineStore } from "pinia";
import { useI18n } from 'vue-i18n'
import { ref } from '@vue/runtime-core';



export const useCustomTourStore = defineStore("CustomTour", () => {
    const places = ref([])
    const selection_mode = ref(false)


    function toggleId(place_id) {
        const index = places.value.indexOf(place_id);
        if (index !== -1) {
            // If the id is in the list, remove it
            places.value.splice(index, 1);
        } else {
            // If the id is not in the list, add it
            places.value.push(place_id);
        }
    }

    function toggleMode() {
        if (selection_mode.value) {
            selection_mode.value = false;
            places.value = [];
        } else {
            selection_mode.value = true
            places.value = [];
        }
    }

    return { places, selection_mode, toggleId, toggleMode}
});


