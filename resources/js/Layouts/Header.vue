<script setup>
import Locale from "./Locale.vue";
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import MainPhone from "../Components/MainPhone.vue";
import {useI18n} from "vue-i18n";
const {t} = useI18n();
import storagePath from "@/hooks/storagePath.js";
import Logo from "../Components/Logo.vue";
const store = useStore();

const topList = ref([
    {
        image: storagePath('/header/little_car_map_2.webp'),
        first_line: t('GET COST OF YOUR ROUTE IMMEDIATELY'),
        second_line: t('No email or telephone needed'),
    },

    {
        image: storagePath('/call_center.webp'),
        first_line: t('ANY QUESTIONS ANY TIME'),
        second_line: t('Manager is in contact with You 24/7'),
    },

    {
        image: storagePath('/header/payment_with_card.webp'),
        first_line: t('NO PREPAYMENT NEEDED'),
        second_line: t('Pay after discussing details with manager')
    },
]);

const messengers = computed(() => {
    return store.getters['getMessengers'];
})

onMounted(async () => {
    await store.dispatch('getMessengers');
})

</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
           <Logo/>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item nav-item-questions">{{ $t('Questions') }}?</li>
                    <li class="nav-item">
                        <main-phone :show-call-text="true" class="nav-link nav-link-big"/>
                        <div class="special-text-under-phone d-inline">
                            {{ $t('available in:') }}
                            <div class="d-inline-block mr-2" v-for="item in messengers" :key="item.id">{{ item.name }}
                                <img :src="item.image" :alt="item.name" :title="item.name"/></div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        <Locale/>
    </nav>
    <div class="under-nav">
        <div class="container">
            <div class="row">
                <div v-for="(item,index) in topList" :key="index" class="col-xs-12 col-md-4 col-lg-4">
                    <img class="un-icon" :src="item.image" alt="">
                    <span class="un-point">
                        {{ item.first_line }} <br>
                        {{ item.second_line }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
