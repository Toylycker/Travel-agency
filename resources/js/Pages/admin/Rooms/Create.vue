<template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold mb-6">Create New Room</h1>
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <n-input v-model:value="form.name" id="name" type="text" placeholder="Enter room name" class="mt-1"/>
                                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                                </div>

                                <!-- Name CN -->
                                <div>
                                    <label for="name_cn" class="block text-sm font-medium text-gray-700">Name (Chinese)</label>
                                    <n-input v-model:value="form.name_cn" id="name_cn" type="text" placeholder="输入房间名称" class="mt-1"/>
                                    <div v-if="form.errors.name_cn" class="text-red-500 text-sm mt-1">{{ form.errors.name_cn }}</div>
                                </div>

                                <!-- Hotel -->
                                <div>
                                    <label for="hotel_id" class="block text-sm font-medium text-gray-700">Hotel</label>
                                    <n-select
                                        v-model:value="form.hotel_id"
                                        filterable
                                        placeholder="Select Hotel"
                                        :options="hotelOptions"
                                        label-field="name"
                                        value-field="id"
                                        class="mt-1"
                                    />
                                    <div v-if="form.errors.hotel_id" class="text-red-500 text-sm mt-1">{{ form.errors.hotel_id }}</div>
                                </div>

                                <!-- Room Quantity -->
                                <div>
                                    <label for="room_quan" class="block text-sm font-medium text-gray-700">Room Quantity</label>
                                    <n-input-number v-model:value="form.room_quan" id="room_quan" placeholder="Enter quantity" :min="1" class="mt-1 w-full"/>
                                    <div v-if="form.errors.room_quan" class="text-red-500 text-sm mt-1">{{ form.errors.room_quan }}</div>
                                </div>

                                <!-- Price -->
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <n-input-number v-model:value="form.price" id="price" placeholder="Enter price" :min="0" :step="0.01" class="mt-1 w-full">
                                      <template #prefix>$</template>
                                    </n-input-number>
                                    <div v-if="form.errors.price" class="text-red-500 text-sm mt-1">{{ form.errors.price }}</div>
                                </div>

                                <!-- Discount Percent -->
                                <div>
                                    <label for="discount_percent" class="block text-sm font-medium text-gray-700">Discount Percent</label>
                                    <n-input-number v-model:value="form.discount_percent" id="discount_percent" placeholder="Enter discount %" :min="0" :max="100" class="mt-1 w-full">
                                      <template #suffix>%</template>
                                    </n-input-number>
                                    <div v-if="form.errors.discount_percent" class="text-red-500 text-sm mt-1">{{ form.errors.discount_percent }}</div>
                                </div>

                                <!-- Discount Start Date -->
                                <div>
                                    <label for="discount_datetime_start" class="block text-sm font-medium text-gray-700">Discount Start Date</label>
                                    <n-date-picker v-model:formatted-value="form.discount_datetime_start" type="datetime" format="yyyy-MM-dd HH:mm:ss" value-format="yyyy-MM-dd HH:mm:ss" clearable class="mt-1 w-full"/>
                                    <div v-if="form.errors.discount_datetime_start" class="text-red-500 text-sm mt-1">{{ form.errors.discount_datetime_start }}</div>
                                </div>

                                <!-- Discount End Date -->
                                <div>
                                    <label for="discount_datetime_end" class="block text-sm font-medium text-gray-700">Discount End Date</label>
                                    <n-date-picker v-model:formatted-value="form.discount_datetime_end" type="datetime" format="yyyy-MM-dd HH:mm:ss" value-format="yyyy-MM-dd HH:mm:ss" clearable class="mt-1 w-full"/>
                                    <div v-if="form.errors.discount_datetime_end" class="text-red-500 text-sm mt-1">{{ form.errors.discount_datetime_end }}</div>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="mt-6">
                                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                                <n-input v-model:value="form.body" id="body" type="textarea" placeholder="Enter room details" :autosize="{ minRows: 3 }" class="mt-1"/>
                                <div v-if="form.errors.body" class="text-red-500 text-sm mt-1">{{ form.errors.body }}</div>
                            </div>

                            <!-- Body CN -->
                            <div class="mt-6">
                                <label for="body_cn" class="block text-sm font-medium text-gray-700">Body (Chinese)</label>
                                <n-input v-model:value="form.body_cn" id="body_cn" type="textarea" placeholder="输入房间详情" :autosize="{ minRows: 3 }" class="mt-1"/>
                                <div v-if="form.errors.body_cn" class="text-red-500 text-sm mt-1">{{ form.errors.body_cn }}</div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <n-button class="bg-success" type="primary" attr-type="submit" :loading="form.processing">
                                    Create Room
                                </n-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { NInput, NInputNumber, NButton, NSelect, NDatePicker } from 'naive-ui';
import { computed } from 'vue';

const props = defineProps({
    hotels: Array,
    errors: Object,
});

const form = useForm({
    name: '',
    name_cn: '',
    body: '',
    body_cn: '',
    room_quan: 1,
    hotel_id: null,
    price: null,
    discount_percent: 0,
    discount_datetime_start: null,
    discount_datetime_end: null,
});

const hotelOptions = computed(() => props.hotels);

const submit = () => {
    form.post(route('admin.rooms.store'), {
        onError: (errors) => {
            // Handle server-side validation errors
            console.error('Server errors:', errors);
        },
    });
};
</script>

<script>
export default { layout: AdminLayout }
</script> 