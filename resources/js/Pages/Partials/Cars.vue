<script setup>
import CancellationText from "../../Components/CancellationText.vue";
import VatText from "../../Components/VatText.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {ref} from "vue";
import ClientForm from "./ClientForm.vue";
import storagePath from "@/hooks/storagePath.js";

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
const selectedCar = ref(0);
const _people_ = storagePath('people.svg');
const _suitcases_ = storagePath('suitcase.svg');

function selectCar(id){
    selectedCar.value = id;
    showClientForm.value = true;
}

</script>

<template>

    <div :key="car.id" v-for="car in props.cars" class="row bg-white text-black mt-4 div-rounded car-row">
        <div class="col-lg-3 col-4 borderess">
            <img class="w-100" :src="car.image" :alt="car.name">
            <span class="car-name-title">{{ car.name }}</span>
        </div>

        <div class="col-lg-6 col-8 borderess">

            <span class="titolomezzo">{{$t('Standart')}}</span>

            <div>
                <span class="whatsincluded">

                    <img :src="_people_" alt="{{$t('Passengers')}}">
                    {{$t('Up to')}} <span
                    class="theMaxPax">4</span> {{$t('Passengers')}}</span><br>
                <span class="whatsincluded">
                    <img :src="_suitcases_" alt="{{$t('medium suitcases')}}">
                    &nbsp;<span class="theMaxLug">5</span> {{$t('medium suitcases')}}
                </span>
            </div>

        </div>

        <div class="col-lg-3 prezzocol">

            <small style="font-size:12px" class="totaleORnot">{{$t('Total one-way price')}}</small>

            <div class="prezzo-a-totale">
                <span style="font-size: 24px; margin-right: -5px; display: inline-block;">€</span> {{ total }}
            </div>

            <div class="mt-2">
<!--                <cancellation-text/>-->
                <vat-text/>
            </div>

            <div class="mt-2">
                <PrimaryButton :id="car.id" :class="{'selected-primary-btn':car.id === selectedCar}" @click="selectCar(car.id)">{{ $t('Select') }}</PrimaryButton>
            </div>

        </div>

    </div>


    <ClientForm :distance="distance" :car_id="selectedCar"

                :km_to_location_1="km_to_location_1" :km_to_location_2="distance" :km_to_location_3="km_to_location_3"

                :duration="duration" :data="data" :total="total"  v-if="showClientForm"></ClientForm>

</template>

<style scoped>

</style>
