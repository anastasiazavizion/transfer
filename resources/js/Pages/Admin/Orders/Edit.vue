<script setup>
import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import MainContainer from "../../../Layouts/MainContainer.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import BagsAmount from "../../../Components/BagsAmount.vue";
import AdultsAmount from "../../../Components/AdultsAmount.vue";
import Errors from "../../../Components/Errors.vue";

const store = useStore();
const route = useRoute()
const router = useRouter();

const order = computed(() => {
    return store.getters['admin_orders/order'];
})

const statuses = computed(() => {
    return store.getters['statuses/statuses'];
})

const updatedOrder = ref({});

onMounted(async () => {
    await store.dispatch('admin_orders/getOrder', route.params.orderId);

    updatedOrder.value.id = order.value.id;
    updatedOrder.value.client_id = order.value.client.id;
    updatedOrder.value.first_name = order.value.client.first_name;
    updatedOrder.value.last_name = order.value.client.last_name;
    updatedOrder.value.phone = order.value.client.phone;
    updatedOrder.value.email = order.value.client.email;
    updatedOrder.value.address_from = order.value.address_from;
    updatedOrder.value.address_to = order.value.address_to;
    updatedOrder.value.meeting_date = order.value.meeting_date_formatted;
    updatedOrder.value.meeting_time = order.value.meeting_time;
    updatedOrder.value.adults = order.value.adults;
    updatedOrder.value.suitcases = order.value.suitcases;
    updatedOrder.value.total_price = order.value.total_price;
    updatedOrder.value.comment = order.value.comment;
    updatedOrder.value.status = order.value.status.id;

})

const updateOrderErrors = ref([]);

const updateOrder = async () => {

    await store.dispatch("admin_orders/updateOrder", updatedOrder.value);

    updateOrderErrors.value = await store.getters['admin_orders/updateOrderErrors'];
    if (Object.keys(updateOrderErrors.value).length === 0) {
        await router.push({name: 'admin'});
    }
};

const getBgStatus = computed(() => {
    const selectedStatus = statuses.value.find(
        (status) => status.id === updatedOrder.value.status
    );
    return selectedStatus ? selectedStatus.color : '#ffffff';
})
</script>

<template>
    <MainContainer>
        <div class="col-12">
            <router-link class="btn-link" :to="{name:'admin'}">{{ $t('Return to all orders') }}</router-link>

            <h2 v-if="updatedOrder.id">{{ $t('Edit Order', {order_number: updatedOrder.id}) }}</h2>

            <form v-if="updatedOrder.id" @submit.prevent="updateOrder">
                <div class="form-group">
                    <label for="first_name">{{ $t('Name') }}</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        v-model="updatedOrder.first_name"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.first_name"/>
                </div>
                <div class="form-group">
                    <label for="last_name">{{ $t('Surname') }}</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        v-model="updatedOrder.last_name"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.last_name"/>
                </div>
                <div class="form-group">
                    <label for="email">{{ $t('Email') }}</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        v-model="updatedOrder.email"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.email"/>
                </div>
                <div class="form-group">
                    <label for="phone">{{ $t('Phone') }}</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        v-model="updatedOrder.phone"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.phone"/>
                </div>
                <div class="form-group">
                    <label for="address_from">{{ $t('From') }}</label>
                    <input
                        type="text"
                        id="address_from"
                        name="address_from"
                        v-model="updatedOrder.address_from"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.address_from"/>
                </div>
                <div class="form-group">
                    <label for="address_to">{{ $t('To') }}</label>
                    <input
                        type="text"
                        id="address_to"
                        name="address_to"
                        v-model="updatedOrder.address_to"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.address_to"/>
                </div>
                <div class="form-group">
                    <label for="meetingDate">{{ $t('Departure Date') }}</label>
                    <input
                        type="date"
                        id="meeting_date"
                        name="meeting_date"
                        v-model="updatedOrder.meeting_date"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.meeting_date"/>
                </div>

                <div class="form-group">
                    <label for="meeting_time">{{ $t('Departure Time') }}</label>
                    <input
                        type="time"
                        id="meeting_time"
                        name="meeting_time"
                        v-model="updatedOrder.meeting_time"
                        class="form-control"
                    />
                    <Errors :errors="updateOrderErrors.meeting_time"/>
                </div>

                <div class="form-group">
                    <label for="adults">{{ $t('Adults') }}</label>
                    <select v-model="updatedOrder.adults" name="adults" class="form-select" id="adults">
                        <AdultsAmount/>
                    </select>
                    <Errors :errors="updateOrderErrors.adults"/>
                </div>
                <div class="form-group">
                    <label for="suitcases">{{ $t('Bags/Suitcases') }}</label>
                    <select name="suitcases" v-model="updatedOrder.suitcases" class="form-select" id="suitcases">
                        <BagsAmount/>
                    </select>
                    <Errors :errors="updateOrderErrors.suitcases"/>
                </div>

                <div class="form-group">
                    <label for="total_price">{{ $t('Total') }}</label>
                    <input
                        type="text"
                        id="total_price"
                        name="total_price"
                        v-model="updatedOrder.total_price"
                        class="form-control"
                        required
                        min="0"
                    />
                    <Errors :errors="updateOrderErrors.total_price"/>
                </div>

                <div class="form-group">
                    <label for="comment" class="form-label">{{$t('Comment')}}:</label>
                    <textarea v-model="updatedOrder.comment" placeholder="" type="text" name="comment" id="comment" class="form-control"></textarea>
                    <Errors :errors="updateOrderErrors.comment"/>
                </div>
                <div class="form-group">
                    <label for="status">{{ $t('Status') }}</label>
                    <select
                        id="status"
                        v-model="updatedOrder.status"
                        class="form-control select-colored"
                        :style="{backgroundColor:getBgStatus}"
                        required
                    >
                        <option
                            v-for="status in statuses"
                            :key="status.id"
                            :value="status.id"
                            :style="{ backgroundColor: status.color }"
                        >
                            {{ status.name }}
                        </option>
                    </select>
                    <Errors :errors="updateOrderErrors.status"/>
                </div>
                <div class="form-group text-center">
                    <PrimaryButton type="submit">{{ $t('Update') }}</PrimaryButton>
                </div>
            </form>

        </div>
    </MainContainer>
</template>

<style scoped>

</style>
