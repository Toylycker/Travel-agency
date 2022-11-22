<template> 
    <h1>welcome Admin</h1>
    <h1>{{$page.props.auth==null}}</h1>

</template>


<script setup>
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default { layout: AdminLayout }
</script>
