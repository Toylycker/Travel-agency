<template>
  <n-drawer v-model:show="showDrawer" :width="800" :auto-focus="false">
    <n-drawer-content :title="drawerTitle" closable>
      <n-form ref="formRef" :model="formModel">
        <!-- Place Name -->
        <n-form-item path="name" label="Name">
          <n-input v-model:value="formModel.name" placeholder="Enter name" />
          <div v-if="formModel.errors.name" class="text-red-500 text-xs">{{ formModel.errors.name }}</div>
        </n-form-item>

        <!-- Location -->
        <n-form-item path="location_id" label="Location">
          <n-select
            v-model:value="formModel.location_id"
            placeholder="Select location"
            :options="locationOptions"
            label-field="label"
            value-field="value"
            clearable
            filterable
          />
          <div v-if="formModel.errors.location_id" class="text-red-500 text-xs">{{ formModel.errors.location_id }}</div>
        </n-form-item>

        <!-- Categories -->
        <n-form-item path="category_ids" label="Categories">
          <n-select
            v-model:value="formModel.category_ids"
            placeholder="Select categories"
            :options="categoryOptions"
            label-field="label"
            value-field="value"
            multiple
            clearable
            filterable
          />
          <div v-if="formModel.errors.category_ids" class="text-red-500 text-xs">{{ formModel.errors.category_ids }}</div>
        </n-form-item>

        <!-- Body -->
        <n-form-item path="body" label="Body">
          <n-input type="textarea" v-model:value="formModel.body" placeholder="Enter body content" :autosize="{ minRows: 3 }" />
          <div v-if="formModel.errors.body" class="text-red-500 text-xs">{{ formModel.errors.body }}</div>
        </n-form-item>

        <!-- Map -->
        <n-form-item path="map" label="Map (e.g., iframe embed code or coordinates)">
          <n-input type="textarea" v-model:value="formModel.map" placeholder="Enter map details" />
          <div v-if="formModel.errors.map" class="text-red-500 text-xs">{{ formModel.errors.map }}</div>
        </n-form-item>

        <!-- Viewed -->
        <n-form-item path="viewed" label="Viewed Count">
          <n-input-number v-model:value="formModel.viewed" placeholder="Times viewed" />
          <div v-if="formModel.errors.viewed" class="text-red-500 text-xs">{{ formModel.errors.viewed }}</div>
        </n-form-item>

        <!-- Recommended -->
        <n-form-item label="Recommended">
          <n-switch v-model:value="formModel.recommended" />
          <div v-if="formModel.errors.recommended" class="text-red-500 text-xs">{{ formModel.errors.recommended }}</div>
        </n-form-item>
        
        <!-- Meta Title -->
        <n-form-item path="meta_title" label="Meta Title">
          <n-input v-model:value="formModel.meta_title" placeholder="Enter meta title" />
          <div v-if="formModel.errors.meta_title" class="text-red-500 text-xs">{{ formModel.errors.meta_title }}</div>
        </n-form-item>

        <!-- Meta Keywords -->
        <n-form-item path="meta_keywords" label="Meta Keywords">
          <n-input v-model:value="formModel.meta_keywords" placeholder="Enter meta keywords, comma separated" />
          <div v-if="formModel.errors.meta_keywords" class="text-red-500 text-xs">{{ formModel.errors.meta_keywords }}</div>
        </n-form-item>

        <!-- Meta Description -->
        <n-form-item path="meta_description" label="Meta Description">
          <n-input type="textarea" v-model:value="formModel.meta_description" placeholder="Enter meta description" />
          <div v-if="formModel.errors.meta_description" class="text-red-500 text-xs">{{ formModel.errors.meta_description }}</div>
        </n-form-item>

        <!-- Place Images -->
        <n-form-item label="Place Images">
          <input type="file" multiple @input="formModel.images = $event.target.files" class="mb-2" />
          <div v-if="formModel.errors.images" class="text-red-500 text-xs">{{ formModel.errors.images }}</div>
          <!-- Display existing main images -->
          <div v-if="isEdit && placeData && placeData.images && placeData.images.length > 0" class="mt-2">
            <h4 class="font-semibold mb-1">Existing Main Images:</h4>
            <div class="flex flex-wrap gap-2">
              <div v-for="image in placeData.images" :key="image.id" class="relative">
                <img :src="'/storage/places/' + image.name" :alt="image.name || 'Place Image'" class="w-24 h-24 object-cover rounded border" />
                <!-- Optional: Add a delete button for individual existing images -->
              </div>
            </div>
          </div>
        </n-form-item>

        <!-- Dynamic Texts Section -->
        <n-divider title-placement="left">Texts</n-divider>
        <div v-for="(text, index) in formModel.texts" :key="text.id || `new-${index}`" class="border p-3 mb-3 rounded">
          <div class="flex justify-end mb-2">
            <n-button class="bg-danger" type="error" size="small" @click="removeText(index)">Remove Text</n-button>
          </div>
          <n-form-item :path="`texts[${index}].text_number`" label="Text Number">
            <n-input-number v-model:value="text.text_number" placeholder="Order" />
          </n-form-item>
          <n-form-item :path="`texts[${index}].title`" label="Text Title">
            <n-input v-model:value="text.title" placeholder="Text title" />
          </n-form-item>
          <n-form-item :path="`texts[${index}].body`" label="Text Body">
            <n-input type="textarea" v-model:value="text.body" placeholder="Text body" :autosize="{ minRows: 2 }" />
          </n-form-item>
          <n-form-item label="Text Images">
            <input type="file" multiple @input="text.images = $event.target.files" />
             <!-- Display existing images for this text item -->
            <div v-if="isEdit && text.existing_images && text.existing_images.length > 0" class="mt-2">
                <h5 class="font-semibold mb-1 text-sm">Existing Text Images:</h5>
                <div class="flex flex-wrap gap-2">
                    <div v-for="image in text.existing_images" :key="image.id" class="relative">
                        <img :src="'/storage/texts/' + image.name" :alt="image.name || 'Text Image'" class="w-20 h-20 object-cover rounded border" />
                        <!-- Optional: Add a delete button for individual existing text images -->
                    </div>
                </div>
            </div>
          </n-form-item>
        </div>
        <n-button type="dashed" @click="addText" class="w-full mb-4 bg-info">Add Text</n-button>
      </n-form>
      <template #footer>
        <n-button @click="closeDrawer" class="mr-2 bg-danger">Cancel</n-button>
        <n-button type="primary" @click="submitForm" class="bg-info" :loading="formModel.processing">Submit</n-button>
      </template>
    </n-drawer-content>
  </n-drawer>
