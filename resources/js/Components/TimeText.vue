<script setup>
import {computed} from "vue";

const props = defineProps({
    time:String
})

const formattedText = computed(()=>{
    let [hours, minutes] = props.time.split(':');
    hours = parseInt(hours);
    const period = hours >= 12 ? "PM" : "AM";
    hours = hours % 12; // Convert to 12-hour format
    if (hours === 0) {
        hours = 12;
    }
    return `${props.time} (${hours}:${minutes} ${period})`;
})
</script>

<template>
    {{formattedText}}
</template>

<style scoped>

</style>
