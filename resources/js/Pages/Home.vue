<script setup>
import {onMounted, ref} from "vue";

import initializeAutocomplete from "@/hooks/googleAutocomplete.js";
import FAQ from "./Partials/FAQ.vue";

const form = ref({
    address_from: null,
    address_to: null,
    adults: 0,
    children: 0,
    suitcases:0
});

onMounted(() => {
    initializeAutocomplete("address_from", form);
    initializeAutocomplete("address_to", form);
});

</script>

<template>

    <div class="container c-main-container">
        <div class="row">
            <div class="col-md-5 col-lg-4 sidebar d-flex flex-column sidebar-new">
                <h4 class="mb-4">Get Instant Price Calculation</h4>
                <form>
                    <div class="mb-3">
                        <label for="location1" class="form-label">From:</label>
                        <input v-model="form.address_from" placeholder="" type="text" name="address_from"
                               id="address_from" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="location2" class="form-label">To:</label>
                        <input v-model="form.address_to" placeholder="" type="text" name="address_to" id="address_to"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <label for="departure_date" class="form-label">Departure Date</label>
                                <input type="text" class="form-control datepicker" id="departure_date"
                                       placeholder="Select date">
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="departure_time" class="form-label">Departure Time</label>
                                <input type="time" id="departure_time" name="departure_time" class="form-control">
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
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="children" class="form-label">Children</label>
                                <select v-model="form.children" name="children" class="form-select" id="children">
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
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
                    </div>

                    <div class="mb-3 mt-4 form-check">
                        <input type="checkbox" class="form-check-input" id="addRoadBack">
                        <label class="form-check-label" for="addRoadBack">Add Road Back</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Calculate</button>
                </form>
            </div>

            <!-- (FAQ Section) -->
            <FAQ/>
        </div>
    </div>

</template>

<style scoped>

</style>
