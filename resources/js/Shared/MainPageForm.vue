<template>
<div>
    <n-input-group>
        <n-select class="mb-2" :style="{ width: '33%' }" label-field="name" value-field="id" v-model:value="form.country_id" filterable
            :placeholder="t('selectedPlacesAre')" :options="countries" />
        <n-auto-complete v-model:value="form.email" :options="CompleteOptions" placeholder="Email" />
    </n-input-group>
</div>
</template>
<script setup>
import { NInputGroup, NSpace, NSelect,  NAutoComplete} from 'naive-ui';
import { useI18n } from 'vue-i18n';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from "vue";

const { t } = useI18n()
defineProps(['countries']);

const form = useForm({
    'country_id': null,
    'email': '',
    'note': null,
});

const CompleteOptions = computed(() => {
    return ['@gmail.com', '@yandex.ru', '@163.com', '@qq.com'].map((suffix) => {
        const prefix = form.email.split('@')[0]
        return {
            label: prefix + suffix,
            value: prefix + suffix
        };
    });
});
</script>
