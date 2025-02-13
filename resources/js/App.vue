<script setup>
import Header from './Layouts/Header.vue';
import Footer from './Layouts/Footer.vue';
</script>

<template>


        <main>
            <Header/>
            <router-view></router-view>
        </main>

    <Footer/>

</template>
