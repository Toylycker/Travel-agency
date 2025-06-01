<template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between mb-6">
                            <h1 class="text-2xl font-bold">Rooms</h1>
                            <Link :href="route('admin.rooms.create')" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Create Room
                            </Link>
                        </div>

                        <n-data-table
                            :columns="columns"
                            :data="rooms.data"
                            :pagination="pagination"
                            :loading="loading"
                            @update:sorter="handleSort"
                        />
                    </div>
                </div>
            </div>
        </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { NDataTable } from 'naive-ui';
import { ref, h, computed } from 'vue';

const props = defineProps({
    rooms: Object,
});

const loading = ref(false);

const columns = ref([
    { title: 'ID', key: 'id', sorter: true },
    { title: 'Name', key: 'name', sorter: true },
    { title: 'Hotel', key: 'hotel', sorter: 'default', render: (row) => row.hotel?.name || 'N/A' },
    { title: 'Quantity', key: 'room_quan', sorter: true },
    { title: 'Price', key: 'price', sorter: true },
    { title: 'Discount %', key: 'discount_percent', sorter: true },
    {
        title: 'Actions',
        key: 'actions',
        render(row) {
            return h('div', { class: 'flex space-x-2' }, [
                h(Link,
                  { href: route('admin.rooms.edit', row.id), class: 'px-2 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600' },
                  { default: () => 'Edit' }
                ),
                h('button',
                  { onClick: () => deleteRoom(row.id), class: 'px-2 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600' },
                  { default: () => 'Delete' }
                )
            ]);
        }
    }
]);

const pagination = computed(() => ({
    page: props.rooms.current_page,
    pageSize: props.rooms.per_page,
    itemCount: props.rooms.total,
    onChange: (page) => {
        Inertia.get(props.rooms.path, { page }, { preserveState: true, onStart: () => loading.value = true, onFinish: () => loading.value = false });
    },
    onUpdatePageSize: (pageSize) => {
        Inertia.get(props.rooms.path, { per_page: pageSize }, { preserveState: true, onStart: () => loading.value = true, onFinish: () => loading.value = false });
    }
}));

const handleSort = (sorter) => {
    let sortKey = '';
    let sortOrder = '';

    if (sorter) {
        sortKey = sorter.columnKey;
        sortOrder = sorter.order === 'ascend' ? 'asc' : (sorter.order === 'descend' ? 'desc' : '');
    }

    Inertia.get(props.rooms.path, {
        sort: sortKey,
        direction: sortOrder,
        page: props.rooms.current_page, // maintain current page
        per_page: props.rooms.per_page // maintain current page size
    }, {
        preserveState: true,
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false
    });
};

const deleteRoom = (id) => {
    if (confirm('Are you sure you want to delete this room?')) {
        Inertia.delete(route('admin.rooms.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                // Optionally show a success message
            },
            onError: () => {
                // Optionally show an error message
            },
            onStart: () => loading.value = true,
            onFinish: () => loading.value = false
        });
    }
};

</script>

<script>
export default { layout: AdminLayout }
</script> 