<script setup>

import {useStore} from "vuex";
import {computed, onMounted} from "vue";
import {useRoute} from "vue-router";
import MainContainer from "../Layouts/MainContainer.vue";

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
    <MainContainer class="bg-white">
        <div class="col d-flex flex-column bg-white mt-2">
            <div v-if="order">
                <h2>{{ $t('Congratulations') }}, <strong>{{ order.client.first_name }} {{
                        order.client.last_name
                    }}</strong>!</h2>
                <p>{{ $t('You have a new order, total is', {order_number: order.id}) }} <strong>{{
                        order.total_price
                    }} €</strong></p>
                <p><strong>{{ $t('From') }}:</strong> {{ order.address_from }}</p>
                <p><strong>{{ $t('To') }}:</strong> {{ order.address_to }}</p>
                <p><strong>{{ $t('Departure Date') }}:</strong> {{ order.meeting_date }}</p>
                <p><strong>{{ $t('Departure Time') }}:</strong> {{ order.meeting_time }}</p>
                <p><strong>{{ $t('Adults') }}:</strong> {{ order.adults }}</p>
                <p><strong>{{ $t('Bags/Suitcases') }}:</strong> {{ order.suitcases }}</p>

                <div class="alert alert-info" role="alert">
                    {{
                        $t('Our manager will contact you within 2 hours referencing your order', {order_number: order.id})
                    }}
                </div>

            </div>

            <div v-else>
                {{ $t('Order not found') }}
            </div>

        </div>
    </MainContainer>


</template>

<style scoped>

</style>
