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

    <main class="container mx-auto my-8 flex">
        <!-- Sidebar -->
        <aside class="w-1/3 p-6 bg-purple-800 rounded-lg">
            <form>
            <label class="block mb-2">Location 1</label>
            <input v-model="form.address_from" placeholder="" type="text" name="address_from" id="address_from" class="w-full p-2 mb-4 text-black rounded" >


            <label class="block mb-2">Location 2</label>
            <input v-model="form.address_to" placeholder="" type="text" name="address_to" id="address_to" class="w-full p-2 mb-4 text-black rounded">

            <label class="block mb-2">Date 1</label>
            <input type="date" class="w-full p-2 mb-4 text-black rounded">

            <label class="block mb-2">Date 2</label>
            <input type="date" class="w-full p-2 mb-4 text-black rounded">

            <label class="flex items-center mb-4">
                <input type="checkbox" class="mr-2">
                Add Return
            </label>

            <button class="w-full p-3 text-black font-bold bg-[#ffcc00] rounded">Submit</button>
            </form>
        </aside>

        <!-- Right Content -->
        <section class="w-2/3 p-6">
            <h1 class="text-3xl font-bold mb-4">Welcome to Our Service</h1>
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.</p>
            <p class="mb-4">Donec sollicitudin molestie malesuada. Nulla quis lorem ut libero malesuada feugiat.</p>
        </section>
    </main>

</template>

<style scoped>

</style>
