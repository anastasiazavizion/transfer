<script setup>
import CancellationText from "../../Components/CancellationText.vue";
import VatText from "../../Components/VatText.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {ref} from "vue";
import ClientForm from "./ClientForm.vue";

const props = defineProps({
    cars: Array,
    data:Object,
    total: Number,
    distance:String,
    km_to_location_1:String,
    km_to_location_2:String,
    km_to_location_3:String,
    duration:String
})

const showClientForm = ref(false);

function selectCar(id){
    showClientForm.value = true;
}

</script>

<template>

    <div :key="car.id" v-for="car in props.cars" class="row bg-white text-black mt-4 div-rounded car-row">
        <div class="col-lg-3 col-4 borderess">
            <img class="w-100" :src="car.image" :alt="car.name">
            <span class="tipomezzo">{{ car.name }}</span>

        </div>

        <div class="col-lg-6 col-8 borderess">

            <span class="titolomezzo">Standart</span>

            <div>
                <span class="primodettaglio"><svg class="svg-default" style="color: #f9b442;" aria-hidden="true"
                                                  focusable="false" data-prefix="fas" data-icon="user-group" role="img"
                                                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                                  data-fa-i2svg=""><path fill="currentColor"
                                                                         d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM609.3 512l-137.8 0c5.4-9.4 8.6-20.3 8.6-32l0-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2l61.4 0C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"></path></svg> Up to <span
                    class="theMaxPax">4</span> Passengers</span> <span class="primodettaglio"><svg class="svg-default" style="color: #f9b442;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="suitcase" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M176 56l0 40 160 0 0-40c0-4.4-3.6-8-8-8L184 48c-4.4 0-8 3.6-8 8zM128 96l0-40c0-30.9 25.1-56 56-56L328 0c30.9 0 56 25.1 56 56l0 40 0 32 0 352-256 0 0-352 0-32zM64 96l32 0 0 384-32 0c-35.3 0-64-28.7-64-64L0 160c0-35.3 28.7-64 64-64zM448 480l-32 0 0-384 32 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64z"></path></svg> <span class="theMaxLug">6</span> medium suitcases</span>
            </div>

        </div>

        <div class="col-lg-3 prezzocol">

            <small style="font-size:12px" class="totaleORnot">Total one-way price</small>

            <div class="prezzo-a-totale">
                <span style="font-size: 24px; margin-right: -5px; display: inline-block;">€</span> {{ total }}
            </div>

            <div class="mt-2">
                <cancellation-text/>
                <vat-text/>
            </div>

            <div class="mt-2">
                <PrimaryButton @click="selectCar(car.id)">{{ $t('Select') }}</PrimaryButton>
            </div>

        </div>

    </div>


    <ClientForm :distance="distance"

                :km_to_location_1="km_to_location_1" :km_to_location_2="distance" :km_to_location_3="km_to_location_3"

                :duration="duration" :data="data" :total="total"  v-if="showClientForm"></ClientForm>

</template>

<style scoped>

</style>
