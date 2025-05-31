<template>
  <div v-if="image && image.name" class="relative inline-block m-1 border border-gray-300 rounded p-1">
    <img :src="computedSrc" :alt="image.name || 'Admin Image'" class="w-24 h-24 object-cover rounded" />
    <button 
      @click="confirmDelete"
      class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center -mt-2 -mr-2 hover:bg-red-700 transition-colors text-xs"
      title="Delete Image"
    >
      X
    </button>
  </div>
  <div v-else class="inline-block m-1 p-1 text-xs text-gray-500">
    Invalid image data.
  </div>
</template>

<script setup>
import { computed, defineProps, defineEmits } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  image: {
    type: Object, // Expects { id: number, name: string, ... }
    required: true,
  },
  pathPrefix: { // e.g., 'places', 'texts' to construct the storage path
    type: String,
    required: true,
  },
});

const emit = defineEmits(['image-deleted']);

const computedSrc = computed(() => {
  if (props.image && props.image.name) {
    // Assuming direct public access to storage symlink
    return `/storage/${props.pathPrefix}/${props.image.name}`;
  }
  return ''; // Or a placeholder image path
});

const confirmDelete = () => {
  if (confirm('Are you sure you want to delete this image?')) {
    deleteImage();
  }
};

const deleteImage = () => {
  if (!props.image || !props.image.id) {
    console.error('AdminImg: Image ID is missing, cannot delete.');
    alert('Cannot delete image: ID missing.');
    return;
  }
  Inertia.delete(route('admin.images.destroy', { image: props.image.id }), {
    data: { path_prefix: props.pathPrefix }, // Send path_prefix to controller
    preserveScroll: true,
    onSuccess: () => {
      alert('Image deleted successfully.');
      emit('image-deleted', props.image.id);
    },
    onError: (errors) => {
      console.error('AdminImg: Error deleting image:', errors);
      const errorMessages = Object.values(errors).join(' ');
      alert(`Failed to delete image: ${errorMessages || 'Unknown error'}`);
    },
  });
};
</script>

<style scoped>
/* Minimal styling, relies on Tailwind mostly */
</style> 