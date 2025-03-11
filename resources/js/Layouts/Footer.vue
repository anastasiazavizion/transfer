<script setup>
import Logo from "../Components/Logo.vue";
import MainPhone from "../Components/MainPhone.vue";
import {useStore} from "vuex";
import {computed, onMounted} from "vue";

const store = useStore();

const messengers = computed(() => {
    return store.getters['getMessengers'];
})

onMounted(async () => {
    await store.dispatch('getMessengers');
})


</script>

<template>
    <footer class="bg-dark text-light py-4 custom-footer mt-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4">
                    <h5>
                       <Logo/>
                    </h5>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
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
        </div>
    </footer>

</template>

<style scoped>

</style>
