<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Places Management</h2>
      <n-button type="primary" @click="openCreateDrawer" class="bg-blue-500 hover:bg-blue-600">Create Place</n-button>
    </div>

    <!-- Drawer for Create/Edit -->
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
              label-field="name"
              value-field="id"
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
              label-field="name"
              value-field="id"
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
            <!-- TODO: Display existing images for edit -->
          </n-form-item>

          <!-- Dynamic Texts Section -->
          <n-divider title-placement="left">Texts</n-divider>
          <div v-for="(text, index) in formModel.texts" :key="index" class="border p-3 mb-3 rounded">
            <div class="flex justify-end mb-2">
              <n-button type="error" size="small" @click="removeText(index)">Remove Text</n-button>
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
              <!-- TODO: Display existing images for this text item during edit -->
            </n-form-item>
          </div>
          <n-button type="dashed" @click="addText" class="w-full mb-4">Add Text</n-button>
        </n-form>
        <template #footer>
          <n-button @click="showDrawer = false" class="mr-2">Cancel</n-button>
          <n-button type="primary" @click="handleFormSubmit" :loading="formModel.processing">Submit</n-button>
        </template>
      </n-drawer-content>
    </n-drawer>

    <!-- Data Table -->
    <n-card class="mt-4">
       <n-table :bordered="true" :single-line="false" striped>
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Location</th>
            <th>Categories</th>
            <th>Viewed</th>
            <th>Recommended</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="place in places.data" :key="place.id">
            <td>{{ place.id }}</td>
            <td>{{ place.name }}</td>
            <td>{{ place.location?.name || 'N/A' }}</td>
            <td>
              <n-space vertical size="small">
                <n-tag v-for="category in place.categories" :key="category.id" type="info" size="small" bordered>
                  {{ category.name }}
                </n-tag>
              </n-space>
            </td>
            <td>{{ place.viewed }}</td>
            <td>
              <n-tag :type="place.recommended ? 'success' : 'error'" size="small">
                {{ place.recommended ? 'Yes' : 'No' }}
              </n-tag>
            </td>
            <td>
              <n-space>
                <n-button type="primary" size="small" @click="openEditDrawer(place)">Edit</n-button>
                <n-popconfirm @positive-click="handleDelete(place.id)">
                  <template #trigger>
                    <n-button type="error" size="small">Delete</n-button>
                  </template>
                  Are you sure you want to delete this place?
                </n-popconfirm>
              </n-space>
            </td>
          </tr>
        </tbody>
      </n-table>
      <div class="mt-4">
        <Pagination :links='places.links' />
      </div>
    </n-card>
  </div>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import {
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag, NTooltip,
    NDrawer, NDrawerContent, NInput, NSelect, NForm, NFormItem, NSwitch, NInputNumber, NDivider, NTable
} from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon } from '@vicons/ionicons5';
import Pagination from '@/Shared/Pagination.vue';


const props = defineProps({
  places: Object, // Paginated places
  locations: Array,
  categories: Array,
  // Controller needs to pass 'place' object (singular) when an edit route is hit.
  // This 'place' should contain all details for pre-filling the edit form.
  place: Object, // For pre-filling the edit form
  errors: Object,
});

const showDrawer = ref(false);
const isEditing = ref(false);
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
  images: [], // Will hold File objects for new uploads
  texts: [],
  meta_title: null,
  meta_keywords: null,
  meta_description: null,
  _method: 'POST',
};

const formModel = useForm({ ...defaultFormValues });

const drawerTitle = computed(() => isEditing.value ? 'Edit Place' : 'Create Place');

const locationOptions = computed(() =>
  props.locations ? props.locations.map(loc => ({ label: loc.name, value: loc.id })) : []
);
const categoryOptions = computed(() =>
  props.categories ? props.categories.map(cat => ({ label: cat.name, value: cat.id })) : []
);

const addText = () => {
  formModel.texts.push({
    id: null, // for existing texts during edit
    text_number: formModel.texts.length + 1,
    title: '',
    body: '',
    images: [], // Will hold File objects
    // existing_images: [], // to hold URLs of existing images for a text item
  });
};

