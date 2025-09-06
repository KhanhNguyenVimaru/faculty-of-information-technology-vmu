<template>
    <div class="flex flex-col h-screen bg-gray-100">
        <ManageNavbar />
        <div class="flex-1 overflow-auto p-4">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import ManageNavbar from './ManageNavbar.vue';
</script>
