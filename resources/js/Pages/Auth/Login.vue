<script setup>
import {useStore} from 'vuex'
import {computed, onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import Errors from "@/Components/Errors.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import MainContainer from "../../Layouts/MainContainer.vue";

const router = useRouter();
const store = useStore();

onMounted(() => {
    store.dispatch('auth/clearErrors');
})

const auth = ref({
    email: "",
    password: ""
});

const errors = computed(()=>{
    return store.getters['auth/errors'];
})

async function redirectToAdmin() {
    if (Object.keys(errors.value).length === 0) {
        await router.push('/admin');
    }
}

async function loginF(data) {
    await store.dispatch('auth/login', data);
    await redirectToAdmin();
}

const login = async () => {
    await axios.get('/sanctum/csrf-cookie');
    await loginF(auth.value);
};

</script>
<template>
        <MainContainer>
            <form @submit.prevent="login" class="space-y-6" action="#" method="POST">

                <div class="mb-2">
                    <label for="email" class="form-label">{{$t('Email')}}:</label>
                    <input v-model="auth.email" placeholder="" type="text" name="email"
                           id="email" class="form-control">
                    <Errors :errors="errors.email"/>
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label">{{$t('Password')}}:</label>
                    <input v-model="auth.password" placeholder="" type="password" name="password"
                           id="password" class="form-control">
                </div>

                <div class="mb-2">
                    <PrimaryButton>{{$t('Sign in')}}</PrimaryButton>
                </div>

                <div v-if="errors.auth" class="text-red-600 font-bold">
                    {{$t('Something is wrong')}}
                </div>
            </form>
        </MainContainer>
</template>