const removeText = (index) => {
  formModel.texts.splice(index, 1);
};

const openCreateDrawer = () => {
  isEditing.value = false;
  formModel.reset();
  formModel.texts = []; // Ensure texts are reset for create
  addText(); // Add one initial text item for convenience
  formModel._method = 'POST';
  formModel.clearErrors();
  showDrawer.value = true;
};

const openEditDrawer = (placeData) => {
  isEditing.value = true;
  formModel.reset(); // Reset to defaults then populate
  formModel.id = placeData.id;
  formModel.name = placeData.name;
  formModel.location_id = placeData.location_id;
  formModel.category_ids = placeData.categories ? placeData.categories.map(c => c.id) : [];
  formModel.body = placeData.body;
  formModel.map = placeData.map;
  formModel.viewed = placeData.viewed;
  formModel.recommended = !!placeData.recommended;
  formModel.meta_title = placeData.meta_title;
  formModel.meta_keywords = placeData.meta_keywords;
  formModel.meta_description = placeData.meta_description;

  // Clear out file input for main images, user will re-upload if they want to change
  formModel.images = []; 
  // TODO: Display existing main images. Requires placeData.images to have URLs.

  formModel.texts = placeData.texts ? placeData.texts.map(text => ({
    id: text.id, // Keep ID for update
    text_number: text.text_number,
    title: text.title,
    body: text.body,
    images: [], // Clear file input for text images, user re-uploads to change
    // existing_images: text.images.map(img => img.url) // Assuming text.images has URLs
    // TODO: Display existing text images
  })) : [];
  
  if (formModel.texts.length === 0) { // Ensure at least one text item for editing if none exist
      addText();
  }

  formModel._method = 'PUT';
  formModel.clearErrors();
  showDrawer.value = true;
};

const handleFormSubmit = () => {
  // formRef.value?.validate(errors => { // Naive UI validation, if rules are set
    // if (!errors) {
      const options = {
        preserveScroll: true,
        onSuccess: () => {
          showDrawer.value = false;
          alert(isEditing.value ? 'Place updated successfully!' : 'Place created successfully!');
          formModel.reset();
          Inertia.reload({ only: ['places'] }); // Refresh paginated data
        },
        onError: (pageErrors) => {
          // Manually assign errors to formModel if not automatically handled by useForm
          if (pageErrors) {
            formModel.errors = pageErrors;
          }
          alert('Failed to submit place. Please check errors.');
        },
        forceFormData: true, // Crucial for file uploads
      };

      if (isEditing.value) {
        // Inertia.post for PUT with files
        Inertia.post(route('admin.places.update', formModel.id), { ...formModel, _method: 'PUT' }, options);
      } else {
        formModel.post(route('admin.places.store'), options);
      }
    // } else {
    //   alert('Please correct the form errors.');
    // }
  // });
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.places.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
        alert('Place deleted successfully!');
        Inertia.reload({ only: ['places'] });
    },
    onError: () => {
        alert('Failed to delete place.');
    },
  });
};

// Watch for external errors if any (e.g. from session flash)
watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    formModel.errors = newErrors; // Assign server-side validation errors
    // alert('There were errors from the server.');
  }
}, { immediate: true, deep: true });


// Keep table related logic from original if it was using remote data
// This example assumes props.places is paginated.
// If it was local data before, this part would be different.
const loading = ref(false); // This was in your previous version for table loading.
                           // If data is now always fully passed, it might not be needed.

// Pagination and sorting logic (if it was used previously and props.places is paginated)
// If props.places is just a simple array, this remote data fetching logic is not needed.
// The provided original code snippet for Places/index.vue does not show remote sorting/pagination handling in script setup.
// It used a separate Pagination.vue component and passed places.links.
// The n-data-table used previously had its own remote data handling which is removed in favor of n-table.
// For now, I'm keeping the table simple. If advanced sorting/filtering is needed on n-table,
// it has to be implemented manually or switch back to n-data-table with appropriate props.

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>

<style scoped>
/* Add any specific styles if needed */
</style>