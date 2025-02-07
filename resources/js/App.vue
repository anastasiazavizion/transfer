<script setup>
import {useStore} from "vuex";
const store = useStore();
import {useRouter} from "vue-router";
import {computed, onMounted, ref} from "vue";
const router = useRouter();

const logout = async () => {
    await store.dispatch('auth/logout');
    await router.push('/auth/login');
};

const user =  computed(()=>{
    return store.getters['auth/user']
})

const authenticated = computed(()=>{
    return store.getters['auth/authenticated']
})

const logoSrc = ref('');

async function getLogo() {
    try {
        const response = await axios.get(route('getLogo'));
        logoSrc.value = response.data;
    } catch (error) {
        console.error('Error fetching logo:', error);
    }
}

onMounted(()=>{
    getLogo();
})


const showRate = ref(false);

const appName = import.meta.env.VITE_APP_NAME;

</script>

<template>
    <div class="min-h-screen flex flex-col">
        <h1 class="text-3xl font-bold">
            Hello world!!
        </h1>
        <div class="container default-component flex-grow">
            <main>
                <router-view></router-view>
            </main>
        </div>
        <Footer/>
    </div>
</template>
