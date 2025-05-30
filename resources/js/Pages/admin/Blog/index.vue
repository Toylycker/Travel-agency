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
          <n-form-item path="main_image" label="Main Image">
            <input type="file" @change="handleMainImageUpload" accept="image/*" />
            <NAvatar v-if="formModel.main_image_url" :src="formModel.main_image_url" size="medium" class="ml-2" />
            <span v-else-if="isEditing && formModel.id && props.posts.data.find(p=>p.id === formModel.id)?.main_image_url" class="ml-2">
                <NAvatar :src="props.posts.data.find(p=>p.id === formModel.id)?.main_image_url" size="medium" />
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
  main_image: null, // This will hold the File object
  main_image_url: null, // For previewing new uploads
  _method: 'POST', // For handling PUT in Inertia form helper
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
  formModel.main_image = null; // Clear previous file object
  formModel.main_image_url = post.main_image_url || null; // Keep existing image URL for preview
  formModel._method = 'PUT';
  showDrawer.value = true;
};

const handleFormSubmit = async () => {
  formRef.value?.validate(errors => {
    if (!errors) {
      const submissionRoute = isEditing.value ? route('admin.posts.update', formModel.id) : route('admin.posts.store');
      const options = {
        preserveScroll: true,
        onSuccess: () => {
          showDrawer.value = false;
          alert(isEditing.value ? 'Post updated successfully!' : 'Post created successfully!');
          formModel.reset(); // Reset form after successful submission
          // Inertia.reload({ only: ['posts'] });
        },
        onError: (pageErrors) => {
          // Errors are in pageErrors.props.errors
          // formModel.errors = pageErrors; // if you want to use form helper's error handling
          alert('Failed to submit post. Please check errors.');
        },
        forceFormData: true, // Important for file uploads
      };
      
      if(isEditing.value) {
          // Inertia's form helper with PUT for file uploads needs special handling
          // We use `post` with `_method: 'PUT'`
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