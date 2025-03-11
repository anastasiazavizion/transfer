<script setup>
import MainContainer from "../../Layouts/MainContainer.vue";
import {useStore} from "vuex";
import {computed, onMounted} from "vue";
import SvgEdit from "../../Components/Svg/SvgEdit.vue";
import SvgDelete from "../../Components/Svg/SvgDelete.vue";
import Swal from 'sweetalert2'
import {useRouter} from "vue-router";

const store = useStore();
const router = useRouter()

const orders = computed(() => {
    return store.getters['admin_orders/orders'];
})

onMounted(async () => {
    await store.dispatch('admin_orders/getOrders');
})


async function deleteOrder(id) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    });

    if (result.isConfirmed) {
        await store.dispatch('admin_orders/deleteOrder', {id: id});
        setTimeout(function () {
            router.go(0);
        }, 2000)
    }

}

</script>

<template>
<MainContainer>
    <div>
        <h2 class="mb-4">{{$t('Order List')}}</h2>

        <table v-if="orders" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{$t('Name')}}</th>
                <th>{{$t('Email')}}</th>
                <th>{{$t('Phone')}}</th>
                <th>{{$t('Messenger')}}</th>
                <th>{{$t('From')}}</th>
                <th>{{$t('To')}}</th>
                <th>{{$t('Date')}}</th>
                <th>{{$t('Adults')}}</th>
                <th>{{$t('Bags/Suitcases')}}</th>
                <th>{{$t('Total')}}</th>
                <th>{{$t('Status')}}</th>
                <th>{{$t('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in orders" :key="order.id">
                <td>{{ order.id }}</td>
                <td>{{ order.client.first_name }} {{ order.client.last_name }}</td>
                <td>{{ order.client.email }}</td>
                <td>{{ order.client.phone }}</td>
                <td><img :src="order.client.messenger.image" :alt="order.client.messenger.name" class="mr-2 messenger-img"/></td>
                <td>{{ order.address_from }}</td>
                <td>{{ order.address_to }}</td>
                <td>{{ order.meeting_date }}</td>
                <td>{{ order.adults }}</td>
                <td>{{ order.suitcases }}</td>
                <td>{{ order.total_price}}</td>
                <td>
                    <span class="order-status" :style="{backgroundColor:order.status.color}">
                         {{order.status.name}}
                    </span>
                </td>
                <td>
                   <SvgDelete class="cursor-pointer" @click="deleteOrder(order.id)"/>
                    <router-link class="img-link" :to="{ name: 'admin.order', params: { orderId: order.id } }">
                       <SvgEdit/>
                   </router-link>

                </td>
            </tr>
            </tbody>
        </table>

    </div>


</MainContainer>
</template>

<style scoped>

</style>
