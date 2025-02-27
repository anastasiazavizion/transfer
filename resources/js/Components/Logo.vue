<script setup>
import storagePath from "@/hooks/storagePath.js";
const logo = storagePath('logo.svg');
</script>

<template>
    <router-link class="navbar-brand" to="/">
        <img class="main-logo" :src="logo" alt="comfy mover">
    </router-link>
</template>

<style scoped>

</style>
