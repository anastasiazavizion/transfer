<script setup>
import { ContentLoader } from "vue-content-loader";
</script>

<template>
    <ContentLoader
        style="border-radius: 12px; position: relative;"
        :speed="4"
        primaryColor="#f9f9f9"
        :animate="false"
    viewBox="0 0 440 600"
    >
    <rect class="shimmer" x="0" y="0" rx="3" ry="3" width="440" height="600" />
    </ContentLoader>
</template>

<style scoped>
/* Create the shimmer effect */
@keyframes shimmer {
    0% {
        background-position: -200%;
    }
    100% {
        background-position: 200%;
    }
}

.shimmer {
    background: linear-gradient(90deg, #f9f9f9 25%, #ecebeb 50%, #f9f9f9 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite linear; /* Apply the shimmer animation */
}
</style>
