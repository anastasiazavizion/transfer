<script setup>

import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";

const store = useStore();

const data = computed(() => {
  return store.getters['getFormData']
})

const mapSrc = ref("");
const distance = ref("");
const duration = ref("");

onMounted(async () => {

  if (Object.keys(data.value).length > 0) {


    const response =  await axios.get('/api/distanceDuration', {params:data.value});
    if (response.data) {

      distance.value = response.data.distance;
      duration.value = response.data.duration;

        mapSrc.value = response.data.response_url;
    }

  }
})

</script>

<template>
  <div class="row text-black">
    <div class="col-md-12 col-lg-12 d-flex justify-content-center">
      <img class="mx-auto" :src="mapSrc" alt="Map Image" v-if="mapSrc"/>
    </div>

    <div v-if="distance" class="col-md-12 col-lg-12">
      <div>Distance = {{distance}}</div>
    </div>

    <div v-if="duration" class="col-md-12 col-lg-12">
      <div>Distance = {{duration}}</div>
    </div>


  </div>
</template>

<style scoped>
img {
  max-width: 100%;
  height: auto;
  border: 1px solid #ddd;
}
</style>
