<script setup>
import VatText from "../../Components/Destination/VatText.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {ref} from "vue";
import ClientForm from "./ClientForm.vue";

const props = defineProps({
    cars: Array,
    data: Object,
    total: Number,
    distance: String,
    km_to_location_1: String,
    km_to_location_2: String,
    km_to_location_3: String,
    duration: String
})

const showClientForm = ref(false);
const selectedCar = ref(0);
const people = '/images/people.svg';
const suitcases = '/images/suitcase.svg';

function selectCar(id) {
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
            <span class="titolomezzo">{{ car.type }}</span>
            <div>
                <span class="whatsincluded">
                    <img :src="people" alt="{{$t('Passengers')}}">
                    {{ $t('Up to') }} <span
                    class="theMaxPax">{{ car.max_people_amount }}</span> {{ $t('Passengers') }}</span><br>
                <span class="whatsincluded">
                    <img :src="suitcases" alt="{{$t('medium suitcases')}}">
                    &nbsp;<span class="theMaxLug">{{ car.max_suitcase_amount }}</span> {{ $t('medium suitcases') }}
                </span>
            </div>

        </div>

        <div class="col-lg-3 prezzocol">

            <small style="font-size:12px" class="totaleORnot">{{ $t('Total one-way price') }}</small>

            <div class="prezzo-a-totale">
                <span style="font-size: 24px; margin-right: -5px; display: inline-block;">€</span> {{ total }}
            </div>

            <div class="mt-2">
                <vat-text/>
            </div>

            <div class="mt-2">
                <PrimaryButton :id="car.id" :class="{'selected-primary-btn':car.id === selectedCar}"
                               @click="selectCar(car.id)">{{ $t('Select') }}
                </PrimaryButton>
            </div>

        </div>

    </div>


    <ClientForm :distance="distance" :car_id="selectedCar"

                :km_to_location_1="km_to_location_1" :km_to_location_2="distance" :km_to_location_3="km_to_location_3"

                :duration="duration" :data="data" :total="total" v-if="showClientForm"></ClientForm>

</template>

<style scoped>

</style>
