<script setup>
defineProps({
    errors:Array
})
</script>
<template>
    <div class="alert alert-danger mt-4" role="alert" v-for="error in errors">
        {{error}}
    </div>
</template>
