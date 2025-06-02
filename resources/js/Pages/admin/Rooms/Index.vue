<template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold">Rooms</h1>
                            <Link :href="route('admin.rooms.create')" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Create Room
                            </Link>
                        </div>

                        <!-- Filter Section -->
                        <div class="mb-4">
                            <n-form-item label="Filter by Hotel" :show-feedback="false">
                                <n-select
                                    v-model:value="selectedHotelId"
                                    placeholder="Select a Hotel"
                                    :options="hotelOptions"
                                    label-field="name"
                                    value-field="id"
                                    clearable
                                    filterable
                                    @update:value="applyFilters"
                                    style="width: 250px;"
                                />
                            </n-form-item>
                        </div>

                        <n-data-table
                            :columns="columns"
                            :data="rooms.data"
                            :pagination="pagination"
                            :loading="loading"
                            @update:sorter="handleSort"
                            :remote="true"
                            :single-column="true" 
                        />
                    </div>
                </div>
            </div>
        </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { NDataTable, NSelect, NFormItem, NButton } from 'naive-ui';
import { ref, h, computed, watch } from 'vue';

const props = defineProps({
    rooms: Object,
    hotels: Array,
});

const page = usePage();
const loading = ref(false);

// Helper function to parse query params from page.url
const getUrlQueryParams = () => {
    const params = {};
    // page.props.url should contain the full URL with query string
    const urlString = page.props.url || '';
    const queryString = urlString.split('?')[1];
    if (queryString) {
        queryString.split('&').forEach(param => {
            const [key, value] = param.split('=');
            params[decodeURIComponent(key)] = decodeURIComponent(value || '');
        });
    }
    return params;
};

const initialQueryParams = getUrlQueryParams();

// Initialize filter and sort states from URL query parameters
const selectedHotelId = ref(parseInt(initialQueryParams?.hotel_id) || null);
const currentSortKey = ref(initialQueryParams?.sort || 'id'); // Default sort key
const currentSortOrder = ref(initialQueryParams?.direction || 'desc'); // Default sort order

const hotelOptions = computed(() => props.hotels);

const columns = ref([
    { title: 'ID', key: 'id', sorter: true, sortOrder: currentSortKey.value === 'id' ? (currentSortOrder.value === 'asc' ? 'ascend' : 'descend') : false },
    { title: 'Name', key: 'name', sorter: true, sortOrder: currentSortKey.value === 'name' ? (currentSortOrder.value === 'asc' ? 'ascend' : 'descend') : false },
    {
        title: 'Hotel',
        key: 'hotel', // This is the sort key for the backend
        sorter: true,
        render: (row) => row.hotel?.name || 'N/A',
        sortOrder: currentSortKey.value === 'hotel' ? (currentSortOrder.value === 'asc' ? 'ascend' : 'descend') : false
    },
    { title: 'Quantity', key: 'room_quan', sorter: true, sortOrder: currentSortKey.value === 'room_quan' ? (currentSortOrder.value === 'asc' ? 'ascend' : 'descend') : false },
    { title: 'Price (€)', key: 'price', sorter: true, render: (row) => row.price != null ? parseFloat(row.price).toFixed(2) : 'N/A', sortOrder: currentSortKey.value === 'price' ? (currentSortOrder.value === 'asc' ? 'ascend' : 'descend') : false },
    { title: 'Discount %', key: 'discount_percent', sorter: true, render: (row) => row.discount_percent != null ? `${row.discount_percent}%` : 'N/A', sortOrder: currentSortKey.value === 'discount_percent' ? (currentSortOrder.value === 'asc' ? 'ascend' : 'descend') : false },
    {
        title: 'Actions',
        key: 'actions',
        render(row) {
            return h('div', { class: 'flex space-x-2' }, [
                h(Link,
                  { href: route('admin.rooms.edit', row.id), class: 'px-2 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600' },
                  { default: () => 'Edit' }
                ),
                h(Link,
                    {
                    href: route('admin.costs.create', { costable_type: 'App\\Models\\Room', costable_id: row.id }),
                    class: 'no-underline'
                    },
                    {default: () =>
                        h(
                        NButton,
                        {
                            type: 'primary',
                            size: 'small',
                            class: 'bg-info'
                        },
                        { default: () => 'add cost' }
                        )
                    }),
                h('button',
                  { onClick: () => deleteRoom(row.id), class: 'px-2 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600' },
                  { default: () => 'Delete' }
                )
            ]);
        }
    }
]);

