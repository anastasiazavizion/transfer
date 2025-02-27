<script setup>
import Logo from "../Components/Logo.vue";
</script>

<template>
    <footer class="bg-dark text-light py-4 custom-footer mt-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4">
                    <h5>
                       <Logo/>
                    </h5>
                </div>
                <div class="col-md-4"><a href="#" class="text-light">{{$t('Privacy Policy')}}</a></div>
                <div class="col-md-4"><a href="#" class="text-light">{{$t('Terms & Conditions')}}</a></div>
            </div>
        </div>
    </footer>

</template>

<style scoped>

</style>
