<template>
  <div v-if="hasErrors" class="fixed top-4 right-4 z-50 p-0 m-0 max-w-md w-full">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-md rounded-md" role="alert">
      <div class="flex justify-between items-center mb-2">
        <p class="font-bold">Validation Errors</p>
        <button @click="clearAllErrors" class="text-red-500 hover:text-red-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <ul class="list-disc list-inside space-y-1 text-sm">
        <template v-for="(error, key) in allErrors" :key="key">
          <li v-if="typeof error === 'string'">{{ error }}</li>
          <li v-else-if="Array.isArray(error)">
            {{ key }}:
            <ul class="list-disc list-inside ml-4">
              <li v-for="(subError, subKey) in error" :key="subKey">{{ subError }}</li>
            </ul>
          </li>
           <li v-else-if="typeof error === 'object'">
            {{ key }}:
            <ul class="list-disc list-inside ml-4">
              <li v-for="(subError, subKey) in error" :key="subKey">{{ subKey }}: {{ subError }}</li>
            </ul>
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const page = usePage();

// This computed property will gather all errors from the page props.
// It handles cases where props.errors is an object of arrays or strings.
const allErrors = computed(() => page.props.errors || {});

const hasErrors = computed(() => {
  const errors = allErrors.value;
  return Object.keys(errors).length > 0;
});

const clearAllErrors = () => {
  // Inertia's errors are reactive. Setting them to an empty object will clear them.
  // This is a client-side clear. Server-side validation might repopulate them on next request if issues persist.
  page.props.errors = {}; 
};

// Optional: Auto-clear errors after some time or on route change
// import { watch } from 'vue';
// import { Inertia } from '@inertiajs/inertia';
// let errorClearTimeout = null;
// watch(hasErrors, (newValue) => {
//   if (newValue) {
//     clearTimeout(errorClearTimeout);
//     errorClearTimeout = setTimeout(() => {
//       clearAllErrors();
//     }, 7000); // Clear after 7 seconds
//   }
// });
// Inertia.on('navigate', () => {
//   clearTimeout(errorClearTimeout);
//   clearAllErrors(); 
// });

</script>