// Watch for changes in URL query to update sort states and column sortOrder
watch(() => page.props.url, (newUrl) => {
    const newQueryParams = getUrlQueryParams(); // Use the helper here
    currentSortKey.value = newQueryParams?.sort || 'id';
    currentSortOrder.value = newQueryParams?.direction || 'desc';
    selectedHotelId.value = parseInt(newQueryParams?.hotel_id) || null; // Keep dropdown in sync

    columns.value = columns.value.map(col => ({
        ...col,
        sortOrder: col.key === currentSortKey.value ? (currentSortOrder.value === 'asc' ? 'ascend' : (currentSortOrder.value === 'desc' ? 'descend' : false)) : false
    }));
}, { immediate: true });


const fetchData = (options = {}) => {
    const queryParams = {
        page: options.page !== undefined ? options.page : (props.rooms.current_page || 1),
        per_page: options.per_page !== undefined ? options.per_page : (props.rooms.per_page || 10),
        sort: options.sort !== undefined ? options.sort : currentSortKey.value,
        direction: options.direction !== undefined ? options.direction : currentSortOrder.value,
        hotel_id: selectedHotelId.value || undefined,
    };

    Object.keys(queryParams).forEach(key => {
        if (queryParams[key] === undefined || queryParams[key] === null || queryParams[key] === '') {
            delete queryParams[key];
        }
    });
    
    // If sort is not provided, but direction is, remove direction
    if (!queryParams.sort && queryParams.direction) {
        delete queryParams.direction;
    }


    Inertia.get(route('admin.rooms.index'), queryParams, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
    });
};

const pagination = computed(() => ({
    page: props.rooms.current_page,
    pageSize: props.rooms.per_page,
    itemCount: props.rooms.total,
    showSizePicker: true,
    pageSizes: [10, 20, 50, 100],
    onChange: (page) => {
        fetchData({ page });
    },
    onUpdatePageSize: (pageSize) => {
        fetchData({ page: 1, per_page: pageSize });
    }
}));

const handleSort = (sorter) => {
    // Naive UI sorter object: { columnKey: string, order: 'ascend' | 'descend' | false }
    const sortKey = sorter.columnKey;
    let sortOrder = '';

    if (sorter.order === 'ascend') {
        sortOrder = 'asc';
    } else if (sorter.order === 'descend') {
        sortOrder = 'desc';
    }
    // If sorter.order is false, sortOrder remains '', backend will use default or no sort for that key.
    // If we want to remove sort when order is false:
    // fetchData({ sort: sortOrder ? sortKey : undefined, direction: sortOrder || undefined, page: 1 });

    fetchData({ sort: sortKey, direction: sortOrder, page: 1 });
};

const applyFilters = () => {
    fetchData({ page: 1 }); // Reset to page 1 on filter change
};

const deleteRoom = (id) => {
    if (confirm('Are you sure you want to delete this room?')) {
        Inertia.delete(route('admin.rooms.destroy', id), {
            preserveScroll: true,
            onSuccess: () => { /* Optionally show a success message */ },
            onError: () => { /* Optionally show an error message */ },
            onStart: () => loading.value = true,
            onFinish: () => {
                loading.value = false;
                // Data should reload automatically due to redirect. If not, call fetchData().
            }
        });
    }
};

// Watch for external changes to URL's hotel_id to keep dropdown in sync
// This is now handled by the page.props.url watcher above.
// watch(() => page.props.ziggy.query?.hotel_id, (newHotelId) => {
//     selectedHotelId.value = parseInt(newHotelId) || null;
// });

</script> 

<script>
export default { layout: AdminLayout }
</script> 