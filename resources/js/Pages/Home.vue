<script setup>
import {onMounted, ref} from "vue";
import initializeAutocomplete from "@/hooks/googleAutocomplete.js";
import FAQ from "./Partials/FAQ.vue";
import Errors from "../Components/Errors.vue";
import {useRouter} from "vue-router";
const router = useRouter();
import { useStore } from 'vuex';
const store = useStore();

const form = ref({
        address_from: '',
        address_to: '',
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

    store.dispatch('updateFormData', {});
    store.dispatch('updateCalculateFormErrors', {});

});

const bus_and_plane = new URL('@/img/bus_and_plane.svg', import.meta.url).href;
const dog_and_cat = new URL('@/img/dog_and_cat.svg', import.meta.url).href;
const timing = new URL('@/img/timing.svg', import.meta.url).href;
const many_points = new URL('@/img/many_points.svg', import.meta.url).href;

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
    <div class="container c-main-container">
        <div class="row">
            <div class="col-md-5 col-lg-4 sidebar d-flex flex-column">
                <div class="sidebar-new">
                    <h2 class="mb-4 sidebar-header">{{$t('GET INSTANT PRICE CALCULATION')}}</h2>
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
                                           placeholder="Select date">
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
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <Errors :errors="calculateFormErrors.adults"/>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <label for="children" class="form-label">{{$t('Children')}}</label>
                                    <select v-model="form.children" name="children" class="form-select" id="children">
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                    <Errors :errors="calculateFormErrors.children"/>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="bags" class="form-label">{{$t('Bags/Suitcases')}}</label>
                            <select v-model="form.suitcases" class="form-select" id="bags">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                            <Errors :errors="calculateFormErrors.suitcases"/>
                        </div>

                        <div class="mb-2 mt-4 form-check">
                            <input v-model="form.addRoadBack" type="checkbox" class="form-check-input" id="addRoadBack">
                            <label class="form-check-label" for="addRoadBack">{{$t('Add Return')}}</label>
                            <Errors :errors="calculateFormErrors.addRoadBack"/>
                        </div>

                        <button class="btn btn-success w-100">{{$t('CALCULATE')}}</button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="container c-secondary-container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="main-attractive-points">
                    <h1 class="main-attractions-header">
                        {{$t('Comfy Mover will transfer You from any place in Europe to Spain')}} 🇪🇸 {{$t('or Portugal')}} 🇵🇹 {{$t('and vice versa')}}.
                    </h1>
                    <ul>
                        <li>
                            <img class="bus-and-plane" :src="bus_and_plane" :alt="$t('Hate travelling by bus? Afraid of flights?')">
                            <span>{{$t('Hate travelling by bus? Afraid of flights?')}}</span>
                        </li>
                        <li>
                            <img class="dog-and-cat" :src="dog_and_cat" :alt="$t('Want to travel with your beloved pets?')">
                            <span>{{$t('Want to travel with your beloved pets?')}}</span>
                        </li>
                        <li>
                            <img class="timing" :src="timing" :alt="$t('Need to travel urgently?')">
                            <span>{{$t('Need to travel urgently?')}}</span>
                        </li>
                        <li>
                            <img class="many-points" :src="many_points" :alt="$t('Want to order a special route with several destinations?')">
                            <span>{{$t('Want to order a special route with several destinations?')}}</span>
                        </li>
                    </ul>
                    <h2>{{$t('We have all what you need to make a comfy move from point A to point B')}}</h2>
                </div>

            </div>
        </div>

        <FAQ/>
    </div>

</template>
