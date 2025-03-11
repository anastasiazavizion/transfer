<script setup>
import {computed, onMounted, ref} from "vue";
import initializeAutocomplete from "@/hooks/googleAutocomplete.js";
import Errors from "../Components/Errors.vue";
import {useRouter} from "vue-router";
const router = useRouter();
import { useStore } from 'vuex';
import SidebarHeader from "../Components/SidebarHeader.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";
import MainPhone from "../Components/MainPhone.vue";
import MainContainer from "../Layouts/MainContainer.vue";
import BagsAmount from "../Components/BagsAmount.vue";
import AdultsAmount from "../Components/AdultsAmount.vue";
import AboutUs from "./Partials/AboutUs.vue";
const store = useStore();

const form = ref({
        address_from: '',
        address_to: '',
        city_from: '',
        city_to: '',
        meeting_date: '',
        meeting_time: '',
        adults: 1,
        children: 0,
        suitcases: 0,
        addRoadBack: false,
});

onMounted(() => {
    initializeAutocomplete("address_from", form);
    initializeAutocomplete("address_to", form);
    store.dispatch('updateCalculateFormErrors', {});
});

const tomorrowDate = computed(()=>{
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1); // Set to tomorrow
    const year = tomorrow.getFullYear();
    const month = (tomorrow.getMonth() + 1).toString().padStart(2, '0');
    const day = tomorrow.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`; // Format as YYYY-MM-DD
})

const calculateFormErrors = ref([]);

async function calculate() {
    await store.dispatch('validateFormData', form.value);
    calculateFormErrors.value = await store.getters['getCalculateFormErrors'];
    if (Object.keys(calculateFormErrors.value).length === 0) {
        await store.dispatch('updateFormData', form.value);
        await router.push({name: 'destination'});
    }
}

</script>

<template>
    <div class="main-header-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 p-4 text-center main-cm-header-holder">
                    <div class="mah-parent">
                        <h1 class="main-cm-header">{{$t('Your comfy transfer from any place in Europe to Spain')}} 🇪🇸 {{$t('or Portugal')}} 🇵🇹 {{$t('and vice versa')}}.</h1>
                        <div class="mah-phones">
                            <main-phone/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <MainContainer>
        <div class="col-md-5 col-lg-4 sidebar d-flex flex-column">
            <div class="sidebar-new">
                <SidebarHeader>{{$t('GET INSTANT PRICE CALCULATION')}}</SidebarHeader>

                <form @submit.prevent="calculate">
                    <div class="mb-2">
                        <label for="location1" class="form-label">{{$t('From')}}:</label>
                        <input v-model="form.address_from" placeholder="" type="text" name="address_from"
                               id="address_from" class="form-control">
                        <Errors :errors="calculateFormErrors.address_from"/>
                    </div>
                    <div class="mb-2">
                        <label for="location2" class="form-label">{{$t('To')}}:</label>
                        <input v-model="form.address_to" placeholder="" type="text" name="address_to" id="address_to"
                               class="form-control">
                        <Errors :errors="calculateFormErrors.address_to"/>
                    </div>

                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <label for="meeting_date" class="form-label">{{$t('Departure Date')}}</label>
                                <input v-model="form.meeting_date" type="date" name="meeting_date" class="form-control datepicker" id="meeting_date"
                                       placeholder="Select date" :min="tomorrowDate">
                                <Errors :errors="calculateFormErrors.meeting_date"/>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="meeting_time" class="form-label">{{$t('Departure Time')}}</label>
                                <input v-model="form.meeting_time" type="time" id="meeting_time" name="meeting_time" class="form-control">
                                <Errors :errors="calculateFormErrors.meeting_time"/>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <label for="adults" class="form-label">{{$t('Adults')}}</label>
                                <select v-model="form.adults" name="adults" class="form-select" id="adults">
                                   <AdultsAmount/>
                                </select>
                                <Errors :errors="calculateFormErrors.adults"/>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="suitcases" class="form-label">{{$t('Bags/Suitcases')}}</label>
                                <select v-model="form.suitcases" class="form-select" id="suitcases">
                                    <BagsAmount/>
                                </select>
                                <Errors :errors="calculateFormErrors.suitcases"/>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-4 form-check">
                        <input v-model="form.addRoadBack" type="checkbox" class="form-check-input" id="addRoadBack">
                        <label class="form-check-label" for="addRoadBack">{{$t('Add Return')}}</label>
                        <Errors :errors="calculateFormErrors.addRoadBack"/>
                    </div>
                    <PrimaryButton>{{$t('CALCULATE')}}</PrimaryButton>
                </form>
            </div>
        </div>
    </MainContainer>
    <div class="cs-white">
        <div class="cs-mid-white">

            <AboutUs/>

        </div>

    </div>

</template>
