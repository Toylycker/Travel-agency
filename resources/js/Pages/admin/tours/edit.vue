<template>
  <div class="container mx-auto p-4">
    <Head :title="'Edit Tour: ' + tour.name" />
    <h1 class="text-2xl font-bold mb-6">Edit Tour: {{ tour.name }}</h1>

    <!-- Global Success Message Area -->
    <n-alert v-if="
      formname.recentlySuccessful ||
      formname_cn.recentlySuccessful ||
      formmain_image.recentlySuccessful ||
      formbody.recentlySuccessful ||
      formbody_cn.recentlySuccessful ||
      formtotal_days.recentlySuccessful ||
      formtour_prices.recentlySuccessful ||
      formviewed.recentlySuccessful ||
      formrecommended.recentlySuccessful ||
      formimages.recentlySuccessful ||
      formnotes.recentlySuccessful ||
      formprices.recentlySuccessful ||
      formdays.recentlySuccessful ||
      formmap.recentlySuccessful // Added formmap
    " title="Success" type="success" class="mb-4" closable>
      Field updated successfully.
    </n-alert>

    <div class="space-y-6">
      <!-- Basic Info Card -->
      <n-card title="Basic Information">
        <n-grid cols="1 md:2" :x-gap="12" :y-gap="8">
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <div class="flex items-center space-x-2">
              <n-input v-model:value="formname.name" placeholder="Tour name" />
              <n-button @click="formname.put(route('admin.tours.edit.name', [tour.id]))" type="primary" :loading="formname.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
            </div>
            <div v-if="formname.errors.name" class="text-red-500 text-xs mt-1">{{ formname.errors.name }}</div>
          </n-gi>
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name (Chinese)</label>
            <div class="flex items-center space-x-2">
              <n-input v-model:value="formname_cn.name_cn" placeholder="Tour name in Chinese" />
              <n-button @click="formname_cn.put(route('admin.tours.edit.name_cn', [tour.id]))" type="primary" :loading="formname_cn.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
            </div>
            <div v-if="formname_cn.errors.name_cn" class="text-red-500 text-xs mt-1">{{ formname_cn.errors.name_cn }}</div>
          </n-gi>
        </n-grid>
      </n-card>

      <!-- Main Image Card -->
      <n-card title="Main Image">
        <n-grid cols="1" :y-gap="8">
          <n-gi>
            <div v-if="tour.main_image_url" class="mb-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Current Main Image</label>
              <n-image width="200" :src="tour.main_image_url" :alt="tour.name" class="rounded" />
            </div>
            <div v-else class="mb-2 text-gray-500">No current main image.</div>
            
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Main Image</label>
            <div class="flex items-center space-x-2">
              <n-upload
                :default-upload="false"
                :max="1"
                @change="handleMainImageChange"
                list-type="image"
              >
                <n-button class="bg-gray-200 hover:bg-gray-300">Select Image</n-button>
              </n-upload>
              <n-button 
                @click="formmain_image.post(route('admin.tours.edit.main_image', tour.id), { _method: 'put' })" 
                type="primary" 
                :loading="formmain_image.processing"
                :disabled="!formmain_image.main_image"
                class="bg-blue-500 hover:bg-blue-600"
              >Save Main Image</n-button>
            </div>
            <div v-if="formmain_image.progress" class="mt-1">
              <n-progress type="line" :percentage="formmain_image.progress.percentage" status="info" />
            </div>
            <div v-if="formmain_image.errors.main_image" class="text-red-500 text-xs mt-1">{{ formmain_image.errors.main_image }}</div>
          </n-gi>
        </n-grid>
      </n-card>

      <!-- Additional Images Card -->
      <n-card title="Additional Images">
        <label class="block text-sm font-medium text-gray-700 mb-1">Current Additional Images</label>
        <div v-if="tour.additional_images_urls && tour.additional_images_urls.length > 0" class="mb-2 flex flex-wrap gap-2">
          <n-image-group>
            <n-image v-for="img in tour.additional_images_urls" :key="img.id" width="100" :src="img.url" class="rounded object-cover" />
          </n-image-group>
        </div>
        <div v-else class="mb-2 text-gray-500">No current additional images.</div>

        <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Additional Images</label>
         <div class="flex items-center space-x-2">
            <n-upload
              multiple
              :default-upload="false"
              @change="handleAdditionalImagesChange"
              list-type="image-card"
            >
               <n-button class="bg-gray-200 hover:bg-gray-300">Select Images</n-button>
            </n-upload>
            <n-button 
              @click="formimages.post(route('admin.tours.edit.images', [tour.id]), { _method: 'put' })" 
              type="primary" 
              :loading="formimages.processing"
              :disabled="!formimages.images || formimages.images.length === 0"
              class="bg-blue-500 hover:bg-blue-600"
            >Save Additional Images</n-button>
          </div>
          <div v-if="formimages.progress" class="mt-1">
            <n-progress type="line" :percentage="formimages.progress.percentage" status="info" />
          </div>
          <div v-if="formimages.errors.images" class="text-red-500 text-xs mt-1">{{ formimages.errors.images }}</div>
      </n-card>

      <!-- Descriptions Card -->
      <n-card title="Descriptions & Map">
         <n-grid cols="1" :y-gap="12">
            <n-gi>
              <label class="block text-sm font-medium text-gray-700 mb-1">Body</label>
              <div class="flex items-center space-x-2">
                <n-input type="textarea" v-model:value="formbody.body" placeholder="Tour description" :autosize="{minRows: 3}"/>
                <n-button @click="formbody.put(route('admin.tours.edit.body', [tour.id]))" type="primary" :loading="formbody.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
              </div>
              <div v-if="formbody.errors.body" class="text-red-500 text-xs mt-1">{{ formbody.errors.body }}</div>
            </n-gi>
            <n-gi>
              <label class="block text-sm font-medium text-gray-700 mb-1">Body (Chinese)</label>
              <div class="flex items-center space-x-2">
                <n-input type="textarea" v-model:value="formbody_cn.body_cn" placeholder="Tour description in Chinese" :autosize="{minRows: 3}"/>
                <n-button @click="formbody_cn.put(route('admin.tours.edit.body_cn', [tour.id]))" type="primary" :loading="formbody_cn.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
              </div>
              <div v-if="formbody_cn.errors.body_cn" class="text-red-500 text-xs mt-1">{{ formbody_cn.errors.body_cn }}</div>
            </n-gi>
            <n-gi>
              <label class="block text-sm font-medium text-gray-700 mb-1">Map Embed URL</label>
              <div class="flex items-center space-x-2">
                <n-input type="textarea" v-model:value="formmap.map" placeholder="Paste map embed URL" :autosize="{minRows: 2}"/>
                <n-button @click="formmap.put(route('admin.tours.edit.map', [tour.id]))" type="primary" :loading="formmap.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
              </div>
              <div v-if="formmap.errors.map" class="text-red-500 text-xs mt-1">{{ formmap.errors.map }}</div>
            </n-gi>
         </n-grid>
      </n-card>
      
      <!-- Details Card -->
      <n-card title="Tour Details">
        <n-grid cols="1 md:2" :x-gap="12" :y-gap="8">
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Total Days</label>
            <div class="flex items-center space-x-2">
              <n-input-number v-model:value="formtotal_days.total_days" :min="1" class="w-full"/>
              <n-button @click="formtotal_days.put(route('admin.tours.edit.total_days', [tour.id]))" type="primary" :loading="formtotal_days.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
            </div>
            <div v-if="formtotal_days.errors.total_days" class="text-red-500 text-xs mt-1">{{ formtotal_days.errors.total_days }}</div>
          </n-gi>
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Base Price (Text)</label>
            <div class="flex items-center space-x-2">
              <n-input v-model:value="formtour_prices.tour_prices" placeholder="e.g., $500 per person"/>
              <n-button @click="formtour_prices.put(route('admin.tours.edit.tour_prices', [tour.id]))" type="primary" :loading="formtour_prices.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
            </div>
            <div v-if="formtour_prices.errors.tour_prices" class="text-red-500 text-xs mt-1">{{ formtour_prices.errors.tour_prices }}</div>
          </n-gi>
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Viewed Count</label>
            <div class="flex items-center space-x-2">
              <n-input-number v-model:value="formviewed.viewed" :min="0" class="w-full"/>
              <n-button @click="formviewed.put(route('admin.tours.edit.viewed', [tour.id]))" type="primary" :loading="formviewed.processing" class="bg-blue-500 hover:bg-blue-600">Save</n-button>
            </div>
            <div v-if="formviewed.errors.viewed" class="text-red-500 text-xs mt-1">{{ formviewed.errors.viewed }}</div>
          </n-gi>
           <n-gi class="flex items-end"> <!-- Aligns checkbox with button line -->
            <div class="flex items-center space-x-2">
              <n-checkbox v-model:checked="formrecommended.recommended">Recommended</n-checkbox>
              <n-button @click="formrecommended.put(route('admin.tours.edit.recommended', [tour.id]))" type="primary" :loading="formrecommended.processing" class="bg-orange-500 hover:bg-orange-600">Update Recommendation</n-button>
            </div>
            <div v-if="formrecommended.errors.recommended" class="text-red-500 text-xs mt-1 w-full">{{ formrecommended.errors.recommended }}</div>
          </n-gi>
        </n-grid>
      </n-card>

      <!-- Notes Card -->
      <n-card title="Included / Not Included Notes">
        <n-grid cols="1 md:2" :x-gap="12" :y-gap="8">
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Included Notes</label>
            <n-select 
              multiple 
              filterable 
              :options="props.notes" 
              label-field="name" 
              value-field="id" 
              v-model:value="formnotes.included" 
              placeholder="Select included notes" 
            />
            <div v-if="formnotes.errors.included" class="text-red-500 text-xs mt-1">{{ formnotes.errors.included }}</div>
          </n-gi>
          <n-gi>
            <label class="block text-sm font-medium text-gray-700 mb-1">Not Included Notes</label>
            <n-select 
              multiple 
              filterable 
              :options="props.notes" 
              label-field="name" 
              value-field="id" 
              v-model:value="formnotes.non_included" 
              placeholder="Select not included notes" 
            />
             <div v-if="formnotes.errors.non_included" class="text-red-500 text-xs mt-1">{{ formnotes.errors.non_included }}</div>
          </n-gi>
        </n-grid>
        <div class="mt-4 flex justify-end">
           <n-button @click="formnotes.put(route('admin.tours.edit.notes', [tour.id]))" type="primary" :loading="formnotes.processing" class="bg-blue-500 hover:bg-blue-600">Save Notes</n-button>
        </div>
      </n-card>

      <!-- Days Card -->
      <n-card title="Days Setup">
        <div class="flex justify-between items-center mb-2">
          <span class="text-sm font-medium text-gray-700">Manage individual days</span>
          <div>
            <n-button @click="add_day" type="info" size="small" class="mr-2 bg-green-500 hover:bg-green-600">Add Day</n-button>
            <n-button @click="formdays.put(route('admin.tours.edit.days', [tour.id]))" type="primary" size="small" :loading="formdays.processing" class="bg-blue-500 hover:bg-blue-600">Save All Day Changes</n-button>
          </div>
        </div>
         <div v-if="formdays.errors.days && typeof formdays.errors.days === 'string'" class="text-red-500 text-xs mb-2">{{ formdays.errors.days }}</div>

        <div class="space-y-4">
          <div v-for="(day, index) in formdays.days" :key="index" class="p-4 border rounded-md bg-gray-50">
            <div class="flex justify-between items-center mb-3">
               <h3 class="text-lg font-semibold">Day {{ day.day_number || (index + 1) }}</h3>
               <n-button @click="remove_day(index)" type="error" size="small" ghost class="border-red-500 text-red-500 hover:bg-red-100">Remove Day</n-button>
            </div>
            <n-grid cols="1" :y-gap="8">
              <n-gi>
                <label class="block text-xs font-medium text-gray-600">Day Number</label>
                <n-input-number v-model:value="day.day_number" :min="1" placeholder="Day number" class="w-full"/>
                <div v-if="formdays.errors[`days.${index}.day_number`]" class="text-red-500 text-xs mt-1">{{ formdays.errors[`days.${index}.day_number`] }}</div>
              </n-gi>
              <n-gi>
                <label class="block text-xs font-medium text-gray-600">Title</label>
                <n-input v-model:value="day.title" placeholder="Day title" />
                <div v-if="formdays.errors[`days.${index}.title`]" class="text-red-500 text-xs mt-1">{{ formdays.errors[`days.${index}.title`] }}</div>
              </n-gi>
              <n-gi>
                <label class="block text-xs font-medium text-gray-600">Body</label>
                <n-input type="textarea" v-model:value="day.body" placeholder="Day description" :autosize="{minRows: 2}" />
                <div v-if="formdays.errors[`days.${index}.body`]" class="text-red-500 text-xs mt-1">{{ formdays.errors[`days.${index}.body`] }}</div>
              </n-gi>
              <n-gi>
                <label class="block text-xs font-medium text-gray-600">Body (Chinese)</label>
                <n-input type="textarea" v-model:value="day.body_cn" placeholder="Day description in Chinese" :autosize="{minRows: 2}" />
                 <div v-if="formdays.errors[`days.${index}.body_cn`]" class="text-red-500 text-xs mt-1">{{ formdays.errors[`days.${index}.body_cn`] }}</div>
              </n-gi>
              <n-gi>
                <label class="block text-xs font-medium text-gray-600">Places</label>
                <n-select multiple filterable :options="places" label-field="name" value-field="id" v-model:value="day.places" placeholder="Select places" />
                <div v-if="formdays.errors[`days.${index}.places`]" class="text-red-500 text-xs mt-1">{{ formdays.errors[`days.${index}.places`] }}</div>
              </n-gi>
              <n-gi>
                <label class="block text-xs font-medium text-gray-600">Hotels</label>
                <n-select multiple filterable :options="hotels" label-field="name" value-field="id" v-model:value="day.hotels" placeholder="Select hotels" />
                <div v-if="formdays.errors[`days.${index}.hotels`]" class="text-red-500 text-xs mt-1">{{ formdays.errors[`days.${index}.hotels`] }}</div>
              </n-gi>
            </n-grid>
          </div>
        </div>
      </n-card>

      <!-- Detailed Prices Card -->
      <n-card title="Detailed Prices">
        <div class="flex justify-between items-center mb-2">
          <span class="text-sm font-medium text-gray-700">Manage individual price entries</span>
          <div>
            <n-button @click="add_price" type="info" size="small" class="mr-2 bg-green-500 hover:bg-green-600">Add Price</n-button>
            <n-button @click="formprices.put(route('admin.tours.edit.prices', [tour.id]))" type="primary" size="small" :loading="formprices.processing" class="bg-blue-500 hover:bg-blue-600">Save All Price Changes</n-button>
          </div>
        </div>
        <div v-if="formprices.errors.detailedPrices && typeof formprices.errors.detailedPrices === 'string'" class="text-red-500 text-xs mb-2">{{ formprices.errors.detailedPrices }}</div>
        
        <div class="space-y-3">
          <div v-for="(price, index) in formprices.detailedPrices" :key="index" class="p-3 border rounded-md bg-gray-50">
             <div class="flex justify-end items-center mb-2">
                <n-button @click="remove_price(index)" type="error" size="small" ghost class="border-red-500 text-red-500 hover:bg-red-100">Remove Price</n-button>
              </div>
              <n-grid cols="1 md:2" :x-gap="12" :y-gap="8">
                <n-gi>
                  <label class="block text-xs font-medium text-gray-600">Name</label>
                  <n-input v-model:value="price.name" placeholder="Price name (e.g., Adult)"/>
                  <div v-if="formprices.errors[`detailedPrices.${index}.name`]" class="text-red-500 text-xs mt-1">{{ formprices.errors[`detailedPrices.${index}.name`] }}</div>
                </n-gi>
                 <n-gi>
                  <label class="block text-xs font-medium text-gray-600">Price</label>
                  <n-input-number v-model:value="price.price" placeholder="0.00" :step="0.01" class="w-full"/>
                  <div v-if="formprices.errors[`detailedPrices.${index}.price`]" class="text-red-500 text-xs mt-1">{{ formprices.errors[`detailedPrices.${index}.price`] }}</div>
                </n-gi>
                <n-gi>
                  <label class="block text-xs font-medium text-gray-600">Name (Chinese)</label>
                  <n-input v-model:value="price.name_cn" placeholder="Price name in Chinese"/>
                   <div v-if="formprices.errors[`detailedPrices.${index}.name_cn`]" class="text-red-500 text-xs mt-1">{{ formprices.errors[`detailedPrices.${index}.name_cn`] }}</div>
                </n-gi>
               <n-gi>
                  <label class="block text-xs font-medium text-gray-600">Price (Chinese Currency)</label>
                  <n-input-number v-model:value="price.price_cn" placeholder="0.00" :step="0.01" class="w-full"/>
                   <div v-if="formprices.errors[`detailedPrices.${index}.price_cn`]" class="text-red-500 text-xs mt-1">{{ formprices.errors[`detailedPrices.${index}.price_cn`] }}</div>
                </n-gi>
              </n-grid>
          </div>
        </div>
      </n-card>
      
      <!-- Discount fields are currently not part of any specific form submission in original logic -->
      <!-- Consider adding them to a general "Tour Details" save or a dedicated discount save button -->

    </div>
  </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { 
  NInput, NInputNumber, NButton, NCheckbox, NSelect, NProgress,
  NCard, NGrid, NGi, NImage, NImageGroup, NUpload, NAlert
} from 'naive-ui'; // Added NProgress, NCard, NGrid, NGi, NImage, NImageGroup, NUpload, NAlert
import { ref } from 'vue'; // Added ref for file handling

