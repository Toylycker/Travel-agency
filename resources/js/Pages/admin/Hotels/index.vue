<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Hotels Management</h2>
      <n-button type="primary" @click="openCreateDrawer" class="bg-blue-500 hover:bg-blue-600">Create Hotel</n-button>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.hotels.data"
        :pagination="paginationProps"
        :loading="loading"
        :remote="true"
        :bordered="false"
        striped
        :scroll-x="1800"
        @update:page="handlePageChange"
        @update:page-size="handlePageSizeChange"
        @update:sorter="handleSortChange"
      />
    </n-card>

    <n-drawer v-model:show="showDrawer" :width="800" :auto-focus="false">
      <n-drawer-content :title="drawerTitle" closable>
        <n-form ref="formRef" :model="formModel" :rules="formRules">
          <!-- Hotel Name -->
          <n-form-item path="name" label="Hotel Name">
            <n-input v-model:value="formModel.name" placeholder="Enter hotel name" />
            <div v-if="formModel.errors.name" class="text-red-500 text-xs">{{ formModel.errors.name }}</div>
          </n-form-item>

          <!-- Stars -->
          <n-form-item path="stars" label="Stars">
            <n-input-number v-model:value="formModel.stars" :min="1" :max="5" placeholder="Hotel rating (1-5)" />
            <div v-if="formModel.errors.stars" class="text-red-500 text-xs">{{ formModel.errors.stars }}</div>
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
          
          <!-- Description -->
          <n-form-item path="description" label="Description">
            <n-input type="textarea" v-model:value="formModel.description" placeholder="Enter hotel description" :autosize="{minRows: 3}" />
            <div v-if="formModel.errors.description" class="text-red-500 text-xs">{{ formModel.errors.description }}</div>
          </n-form-item>

          <!-- Address -->
          <n-form-item path="address" label="Address">
            <n-input type="textarea" v-model:value="formModel.address" placeholder="Enter hotel address" />
            <div v-if="formModel.errors.address" class="text-red-500 text-xs">{{ formModel.errors.address }}</div>
          </n-form-item>
          
          <!-- Viewed -->
          <n-form-item path="viewed" label="Viewed Count (Hotel)">
            <n-input-number v-model:value="formModel.viewed" placeholder="Times hotel viewed" />
            <div v-if="formModel.errors.viewed" class="text-red-500 text-xs">{{ formModel.errors.viewed }}</div>
          </n-form-item>

          <!-- Recommended -->
          <n-form-item label="Recommended">
            <n-switch v-model:value="formModel.recommended" />
            <div v-if="formModel.errors.recommended" class="text-red-500 text-xs">{{ formModel.errors.recommended }}</div>
          </n-form-item>

          <!-- Main Image -->
          <n-form-item path="main_image" label="Main Image">
            <input type="file" @change="handleMainImageUpload" accept="image/*" class="mb-2" />
            <NAvatar v-if="formModel.main_image_url" :src="formModel.main_image_url" size="large" class="ml-2" />
            <div v-if="formModel.errors.main_image" class="text-red-500 text-xs">{{ formModel.errors.main_image }}</div>
            <!-- TODO: Display existing main image on edit -->
          </n-form-item>

          <!-- Additional Images -->
          <n-form-item label="Additional Images">
            <input type="file" multiple @input="formModel.images = Array.from($event.target.files)" class="mb-2" />
             <div v-if="formModel.errors.images" class="text-red-500 text-xs">{{ formModel.errors.images }}</div>
            <!-- TODO: Display existing additional images on edit & handle removal -->
          </n-form-item>

          <!-- Dynamic Rooms Section -->
          <n-divider title-placement="left">Rooms</n-divider>
          <div v-for="(room, index) in formModel.rooms" :key="index" class="border p-3 mb-3 rounded">
            <div class="flex justify-between items-center mb-2">
              <h4 class="text-md font-semibold">Room {{ index + 1 }}</h4>
              <n-button type="error" size="small" @click="removeRoom(index)">Remove Room</n-button>
            </div>
            <n-form-item :path="`rooms[${index}].name`" label="Room Name">
              <n-input v-model:value="room.name" placeholder="e.g., Deluxe Suite" />
            </n-form-item>
            <n-form-item :path="`rooms[${index}].body`" label="Room Description">
              <n-input type="textarea" v-model:value="room.body" placeholder="Room features, size, etc." :autosize="{minRows: 2}"/>
            </n-form-item>
            <n-form-item :path="`rooms[${index}].room_quan`" label="Quantity of this Room Type">
              <n-input-number v-model:value="room.room_quan" placeholder="Number of rooms" :min="0"/>
            </n-form-item>
            <n-form-item :path="`rooms[${index}].price`" label="Price per Night">
              <n-input-number v-model:value="room.price" placeholder="0.00" :min="0">
                <template #prefix>Rp</template>
              </n-input-number>
            </n-form-item>
            <n-form-item :path="`rooms[${index}].viewed`" label="Viewed Count (Room)">
              <n-input-number v-model:value="room.viewed" placeholder="Times room viewed" :min="0" />
            </n-form-item>
             <!-- TODO: Room images if needed -->
          </div>
          <n-button type="dashed" @click="addRoom" class="w-full mb-4">Add Room Type</n-button>
        
        </n-form>
        <template #footer>
          <n-button @click="showDrawer = false" class="mr-2">Cancel</n-button>
          <n-button type="primary" @click="handleFormSubmit" :loading="formModel.processing">Submit</n-button>
        </template>
      </n-drawer-content>
    </n-drawer>

  </div>
