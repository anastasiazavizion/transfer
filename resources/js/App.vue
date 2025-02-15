<script setup>
import Header from './Layouts/Header.vue';
import Footer from './Layouts/Footer.vue';

const router = useRouter();
import {useRouter} from "vue-router";
import {computed} from "vue";

const isHome = computed(()=>{
    return router.currentRoute.value.name === 'home';
})

const videoSources = [
    new URL('@/img/vid1.mp4', import.meta.url).href,
    new URL('@/img/vid2.mp4', import.meta.url).href,
    //new URL('@/img/vid3.mp4', import.meta.url).href
];

// Randomly pick one video on page refresh
const _selectedVideo = videoSources[Math.floor(Math.random() * videoSources.length)];

</script>

<template>

    <div class="home-vid-back-container" v-if="isHome">
        <div class="home-vid-back">
            <video autoplay muted loop>
                <source :src="_selectedVideo" type="video/mp4" />
            </video>
        </div>
    </div>

    <main>
        <Header/>
        <router-view></router-view>
    </main>

    <Footer/>

</template>
