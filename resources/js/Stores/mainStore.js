import { defineStore } from "pinia";
import { useI18n } from 'vue-i18n'
import { ref } from '@vue/runtime-core';



export const useMainStore = defineStore("main", () => {
    const lang = ref('ENG')
    const { t, locale } = useI18n({ useScope: 'global' })


    function changeLang() {
        if (lang.value === 'ENG') {
            lang.value = 'CN';
            locale.value = 'cn'; 

        } else if (lang.value === 'CN') {
            lang.value = 'ENG'
            locale.value = 'eng'; 
        }
    }

    return { lang, changeLang }
});


