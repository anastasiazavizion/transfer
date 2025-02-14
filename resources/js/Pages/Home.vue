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
            <div class="col-md-5 col-lg-4 sidebar d-flex flex-column sidebar-new">
                <h4 class="mb-4">Get Instant Price Calculation</h4>
                <form @submit.prevent="calculate">
                    <div class="mb-3">
                        <label for="location1" class="form-label">From:</label>
                        <input v-model="form.address_from" placeholder="" type="text" name="address_from"
                               id="address_from" class="form-control">
                        <Errors :errors="calculateFormErrors.address_from"/>
                    </div>
                    <div class="mb-3">
                        <label for="location2" class="form-label">To:</label>
                        <input v-model="form.address_to" placeholder="" type="text" name="address_to" id="address_to"
                               class="form-control">
                        <Errors :errors="calculateFormErrors.address_to"/>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <label for="meeting_date" class="form-label">Departure Date</label>
                                <input v-model="form.meeting_date" type="date" name="meeting_date" class="form-control datepicker" id="meeting_date"
                                       placeholder="Select date">
                                <Errors :errors="calculateFormErrors.meeting_date"/>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="meeting_time" class="form-label">Departure Time</label>
                                <input v-model="form.meeting_time" type="time" id="meeting_time" name="meeting_time" class="form-control">
                                <Errors :errors="calculateFormErrors.meeting_time"/>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <label for="adults" class="form-label">Adults</label>
                                <select v-model="form.adults" name="adults" class="form-select" id="adults">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                                <Errors :errors="calculateFormErrors.adults"/>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="children" class="form-label">Children</label>
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

                    <div class="mb-3">
                        <label for="bags" class="form-label">Bags/Suitcases</label>
                        <select v-model="form.suitcases" class="form-select" id="bags">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                        <Errors :errors="calculateFormErrors.suitcases"/>
                    </div>

                    <div class="mb-3 mt-4 form-check">
                        <input v-model="form.addRoadBack" type="checkbox" class="form-check-input" id="addRoadBack">
                        <label class="form-check-label" for="addRoadBack">Add Road Back</label>
                        <Errors :errors="calculateFormErrors.addRoadBack"/>
                    </div>

                    <button class="btn btn-primary w-100">Calculate</button>

                </form>
            </div>

            <!-- (FAQ Section) -->
            <FAQ/>
        </div>
    </div>

</template>