</template>

<script setup>
import { h, ref, computed, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import {
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag, NAvatar, NTooltip,
    NDrawer, NDrawerContent, NInput, NSelect, NForm, NFormItem, NSwitch, NInputNumber, NDivider
} from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon, StarOutline as StarIcon } from '@vicons/ionicons5';

const props = defineProps({
  hotels: Object, // Paginated hotels from controller
  filters: Object, // For n-data-table remote sorting/filtering
  locations: Array, // For location select options
  // hotel: Object, // Singular hotel data for editing, passed by controller
  errors: Object, // Validation errors from backend
});

const loading = ref(false);
const showDrawer = ref(false);
const isEditing = ref(false);
const formRef = ref(null); // For Naive UI form validation access

const defaultFormValues = {
  id: null,
  name: null,
  stars: 3,
  main_image: null, // Will hold File object for new upload
  main_image_url: null, // For previewing new main image upload
  location_id: null,
  description: null,
  address: null,
  viewed: 0, // Hotel viewed count
  recommended: false,
  images: [], // Array of File objects for additional hotel images
  // existing_images_urls: [], // To store URLs of existing additional images on edit
  rooms: [], 
  _method: 'POST',
};

const formModel = useForm({ ...defaultFormValues });

const drawerTitle = computed(() => isEditing.value ? 'Edit Hotel' : 'Create Hotel');

const locationOptions = computed(() =>
  props.locations ? props.locations.map(loc => ({ label: loc.name, value: loc.id })) : []
);

// Basic validation rules (incomplete, extend as needed)
const formRules = {
  name: [{ required: true, message: 'Hotel name is required', trigger: 'blur' }],
  stars: [{ type: 'number', required: true, message: 'Star rating is required', trigger: ['blur', 'change'] }],
  location_id: [{ type: 'number', required: true, message: 'Location is required', trigger: 'change' }],
  description: [{ required: true, message: 'Description is required', trigger: 'blur' }],
  // TODO: Add rules for rooms array if necessary
};

const handleMainImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    formModel.main_image = file;
    formModel.main_image_url = URL.createObjectURL(file);
  } else {
    formModel.main_image = null;
    // Keep existing image URL if editing and no new file is selected
    if (!isEditing.value) {
        formModel.main_image_url = null;
    }
  }
};

const addRoom = () => {
  formModel.rooms.push({
    id: null, // For existing rooms during edit
    name: '',
    body: '',
    room_quan: 1,
    price: null,
    viewed: 0, 
    // images: [], // If rooms have their own images
    // existing_room_images_urls: [],
  });
};

const removeRoom = (index) => {
  formModel.rooms.splice(index, 1);
};

const openCreateDrawer = () => {
  isEditing.value = false;
  formModel.reset();
  formModel.rooms = []; // Ensure rooms are reset
  addRoom(); // Add one initial room for convenience
  formModel._method = 'POST';
  formModel.clearErrors();
  showDrawer.value = true;
};

