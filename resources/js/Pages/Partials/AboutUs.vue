<script setup>
import HowItWorks from "./HowItWorks.vue";
import FAQ from "./FAQ.vue";
</script>

<template>
    <div class="container c-secondary-container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="main-attractive-points">
                    <h2 class="wcu-header">
                        {{$t('Why Choose Us')}}
                    </h2>
                    <FAQ/>
                    <br>
                </div>
                <div class="how-it-works">
                    <h2 class="hiw-header">
                        {{$t('How it Works')}}
                    </h2>
                    <HowItWorks/>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