</template>

<script setup>
import { ref, computed, watch, defineProps, defineEmits } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import {
    NDrawer, NDrawerContent, NInput, NSelect, NForm, NFormItem, NSwitch, NInputNumber, NDivider, NButton
} from 'naive-ui';

const props = defineProps({
  show: Boolean,
  isEdit: Boolean,
  placeData: Object, // For pre-filling the edit form, expected to have placeData.images and placeData.texts[].images with {id, url, name?}
  locations: Array,
  categories: Array,
  errors: Object,
});

const emit = defineEmits(['update:show', 'submit']);

const formRef = ref(null);

const defaultFormValues = {
  id: null,
  name: null,
  location_id: null,
  category_ids: [],
  body: null,
  map: null,
  viewed: 0,
  recommended: false,
  images: [], // For new image uploads
  texts: [],
  meta_title: null,
  meta_keywords: null,
  meta_description: null,
  _method: 'POST',
};

const formModel = useForm({ ...defaultFormValues });

const showDrawer = computed({
  get: () => props.show,
  set: (value) => emit('update:show', value),
});

const drawerTitle = computed(() => props.isEdit ? 'Edit Place' : 'Create Place');

const locationOptions = computed(() =>
  props.locations ? props.locations.map(loc => ({ label: loc.name, value: loc.id })) : []
);
const categoryOptions = computed(() =>
  props.categories ? props.categories.map(cat => ({ label: cat.name, value: cat.id })) : []
);

const addText = () => {
  formModel.texts.push({
    id: null,
    text_number: formModel.texts.length + 1,
    title: '',
    body: '',
    images: [], // For new image uploads for this text item
    existing_images: [], // To hold URLs of existing images for this text item
  });
};

const removeText = (index) => {
  formModel.texts.splice(index, 1);
};

const resetAndPopulateForm = () => {
  formModel.reset(); // Resets to defaultFormValues, including images: []
  formModel.texts = [];

  if (props.isEdit && props.placeData) {
    formModel.id = props.placeData.id;
    formModel.name = props.placeData.name;
    formModel.location_id = props.placeData.location_id;
    formModel.category_ids = props.placeData.categories ? props.placeData.categories.map(c => c.id) : [];
    formModel.body = props.placeData.body;
    formModel.map = props.placeData.map;
    formModel.viewed = props.placeData.viewed;
    formModel.recommended = !!props.placeData.recommended;
    formModel.meta_title = props.placeData.meta_title;
    formModel.meta_keywords = props.placeData.meta_keywords;
    formModel.meta_description = props.placeData.meta_description;
    
    // formModel.images is for new uploads, it should be empty initially for edit
    // Existing main images are displayed via props.placeData.images in the template

    formModel.texts = props.placeData.texts ? props.placeData.texts.map(text => ({
      id: text.id,
      text_number: text.text_number,
      title: text.title,
      body: text.body,
      images: [], // For new uploads for this text item
      existing_images: text.images || [] // Populate with existing images for display
    })) : [];
    formModel._method = 'PUT';
  } else {
    formModel._method = 'POST';
    addText(); // Add initial text item for create
  }
  formModel.clearErrors();
};

watch(() => props.show, (newValue) => {
  if (newValue) {
    resetAndPopulateForm();
  }
});

watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    formModel.errors = newErrors;
  }
}, { deep: true });

const closeDrawer = () => {
  showDrawer.value = false;
};

const submitForm = () => {
  // When submitting, you might need to handle deletion of existing images
  // or only send new images. This example sends all text data including existing_images for reference
  // but the backend should only process `images` fields (File objects) for new uploads and handle updates to texts.
  const formDataToSubmit = {
    ...formModel,
    texts: formModel.texts.map(text => ({
        id: text.id,
        text_number: text.text_number,
        title: text.title,
        body: text.body,
        images: text.images, // This will be the FileList for new uploads
        // existing_images are not typically sent back unless you have a specific mechanism to handle them (e.g., for deletion)
    }))
  };
  emit('submit', { ...formDataToSubmit, _method: props.isEdit ? 'PUT' : 'POST' });
};

</script> 