const openEditDrawer = (hotelData) => {
  isEditing.value = true;
  formModel.reset(); // Reset to defaults then populate
  formModel.id = hotelData.id;
  formModel.name = hotelData.name;
  formModel.stars = hotelData.stars;
  formModel.location_id = hotelData.location_id;
  formModel.description = hotelData.description;
  formModel.address = hotelData.address;
  formModel.viewed = hotelData.viewed;
  formModel.recommended = !!hotelData.recommended;
  
  formModel.main_image = null; // Clear previous file object
  formModel.main_image_url = hotelData.main_image_url || null; // Use existing image URL for preview
  
  formModel.images = []; // Clear file input for additional images
  // formModel.existing_images_urls = hotelData.images ? hotelData.images.map(img => img.url) : []; // Assuming images prop has URLs
  // TODO: Display existing additional images and handle their removal/replacement

  formModel.rooms = hotelData.rooms ? hotelData.rooms.map(room => ({
    id: room.id,
    name: room.name,
    body: room.body,
    room_quan: room.room_quan,
    price: room.price,
    viewed: room.viewed,
    // images: [],
    // existing_room_images_urls: room.images ? room.images.map(img => img.url) : []
  })) : [];
  
  if (formModel.rooms.length === 0) {
      addRoom(); // Add a default room if none exist
  }

  formModel._method = 'PUT';
  formModel.clearErrors();
  showDrawer.value = true;
};

const handleFormSubmit = () => {
  formRef.value?.validate(errors => {
    if (!errors) {
      const submissionRoute = isEditing.value ? route('admin.hotels.update', formModel.id) : route('admin.hotels.store');
      const options = {
        preserveScroll: true,
        onSuccess: () => {
          showDrawer.value = false;
          alert(isEditing.value ? 'Hotel updated successfully!' : 'Hotel created successfully!');
          formModel.reset();
          // Inertia.reload({ only: ['hotels'] }); // To refresh n-data-table
        },
        onError: (pageErrors) => {
          if (pageErrors) formModel.errors = pageErrors;
          alert('Failed to submit hotel. Please check errors.');
        },
        forceFormData: true, // Crucial for file uploads
      };

      if (isEditing.value) {
        Inertia.post(submissionRoute, { ...formModel, _method: 'PUT' }, options);
      } else {
        formModel.post(submissionRoute, options);
      }
    } else {
      alert('Please correct the form errors.');
    }
  });
};

// N-DATA-TABLE specifics
const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

