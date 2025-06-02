<template>
  <div class="m-3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Blog Posts Management</h2>
      <n-button type="primary" @click="openCreateDrawer" class="bg-blue-500 hover:bg-blue-600">Create Post</n-button>
    </div>

    <n-card>
      <n-data-table
        :columns="columns"
        :data="props.posts.data"
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
          <n-form-item path="title" label="Title">
            <n-input v-model:value="formModel.title" placeholder="Enter title" />
          </n-form-item>
          <n-form-item path="subject_ids" label="Subjects">
            <n-select
              v-model:value="formModel.subject_ids"
              placeholder="Select subjects"
              :options="subjectOptions"
              multiple
              clearable
            />
          </n-form-item>
          <n-form-item path="body" label="Body">
            <n-input type="textarea" v-model:value="formModel.body" placeholder="Enter body content" :autosize="{ minRows: 5 }" />
          </n-form-item>
          <n-form-item path="meta_title" label="Meta Title">
            <n-input v-model:value="formModel.meta_title" placeholder="Enter meta title" />
          </n-form-item>
          <n-form-item path="meta_description" label="Meta Description">
            <n-input type="textarea" v-model:value="formModel.meta_description" placeholder="Enter meta description" />
          </n-form-item>
          <n-form-item label="Recommended">
            <n-switch v-model:value="formModel.recommended" />
          </n-form-item>
          
          <!-- Post Images Section -->
          <n-form-item label="Post Images">
            <div class="space-y-3">
              <input type="file" @change="handleImagesUpload" accept="image/*" multiple class="block" />
              
              <!-- Display new images to be uploaded -->
              <div v-if="formModel.images.length > 0" class="space-y-2">
                <h4 class="text-sm font-medium">New Images:</h4>
                <div class="flex flex-wrap gap-2">
                  <div v-for="(image, index) in formModel.images" :key="'new-' + index" class="relative">
                    <NAvatar :src="URL.createObjectURL(image)" size="large" class="border" />
                    <n-button size="tiny" type="error" @click="removeNewImage(index)" class="absolute -top-1 -right-1 rounded-full w-5 h-5 p-0">×</n-button>
                  </div>
                </div>
              </div>
              
              <!-- Display existing images -->
              <div v-if="formModel.existing_images.length > 0" class="space-y-2">
                <h4 class="text-sm font-medium">Existing Images:</h4>
                <div class="flex flex-wrap gap-2">
                  <div v-for="(image, index) in formModel.existing_images" :key="'existing-' + index" class="relative">
                    <NAvatar :src="image.url" size="large" class="border" />
                    <n-button size="tiny" type="error" @click="removeExistingImage(index)" class="absolute -top-1 -right-1 rounded-full w-5 h-5 p-0">×</n-button>
                  </div>
                </div>
              </div>
            </div>
          </n-form-item>
          
          <!-- Texts Section -->
          <n-form-item label="Additional Texts">
            <div class="space-y-4">
              <n-button type="primary" @click="addNewText" size="small">Add New Text</n-button>
              
              <div v-for="(text, textIndex) in formModel.texts" :key="'text-' + textIndex" class="border p-4 rounded space-y-3">
                <div class="flex justify-between items-center">
                  <h4 class="font-medium">Text #{{ textIndex + 1 }}</h4>
                  <n-button size="small" type="error" @click="removeText(textIndex)">Remove Text</n-button>
                </div>
                
                <n-input
                  type="textarea"
                  v-model:value="text.body"
                  placeholder="Enter text content"
                  :autosize="{ minRows: 3 }"
                />
                
                <!-- Text Images -->
                <div class="space-y-2">
                  <label class="text-sm font-medium">Text Images:</label>
                  <input type="file" @change="handleTextImagesUpload(textIndex, $event)" accept="image/*" multiple class="block text-sm" />
                  
                  <!-- New text images -->
                  <div v-if="text.images.length > 0" class="space-y-1">
                    <span class="text-xs text-gray-600">New Images:</span>
                    <div class="flex flex-wrap gap-1">
                      <div v-for="(image, imageIndex) in text.images" :key="'text-new-' + imageIndex" class="relative">
                        <NAvatar :src="URL.createObjectURL(image)" size="medium" class="border" />
                        <n-button size="tiny" type="error" @click="removeTextNewImage(textIndex, imageIndex)" class="absolute -top-1 -right-1 rounded-full w-4 h-4 p-0 text-xs">×</n-button>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Existing text images -->
                  <div v-if="text.existing_images.length > 0" class="space-y-1">
                    <span class="text-xs text-gray-600">Existing Images:</span>
                    <div class="flex flex-wrap gap-1">
                      <div v-for="(image, imageIndex) in text.existing_images" :key="'text-existing-' + imageIndex" class="relative">
                        <NAvatar :src="image.url" size="medium" class="border" />
                        <n-button size="tiny" type="error" @click="removeTextExistingImage(textIndex, imageIndex)" class="absolute -top-1 -right-1 rounded-full w-4 h-4 p-0 text-xs">×</n-button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
    NDataTable, NButton, NSpace, NCard, NPopconfirm, NIcon, NTag, NAvatar, NTooltip,
    NDrawer, NDrawerContent, NInput, NSelect, NForm, NFormItem, NSwitch
} from 'naive-ui';
import { TrashOutline as DeleteIcon, PencilOutline as EditIcon } from '@vicons/ionicons5';

