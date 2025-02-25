<script setup>
import {computed} from "vue";

const props = defineProps({
    date:String
})

const formattedDate = computed(()=>{
    const date = new Date(props.date);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-GB', options);
})
</script>

<template>
    {{formattedDate}}
</template>

<style scoped>

</style>
