<script setup>
import Header from './Layouts/Header.vue';
import Footer from './Layouts/Footer.vue';
const router = useRouter();
import {useRouter} from "vue-router";
import {computed} from "vue";
import storagePath from "@/hooks/storagePath.js";
const isHome = computed(()=>{
    return router.currentRoute.value.name === 'home';
})
const videoSources = [
    storagePath('/video/vid1.mp4'),
    storagePath('/video/vid2.mp4'),
];
const selectedVideo = videoSources[Math.floor(Math.random() * videoSources.length)];
</script>

<template>

    <div class="home-vid-back-container" v-if="isHome">
        <div class="home-vid-back">
            <video autoplay muted loop>
                <source :src="selectedVideo" type="video/mp4"/>
            </video>
        </div>
    </div>

    <main>
        <Header/>
        <router-view></router-view>
    </main>

    <Footer/>

</template>