const props = defineProps({
  posts: Object,
  filters: Object,
  subjects: Array, // For subject select options
  errors: Object,
});

const loading = ref(false);
const showDrawer = ref(false);
const isEditing = ref(false);
const formRef = ref(null);

const defaultFormValues = {
  id: null,
  title: null,
  subject_ids: [],
  body: null,
  recommended: false,
  meta_title: null,
  meta_description: null,
  images: [], // Array to hold new image files
  existing_images: [], // Array to hold existing image data
  texts: [], // Array to hold text objects
  _method: 'POST',
};

const formModel = useForm({ ...defaultFormValues });

const drawerTitle = computed(() => isEditing.value ? 'Edit Post' : 'Create Post');

const subjectOptions = computed(() =>
  props.subjects ? props.subjects.map(sub => ({ label: sub.name, value: sub.id })) : []
);

const formRules = {
  title: [{ required: true, message: 'Title is required', trigger: 'blur' }],
  body: [{ required: true, message: 'Body is required', trigger: 'blur' }],
};

const handleImagesUpload = (event) => {
  const files = Array.from(event.target.files);
  formModel.images = [...formModel.images, ...files];
};

const removeNewImage = (index) => {
  formModel.images.splice(index, 1);
};

const removeExistingImage = (index) => {
  formModel.existing_images.splice(index, 1);
};

const addNewText = () => {
  formModel.texts.push({
    id: null,
    body: '',
    images: [],
    existing_images: []
  });
};

const removeText = (index) => {
  formModel.texts.splice(index, 1);
};

const handleTextImagesUpload = (textIndex, event) => {
  const files = Array.from(event.target.files);
  formModel.texts[textIndex].images = [...formModel.texts[textIndex].images, ...files];
};

const removeTextNewImage = (textIndex, imageIndex) => {
  formModel.texts[textIndex].images.splice(imageIndex, 1);
};

const removeTextExistingImage = (textIndex, imageIndex) => {
  formModel.texts[textIndex].existing_images.splice(imageIndex, 1);
};

const openCreateDrawer = () => {
  isEditing.value = false;
  formModel.reset();
  formModel.images = [];
  formModel.existing_images = [];
  formModel.texts = [];
  formModel._method = 'POST';
  showDrawer.value = true;
};

const openEditDrawer = (post) => {
  isEditing.value = true;
  formModel.reset();
  formModel.id = post.id;
  formModel.title = post.title;
  formModel.subject_ids = post.subjects ? post.subjects.map(s => s.id) : [];
  formModel.body = post.body;
  formModel.recommended = !!post.recommended;
  formModel.meta_title = post.meta_title;
  formModel.meta_description = post.meta_description;
  formModel.images = []; // Clear new images
  formModel.existing_images = post.images ? [...post.images] : []; // Populate existing images
  formModel.texts = post.texts ? post.texts.map(text => ({
    id: text.id,
    body: text.body,
    images: [], // Clear new images for this text
    existing_images: text.images ? [...text.images] : [] // Populate existing images for this text
  })) : [];
  formModel._method = 'PUT';
  showDrawer.value = true;
};

