<script setup>

import {useStore} from "vuex";
import {computed, onMounted} from "vue";
import {useRoute} from "vue-router";

const store = useStore();
const route = useRoute()

const order = computed(() => {
    return store.getters['getOrder'];
})

onMounted(async () => {
    await store.dispatch('getOrder', route.params.orderId);
})

</script>

<template>

    <div class="container c-main-container">
        <div class="row">
            <div class="col d-flex flex-column">

                <div v-if="order">
                    <h2>{{ $t('Congratulations') }}, <strong>{{ order.client.first_name }} {{ order.client.last_name }}</strong>!</h2>
                    <p>{{ $t('You have a new order, total is', {order_number:order.id}) }} <strong>{{ order.total_price }} €</strong></p>

                    <p><strong>{{ $t('From') }}:</strong> {{ order.address_from }}</p>
                    <p><strong>{{ $t('To') }}:</strong> {{ order.address_to }}</p>
                    <p><strong>{{ $t('Departure Date') }}:</strong> {{ order.meeting_date }}</p>
                    <p><strong>{{ $t('Departure Time') }}:</strong> {{ order.meeting_time }}</p>
                    <p><strong>{{ $t('Adults') }}:</strong> {{ order.adults }}</p>
                    <p><strong>{{ $t('Bags/Suitcases') }}:</strong> {{ order.suitcases }}</p>

                </div>

                <div v-else>
                    Order not found
                </div>

            </div>
        </div>
    </div>


</template>

<style scoped>

</style>
