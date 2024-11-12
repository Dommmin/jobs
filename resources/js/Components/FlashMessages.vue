<template>
    <!-- Empty template --->
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const { flash } = usePage().props;

if (flash.success) {
    toast.success(flash.success, {
        position: toast.POSITION.BOTTOM_RIGHT,
        autoClose: 2000,
    });
}

if (flash.error) {
    toast.error(flash.error, {
        position: toast.POSITION.BOTTOM_RIGHT,
        autoClose: 2000,
    });
}
</script>
