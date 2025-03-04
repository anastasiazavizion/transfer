<script setup>
const options = Array.from({ length: Number(import.meta.env.VITE_ADULTS_AMOUNT) }, (_, i) => i);
</script>

<template>
        <option v-for="i in options" :key="i">{{ i }}</option>
</template>
