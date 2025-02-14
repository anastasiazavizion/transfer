<script setup>
const links = [
    {url:"/",text:"Home"},
    {url:"/contact",text:"Contact"},
]
const logo = new URL('@/img/logo.svg', import.meta.url).href;

</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <router-link class="navbar-brand" to="/">
                <img class="main-logo" :src="logo" alt="comfy mover">
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li v-for="link in links" class="nav-item">
                        <router-link class="nav-link" :to="link.url">{{link.text}}</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