const props = defineProps({
  tour: Object, 
  places: Array, 
  hotels: Array, 
  notes: Array, // This is form_notes in controller
  days: Object, // Expects { data: [...] } from DayResource::collection
  included: Array, 
  non_included: Array,
  // Add main_image_url and additional_images_urls if they are not part of tour object directly
});

// Initialize forms based on props
const formname = useForm({ name: props.tour.name });
const formname_cn = useForm({ name_cn: props.tour.name_cn });

const formmain_image = useForm({ main_image: null });
const handleMainImageChange = (options) => {
  if (options.fileList.length > 0) {
    formmain_image.main_image = options.fileList[0].file;
  } else {
    formmain_image.main_image = null;
  }
};

const formimages = useForm({ images: [] }); // Use an array for multiple files
const handleAdditionalImagesChange = (options) => {
  formimages.images = options.fileList.map(f => f.file);
};


const formbody = useForm({ body: props.tour.body });
const formbody_cn = useForm({ body_cn: props.tour.body_cn });
const formmap = useForm({ map: props.tour.map });
const formtotal_days = useForm({ total_days: props.tour.total_days });
const formtour_prices = useForm({ tour_prices: props.tour.tour_prices }); // This is the general price text field
// const formdiscount_percent = useForm({ discount_percent: props.tour.discount_percent }); // Not used by individual save
// const formdiscount_datetime_start = useForm({ discount_datetime_start: props.tour.discount_datetime_start }); // Not used
// const formdiscount_datetime_end = useForm({ discount_datetime_end: props.tour.discount_datetime_end }); // Not used
const formviewed = useForm({ viewed: props.tour.viewed });
const formrecommended = useForm({ recommended: props.tour.recommended ? true : false });


