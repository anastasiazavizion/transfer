<script setup>

import SquareFigure from "./SquareFigure.vue";
</script>

<template>
    <div class="row mb-4">
        <div class="col-2">
            <slot/>
        </div>

        <div class="col-10">
           <slot name="second"/>
        </div>

    </div>
</template>

<style scoped>

</style>
