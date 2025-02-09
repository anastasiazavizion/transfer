<script setup>
import {useStore} from "vuex";
const store = useStore();
import {useRouter} from "vue-router";
import {computed, onMounted, ref} from "vue";
const router = useRouter();
import Header from './Layouts/Header.vue';
import Footer from './Layouts/Footer.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <div class="container default-component">
            <main>
                <Header/>
                <router-view></router-view>
            </main>
        </div>
        <Footer/>
    </div>
</template>