const formnotes = useForm({ 
  included: props.included || [], 
  non_included: props.non_included || [] 
});

// Prepare days for the form. props.days.data should be the array from DayResource::collection
const initialDays = props.days?.data?.map(day => ({
  id: day.id, // Important for backend to identify existing days
  day_number: day.day_number,
  title: day.title,
  body: day.body,
  body_cn: day.body_cn,
  places: day.places || [], // Assuming DayResource returns place IDs
  hotels: day.hotels || [], // Assuming DayResource returns hotel IDs
})) || [];

const formdays = useForm({ days: initialDays.length > 0 ? initialDays : [{ day_number: 1, title: '', body: '', body_cn: '', places: [], hotels: [] }] });

let add_day = () => { 
  const newDayNum = formdays.days.length > 0 ? Math.max(...formdays.days.map(d => d.day_number || 0)) + 1 : 1;
  formdays.days.push({ id: null, day_number: newDayNum, title: '', body: '', body_cn: '', places: [], hotels: [] });
}
let remove_day = (index) => { formdays.days.splice(index, 1) }


// Prepare prices for the form. tour.prices should be the array of detailed price objects
const initialPrices = props.tour.prices?.map(price => ({
  id: price.id, // Important for backend to identify existing prices
  name: price.name,
  price: parseFloat(price.price),
  name_cn: price.name_cn,
  price_cn: price.price_cn ? parseFloat(price.price_cn) : null, // Handle if price_cn is null
})) || [];

const formprices = useForm({ detailedPrices: initialPrices.length > 0 ? initialPrices : [{ name: '', price: null, name_cn: '', price_cn: null}] });

let add_price = () => { formprices.detailedPrices.push({ id: null, name: '', price: null, name_cn: '', price_cn: null }) }
let remove_price = (index) => { formprices.detailedPrices.splice(index, 1) }

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>