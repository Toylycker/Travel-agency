<template>
  <div class="page-header">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">
        Edit Guide
      </h2>
    </div>
  </div>
  <n-card>
    <n-form
      ref="formRef"
      :model="form"
      :rules="rules"
      @submit.prevent="handleSubmit"
    >
      <div class="grid grid-cols-2 gap-6">
        <n-form-item label="Name" path="name">
          <n-input v-model:value="form.name" placeholder="Enter name" />
        </n-form-item>

        <n-form-item label="Surname" path="surname">
          <n-input v-model:value="form.surname" placeholder="Enter surname" />
        </n-form-item>

        <n-form-item label="Phone" path="phone">
          <n-input v-model:value="form.phone" placeholder="Enter phone number" />
        </n-form-item>

        <n-form-item label="Email" path="email">
          <n-input v-model:value="form.email" placeholder="Enter email" />
        </n-form-item>

        <n-form-item label="Years of Experience" path="years_of_experience">
          <n-input-number
            v-model:value="form.years_of_experience"
            :min="0"
            placeholder="Enter years of experience"
          />
        </n-form-item>

        <n-form-item label="Languages" path="languages">
          <n-select
            v-model:value="form.languages"
            multiple
            placeholder="Select languages"
            :options="languageOptions"
          />
        </n-form-item>

        <n-form-item label="License Number" path="license_number">
          <n-input v-model:value="form.license_number" placeholder="Enter license number" />
        </n-form-item>

        <n-form-item label="License Expiry" path="license_expiry">
          <input
            type="date"
            v-model="form.license_expiry"
            class="form-control"
            placeholder="Select license expiry date"
          />
        </n-form-item>
      </div>

      <div class="mt-6">
        <n-form-item label="Bio" path="bio">
          <n-input
            v-model:value="form.bio"
            type="textarea"
            placeholder="Enter bio"
            :rows="3"
          />
        </n-form-item>

        <!-- //TODO resume ahndling should be done -->
        <!-- <n-form-item label="Resume" path="resume_path">
          <n-upload
            @update:file-list="handleUpload"
            :max="1"
          >
            <n-button>Upload Resume</n-button>
          </n-upload>
        </n-form-item> -->

        <n-form-item label="Status" path="is_active">
          <n-switch v-model:value="form.is_active" />
        </n-form-item>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <n-button @click="handleBack">
          Cancel
        </n-button>
        <n-button type="primary" class="bg-info" @click="handleSubmit">
          Update Guide
        </n-button>
      </div>
    </n-form>
  </n-card>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import {
  NButton,
  NCard,
  NForm,
  NFormItem,
  NInput,
  NInputNumber,
  NSelect,
  NUpload,
  NSwitch
} from 'naive-ui'
import { formatDate } from '@/lib/dateUtils'

const props = defineProps({
  guide: {
    type: Object,
    required: true
  }
})

const formRef = ref(null)

const form = useForm({
  name: props.guide.name,
  surname: props.guide.surname,
  phone: props.guide.phone,
  email: props.guide.email,
  bio: props.guide.bio,
  years_of_experience: props.guide.years_of_experience,
  languages: props.guide.languages || [],
  license_number: props.guide.license_number,
  license_expiry: formatDate(props.guide.license_expiry),
  resume: null,//will be file when upload happens
  is_active: props.guide.is_active ? true : false
})

const languageOptions = [
  { label: 'English', value: 'English' },
  { label: 'Spanish', value: 'Spanish' },
  { label: 'French', value: 'French' },
  { label: 'German', value: 'German' },
  { label: 'Chinese', value: 'Chinese' },
  { label: 'Japanese', value: 'Japanese' },
  { label: 'Russian', value: 'Russian' },
  { label: 'Arabic', value: 'Arabic' }
]

const rules = {
  name: {
    required: true,
    message: 'Please enter name',
    trigger: 'blur'
  },
  surname: {
    required: true,
    message: 'Please enter surname',
    trigger: 'blur'
  },
  email: {
    type: 'email',
    message: 'Please enter a valid email',
    trigger: ['blur', 'input']
  }
}

const handleBack = () => {
  window.location = route('admin.guides.index')
}

const handleUpload = (list) => {
  console.log(list);
  
  form.resume = list[0].file || null
}

const handleSubmit = () => {
  formRef.value?.validate((errors) => {
    if (!errors) {
      form.put(route('admin.guides.update', props.guide.id), {
      onSuccess: () => {
        alert('Guide updated successfully! 🎉');
      },
    });
    }
  })
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script> 