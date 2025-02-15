<script setup>
import Header from './Layouts/Header.vue';
import Footer from './Layouts/Footer.vue';

const router = useRouter();
import {useRouter} from "vue-router";
import {computed} from "vue";

const isHome = computed(()=>{
    return router.currentRoute.value.name === 'home';
})

const vid_back = new URL('@/img/8357-208052048.mp4', import.meta.url).href;

</script>

<template>

    <div class="home-vid-back-container" v-if="isHome">
        <div class="home-vid-back">
            <video autoplay muted loop>
                <source :src="vid_back" type="video/mp4" />
            </video>
        </div>
    </div>

    <main>
        <Header/>
        <router-view></router-view>
    </main>

    <Footer/>

</template>
