<template>
<div class="form-container p-4 bg-white bg-opacity-90 rounded-3 shadow-lg mx-auto" style="width: min(500px, 95%);">
    <h2 class="text-center mb-4 fs-3">{{ t('Plan Your Dream Trip') }}</h2>
    <n-alert
        v-if="showSuccess"
        type="success"
        closable
        @close="showSuccess = false"
        class="mb-3"
    >
        {{ t('ThanksForChoosingUs') }}
    </n-alert>
    <n-alert
        v-if="showError"
        type="error"
        closable
        @close="showError = false"
        class="mb-3"
    >
        {{ t('error') }}
    </n-alert>
    <form @submit.prevent="submit" class="d-flex flex-column gap-3">
        <div class="form-group">
            <n-select 
                v-model:value="form.country_id" 
                label-field="name" 
                value-field="id" 
                filterable
                :placeholder="t('Where are you from?')" 
                :options="countries" />
        </div>
        <div class="form-group">
            <n-auto-complete 
                v-model:value="form.email" 
                :options="CompleteOptions" 
                :placeholder="t('Your Email')" />
        </div>
        <div class="form-group">
            <n-input type="textarea" 
                v-model:value="form.note" 
                :placeholder="t('Tell us about your travel requirements')" 
                :autosize="{ minRows: 3, maxRows: 5 }" />
        </div>
        <n-button type="primary" attr-type="submit" :loading="form.processing" class="submit-btn mt-2" style="color: white !important;">
            {{ t('Send Inquiry') }}
        </n-button>
    </form>
</div>
</template>

<script setup>
import { NInputGroup, NSpace, NSelect, NAutoComplete, NInput, NButton, NAlert } from 'naive-ui';
import { useI18n } from 'vue-i18n';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed, ref } from "vue";

const { t } = useI18n();
const showSuccess = ref(false);
const showError = ref(false);

defineProps(['countries']);

const form = useForm({
    'country_id': null,
    'email': '',
    'note': '',
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

const submit = () => {
    form.post(route('welcomePageRequest'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccess.value = true;
            form.reset();
            setTimeout(() => {
                showSuccess.value = false;
            }, 3000);
        },
        onError: (errors) => {
            showError.value = true;
            setTimeout(() => {
                showError.value = false;
            }, 3000);
        }
    });
};
</script>

<style scoped>
.form-container {
    backdrop-filter: blur(10px);
}

.form-group {
    margin-bottom: 1rem;
}

:deep(.n-input),
:deep(.n-select),
:deep(.n-auto-complete) {
    background-color: rgba(255, 255, 255, 0.95);
}

:deep(.n-button) {
    font-weight: 600;
    color: white !important;
}

@media (max-width: 768px) {
    .form-container {
        padding: 1.25rem !important;
        margin: 0 1rem;
    }
    
    .form-container h2 {
        font-size: 1.25rem !important;
    }

    .form-group {
        margin-bottom: 0.75rem;
    }
}
</style>
