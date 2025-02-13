<script setup>

import {computed, onMounted} from "vue";
import {useStore} from "vuex";

const store = useStore();

const data = computed(()=>{
    return store.getters['getFormData']
})

onMounted(async ()=>{
    if(data.value.length > 0){
        console.log(data.value);
    }
})

</script>

<template>
<div>Destination</div>
</template>

<style scoped>

</style>
