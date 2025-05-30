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

    <n-drawer v-model:show="showDrawer" :width="600">
      <n-drawer-content :title="drawerTitle" closable>
        <n-form ref="formRef" :model="formModel" :rules="formRules">
          <n-form-item path="name" label="Name">
            <n-input v-model:value="formModel.name" placeholder="Enter hotel name" />
          </n-form-item>
          <n-form-item path="location_id" label="Location">
            <n-select
              v-model:value="formModel.location_id"
              placeholder="Select location"
              :options="locationOptions"
              clearable
            />
          </n-form-item>
          <n-form-item path="stars" label="Stars">
            <n-input-number v-model:value="formModel.stars" :min="1" :max="5" placeholder="Hotel rating" />
          </n-form-item>
          <n-form-item path="description" label="Description">
            <n-input type="textarea" v-model:value="formModel.description" placeholder="Enter description" :autosize="{ minRows: 3 }" />
          </n-form-item>
          <n-form-item path="address" label="Address">
            <n-input type="textarea" v-model:value="formModel.address" placeholder="Enter address" />
          </n-form-item>
          <n-form-item label="Recommended">
            <n-switch v-model:value="formModel.recommended" />
          </n-form-item>
          <n-form-item path="main_image" label="Main Image">
            <input type="file" @change="handleMainImageUpload" accept="image/*" />
            <NAvatar v-if="formModel.main_image_url" :src="formModel.main_image_url" size="medium" class="ml-2" />
             <span v-else-if="isEditing && formModel.id && props.hotels.data.find(h=>h.id === formModel.id)?.main_image_url" class="ml-2">
                <NAvatar :src="props.hotels.data.find(h=>h.id === formModel.id)?.main_image_url" size="medium" />
            </span>
          </n-form-item>
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
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag, NAvatar,
    NDrawer, NDrawerContent, NInput, NSelect, NForm, NFormItem, NSwitch, NInputNumber
} from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon, StarOutline as StarIcon } from '@vicons/ionicons5';

const props = defineProps({
  hotels: Object,
  filters: Object,
  locations: Array,
  errors: Object,
});

const loading = ref(false);
const showDrawer = ref(false);
const isEditing = ref(false);
const formRef = ref(null);

const defaultFormValues = {
  id: null,
  name: null,
  location_id: null,
  stars: 3,
  description: null,
  address: null,
  recommended: false,
  main_image: null,
  main_image_url: null,
  _method: 'POST',
};

const formModel = useForm({ ...defaultFormValues });

const drawerTitle = computed(() => isEditing.value ? 'Edit Hotel' : 'Create Hotel');

const locationOptions = computed(() =>
  props.locations ? props.locations.map(loc => ({ label: loc.name, value: loc.id })) : []
);

const formRules = {
  name: [{ required: true, message: 'Name is required', trigger: 'blur' }],
  location_id: [{ type: 'number', required: true, message: 'Location is required', trigger: 'change' }],
  stars: [{ type: 'number', required: true, message: 'Stars rating is required', trigger: 'blur' }],
};

const handleMainImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    formModel.main_image = file;
    formModel.main_image_url = URL.createObjectURL(file);
  } else {
    formModel.main_image = null;
    formModel.main_image_url = null;
  }
};

const openCreateDrawer = () => {
  isEditing.value = false;
  formModel.reset();
  formModel._method = 'POST';
  showDrawer.value = true;
};

const openEditDrawer = (hotel) => {
  isEditing.value = true;
  formModel.reset();
  formModel.id = hotel.id;
  formModel.name = hotel.name;
  formModel.location_id = hotel.location_id;
  formModel.stars = hotel.stars;
  formModel.description = hotel.description;
  formModel.address = hotel.address;
  formModel.recommended = !!hotel.recommended;
  formModel.main_image = null;
  formModel.main_image_url = hotel.main_image_url || null; // Assuming main_image_url is available in hotel object
  formModel._method = 'PUT';
  showDrawer.value = true;
};

const handleFormSubmit = async () => {
  formRef.value?.validate(errors => {
    if (!errors) {
      const submissionRoute = isEditing.value ? route('admin.hotels.update', formModel.id) : route('admin.hotels.store');
      const options = {
        preserveScroll: true,
        onSuccess: () => {
          showDrawer.value = false;
          alert(isEditing.value ? 'Hotel updated successfully!' : 'Hotel created successfully!');
          formModel.reset();
          // Inertia.reload({ only: ['hotels'] });
        },
        onError: () => {
          alert('Failed to submit hotel. Please check errors.');
        },
        forceFormData: true,
      };

      if (isEditing.value) {
         Inertia.post(submissionRoute, { ...formModel, _method: 'PUT' }, options);
      } else {
        formModel.post(submissionRoute, options);
      }

    } else {
      console.log('Form validation failed:', errors);
      alert('Please correct the form errors.');
    }
  });
};

const currentSortBy = ref(props.filters?.sort_by || 'id');
const currentSortOrder = ref(props.filters?.sort_order || 'desc');

const columns = computed(() => [
  { title: 'ID', key: 'id', width: 60, sorter: true, sortOrder: currentSortBy.value === 'id' ? currentSortOrder.value : false },
  {
    title: 'Image',
    key: 'main_image_url', // Use main_image_url if available
    width: 80,
    render(row) {
      return row.main_image_url
        ? h(NAvatar, { src: row.main_image_url, size: 'medium', objectFit: 'cover' })
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
  { title: 'Rooms Count', key: 'rooms_count', width: 100, sorter: true, sortOrder: currentSortBy.value === 'rooms_count' ? currentSortOrder.value: false },
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
    else if (params.sort_by) params.sort_order = 'asc';
  }
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
  fetchData(1, pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleSortChange = (sorter) => {
  currentSortBy.value = sorter.columnKey;
  currentSortOrder.value = sorter.order || false;
  fetchData(1, paginationProps.value.pageSize, currentSortBy.value, currentSortOrder.value, props.filters);
};

const handleDelete = (id) => {
  Inertia.delete(route('admin.hotels.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onSuccess: () => { alert('Hotel deleted successfully!'); },
    onError: () => { alert('Failed to delete hotel.'); },
    onFinish: () => { loading.value = false; },
  });
};

watch(() => props.filters, (newFilters) => {
  currentSortBy.value = newFilters?.sort_by || 'id';
  currentSortOrder.value = newFilters?.sort_order || 'desc';
}, { deep: true, immediate: true });

watch(() => props.errors, (newErrors) => {
  if (newErrors && Object.keys(newErrors).length > 0) {
    alert('There were errors with your submission.');
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