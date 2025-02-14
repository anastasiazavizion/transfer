<script setup>
const logo = new URL('@/img/logo.svg', import.meta.url).href;
</script>

<template>


    <footer class="bg-dark text-light py-4 custom-footer mt-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4">
                    <h5>
                        <router-link class="navbar-brand" to="/">
                            <img class="main-logo" :src="logo" alt="comfy mover">
                        </router-link>
                    </h5>
                </div>
                <div class="col-md-4"><a href="#" class="text-light">Privacy Policy</a></div>
                <div class="col-md-4"><a href="#" class="text-light">Terms & Conditions</a></div>
            </div>
        </div>
    </footer>

</template>

<style scoped>

</style>
