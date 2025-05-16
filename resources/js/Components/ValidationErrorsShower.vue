<template>
  <div v-if="Object.keys(errors).length > 0" class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
    <p class="text-red-600 font-medium">Please correct the following errors:</p>
    <ul class="mt-2 list-disc list-inside">
      <li v-for="(error, key) in errors" :key="key" class="text-red-500">
        {{ error }}
      </li>
    </ul>
  </div>
</template>

<script setup>
defineProps({
  errors: {
    type: Object,
    required: true
  }
});
</script> 