const handleFormSubmit = async () => {
  formRef.value?.validate(errors => {
    if (!errors) {
      const submissionRoute = isEditing.value ? route('admin.posts.update', formModel.id) : route('admin.posts.store');
      
      // Prepare form data for submission
      const formData = new FormData();
      
      // Add basic fields
      formData.append('title', formModel.title || '');
      formData.append('body', formModel.body || '');
      formData.append('meta_title', formModel.meta_title || '');
      formData.append('meta_description', formModel.meta_description || '');
      formData.append('recommended', formModel.recommended ? '1' : '0');
      
      // Add subject IDs
      if (formModel.subject_ids && formModel.subject_ids.length > 0) {
        formModel.subject_ids.forEach((subjectId, index) => {
          formData.append(`subject_ids[${index}]`, subjectId);
        });
      }
      
      // Add new post images
      if (formModel.images && formModel.images.length > 0) {
        formModel.images.forEach((image, index) => {
          formData.append(`images[${index}]`, image);
        });
      }
      
      // Add existing post images to keep (send their IDs)
      if (formModel.existing_images && formModel.existing_images.length > 0) {
        formModel.existing_images.forEach((image, index) => {
          formData.append(`existing_images[${index}]`, image.id);
        });
      }
      
      // Add texts data
      if (formModel.texts && formModel.texts.length > 0) {
        formModel.texts.forEach((text, textIndex) => {
          formData.append(`texts[${textIndex}][id]`, text.id || '');
          formData.append(`texts[${textIndex}][body]`, text.body || '');
          
          // Add new text images
          if (text.images && text.images.length > 0) {
            text.images.forEach((image, imageIndex) => {
              formData.append(`texts[${textIndex}][images][${imageIndex}]`, image);
            });
          }
          
          // Add existing text images to keep
          if (text.existing_images && text.existing_images.length > 0) {
            text.existing_images.forEach((image, imageIndex) => {
              formData.append(`texts[${textIndex}][existing_images][${imageIndex}]`, image.id);
            });
          }
        });
      }
      
      if (isEditing.value) {
        formData.append('_method', 'PUT');
      }
      
      const options = {
        preserveScroll: true,
        onSuccess: () => {
          showDrawer.value = false;
          alert(isEditing.value ? 'Post updated successfully!' : 'Post created successfully!');
          formModel.reset();
        },
        onError: (pageErrors) => {
          alert('Failed to submit post. Please check errors.');
          console.log('Submission errors:', pageErrors);
        },
      };
      
      Inertia.post(submissionRoute, formData, options);

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
    title: 'Main Image',
    key: 'main_image_url', // Changed to main_image_url if your prop provides it
    width: 100,
    render(row) {
      return row.main_image_url
        ? h(NAvatar, { src: row.main_image_url, size: 'medium', objectFit: 'cover', style: 'width: 60px; height: 40px;' })
        : 'N/A';
    }
  },
  { title: 'Title', key: 'title', width: 300, sorter: true, sortOrder: currentSortBy.value === 'title' ? currentSortOrder.value : false, ellipsis: { tooltip: true } },
  { title: 'Body Snippet', key: 'body', width: 300, ellipsis: { tooltip: true },
    render: (row) => row.body ? row.body.substring(0, 100) + (row.body.length > 100 ? '...' : '') : 'N/A'
  },
  {
    title: 'Post Images',
    key: 'images',
    width: 120,
    render(row) {
      if (!row.images || row.images.length === 0) return 'N/A';
      return h('div', { class: 'flex items-center' }, [
        h(NAvatar, {
          src: row.images[0].url || `/storage/posts/${row.images[0].name}`,
          alt: 'Post Image',
          size: 'medium',
          objectFit: 'cover',
          style: 'width: 60px; height: 40px; margin-right: 8px;'
        }),
        h(NTag, { size: 'small' }, { default: () => `${row.images.length} img(s)` })
      ]);
    }
  },
  {
    title: 'Texts Count',
    key: 'texts_count',
    width: 100,
    render(row) {
      return row.texts ? row.texts.length : 0;
    }
  },
  {
    title: 'Text Images Count',
    key: 'text_images_count',
    width: 150,
    render(row) {
        if (!row.texts) return 0;
        const totalTextImages = row.texts.reduce((acc, text) => acc + (text.images ? text.images.length : 0), 0);
        return totalTextImages;
    }
  },
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
    title: 'Subjects',
    key: 'subjects',
    width: 200,
    render(row) {
      if (!row.subjects || row.subjects.length === 0) return 'N/A';
      return h(NSpace, { vertical: true, size: 'small' }, {
        default: () => row.subjects.map(sub => h(NTag, { type: 'info', size: 'small', bordered: true }, { default: () => sub.name }))
      });
    }
  },
   {
    title: 'Created At',
    key: 'created_at',
    width: 180,
    sorter: true,
    sortOrder: currentSortBy.value === 'created_at' ? currentSortOrder.value : false,
    render: (row) => row.created_at ? new Date(row.created_at).toLocaleString() : 'N/A'
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
              default: () => 'Are you sure you want to delete this post?',
            }
          ),
        ],
      });
    },
  },
]);

const paginationProps = computed(() => ({
  page: props.posts.current_page,
  pageSize: props.posts.per_page,
  itemCount: props.posts.total,
  pageSlot: 7,
  showSizePicker: true,
  pageSizes: [10, 20, 50, 100].map(size => ({ label: String(size), value: size })),
  prefix: ({ itemCount }) => `${itemCount} total posts`,
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
  Inertia.get(route('admin.posts.index'), queryParams, {
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
  Inertia.delete(route('admin.posts.destroy', id), {
    preserveScroll: true,
    onStart: () => { loading.value = true; },
    onSuccess: () => { alert('Post deleted successfully!'); },
    onError: () => { alert('Failed to delete post.'); },
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