const columns = computed(() => [
  { title: 'ID', key: 'id', width: 60, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  {
    title: 'Image',
    key: 'main_image_url',
    width: 80,
    render(row) {
      return row.main_image_url
        ? h(NAvatar, { src: row.main_image_url, size: 'medium', objectFit: 'cover', style: 'width: 60px; height: 40px;' })
        : (row.main_image ? h(NAvatar, { src: '/storage/hotels/' + row.main_image, size: 'medium', objectFit: 'cover' }) : 'N/A');
    }
  },
  { title: 'Name', key: 'name', width: 250, sorter: true, sortOrder: currentSortBy.value === 'name' ? currentSortOrder.value : false, ellipsis: { tooltip: true } },
  {
    title: 'Stars',
    key: 'stars',
    width: 100,
    sorter: true,
    sortOrder: currentSortBy.value === 'stars' ? currentSortOrder.value : false,
    render(row) {
      if (!row.stars) return 'N/A';
      const starsArray = [];
      for (let i = 0; i < row.stars; i++) {
        starsArray.push(h(NIcon, { component: StarIcon, style: 'color: #ffb400;' }));
      }
      return h(NSpace, {justify: 'center'}, () => starsArray);
    }
  },
  { title: 'Location', key: 'location.name', width: 150, sorter: true, render: (row) => row.location?.name || 'N/A', sortOrder: currentSortBy.value === 'location.name' ? currentSortOrder.value : false },
  { title: 'Viewed', key: 'viewed', width: 80, sorter: true, sortOrder: currentSortBy.value === 'viewed' ? currentSortOrder.value : false },
  {
    title: 'Recommended',
    key: 'recommended',
    width: 120,
    sorter: true,
    sortOrder: currentSortBy.value === 'recommended' ? currentSortOrder.value : false,
    render(row) {
      return h(NTag, { type: row.recommended ? 'success' : 'error', size: 'small' }, { default: () => (row.recommended ? 'Yes' : 'No') });
    }
  },
  { 
    title: 'Rooms Count', 
    key: 'rooms_count', 
    width: 100, 
    sorter: true, // Assuming backend supports sorting by rooms_count
    sortOrder: currentSortBy.value === 'rooms_count' ? currentSortOrder.value: false, 
    render: (row) => row.rooms_count || (row.rooms ? row.rooms.length : 0) 
  },
  {
    title: 'Actions',
    key: 'actions',
    width: 180,
    fixed: 'right',
    render(row) {
      return h(NSpace, null, {
        default: () => [
          h(NButton, {
            type: 'primary',
            size: 'small',
            class:'bg-yellow-500 hover:bg-yellow-600',
            onClick: () => openEditDrawer(row)
          }, { icon: () => h(NIcon, null, {default: () => h(EditIcon)}), default: () => 'Edit' }),
          h(
            NPopconfirm,
            {
              onPositiveClick: () => handleDelete(row.id),
              positiveButtonProps: { type: 'error', class: 'bg-red-600 hover:bg-red-700' }
            },
            {
              trigger: () => h(NButton, { type: 'error', size: 'small', class:'bg-red-500 hover:bg-red-600' }, { icon: () => h(NIcon, null, { default: () => h(DeleteIcon) }), default: () => 'Delete' }),
              default: () => 'Are you sure you want to delete this hotel?',
            }
          ),
        ],
      });
    },
  },
]);

const paginationProps = computed(() => ({
  page: props.hotels.current_page,
  pageSize: props.hotels.per_page,
  itemCount: props.hotels.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [10, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total hotels`,
}));

const getQueryParams = (page, pageSize, sortBy, sortOrder, activeFilters = props.filters) => {
  let params = { page: page, perPage: pageSize };
  if (sortBy) {
    params.sort_by = sortBy;
    if (sortOrder === 'ascend' || sortOrder === 'asc') params.sort_order = 'asc';
    else if (sortOrder === 'descend' || sortOrder === 'desc') params.sort_order = 'desc';
    else if (params.sort_by && !sortOrder) params.sort_order = 'asc'; // Default to asc if only sortBy is present
  }
  // TODO: Include other activeFilters if implemented (e.g., search text)
  return params;
};

const fetchData = (page, pageSize, sortBy, sortOrder, activeFilters) => {
  const queryParams = getQueryParams(page, pageSize, sortBy, sortOrder, activeFilters);
  loading.value = true;
  Inertia.get(route('admin.hotels.index'), queryParams, {
    preserveState: true,
    replace: true,
    preserveScroll: true,
    onFinish: () => { loading.value = false; }
  });
};

const handlePageChange = (page) => {
  fetchData(page, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handlePageSizeChange = (pageSize) => {
  fetchData(1, pageSize, currentSortBy.value, currentSortOrder.value, props.filters); // Reset to page 1
};

const handleSortChange = (sorter) => {
  currentSortBy.value = sorter.columnKey;
  currentSortOrder.value = sorter.order || false; 
  fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters); // Reset to page 1
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.hotels.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onSuccess: () => { 
        alert('Hotel deleted successfully!'); 
        // Optionally, call fetchData if list doesn't auto-update due to Inertia partial reload nuances
        // fetchData(props.hotels.current_page, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
    },
    onError: () => { alert('Failed to delete hotel.'); },
    onFinish: () => { loading.value = false; },
  });
};

watch(() => props.filters, (newFilters) => {
  currentSortBy.value = newFilters?.sort_by || 'id';
  currentSortOrder.value = newFilters?.sort_order || 'desc';
  // Optionally trigger fetchData if filters change from external source, though usually handled by user interaction.
}, { deep: true, immediate: true });

watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    formModel.errors = newErrors; // Assign server-side validation errors to form model
  }
}, { immediate: true, deep: true });

</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>

<style scoped>
/* Add any specific styles if needed */
</style>