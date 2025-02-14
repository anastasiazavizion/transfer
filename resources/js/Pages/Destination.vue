<script setup>

import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";

const store = useStore();

const data = computed(() => {
  return store.getters['getFormData']
})

const mapSrc = ref(""); // Ref to store the map image URL

onMounted(async () => {
  if (Object.keys(data.value).length > 0) {
    console.log(data.value);
    mapSrc.value = "https://maps.googleapis.com/maps/api/staticmap?size=640x300&markers=place:" + data.value.address_from + "&markers=place:" + data.value.address_to + "&path=color:0x0000ff|weight:5|" + data.value.address_from + "|" + data.value.address_to + "&key=" + import.meta.env.VITE_GOOGLE_API_KEY;
  }
})

</script>

<template>
  <div class="row">
    <div class="col-md-12 col-lg-12 d-flex justify-content-center">
      <img class="mx-auto" :src="mapSrc" alt="Map Image" v-if="mapSrc"/>
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
