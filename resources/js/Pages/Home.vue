<script setup>
import {onMounted, ref} from "vue";

import initializeAutocomplete from "@/hooks/googleAutocomplete.js";

const form = ref({
  address_from:null,
  address_to:null
});

onMounted(()=>{
  initializeAutocomplete("address_from", form);
  initializeAutocomplete("address_to", form);
});

</script>

<template>
<div>Home page</div>
    <form>
    <div>
      <label for="address">From</label>
      <input v-model="form.address_from" placeholder="" type="text" name="address_from" id="address_from" class="ml-4 form-input">
    </div>

    <div>
      <label for="address">To</label>
      <input v-model="form.address_to" placeholder="" type="text" name="address_to" id="address_to" class="ml-4 form-input">
    </div>
  </form>

</template>

<style scoped>

</style>
