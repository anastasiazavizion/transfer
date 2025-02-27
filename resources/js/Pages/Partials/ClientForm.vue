<script setup>
import {computed, onMounted, ref} from "vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import Errors from "../../Components/Errors.vue";
const router = useRouter()

const store = useStore();

const props = defineProps({
    total:Number,
    car_id:Number,
    data:Object,
    distance:String,
    duration:String,
    km_to_location_1:String,
    km_to_location_2:String,
    km_to_location_3:String,
})

const clientForm = ref({
    name:'',
    surname:'',
    email:'',
    phone:'',
    comment:'',
    preferred_messenger_id : 0
});

const clientFormErrors = ref([]);

async function saveOrder() {
    const payload = {
        ...clientForm.value,
        ...props
    };
    await store.dispatch('saveOrder', payload)
    clientFormErrors.value = await store.getters['getClientFormErrors'];
    if (Object.keys(clientFormErrors.value).length === 0) {
        const orderId = store.getters['getNewOrderId'];
        if (orderId) {
            await router.push({name: 'success', params: {orderId: orderId}});
        }
    }
}

const messengers = computed(() => {
  return store.getters['getMessengers'];
})

onMounted(async () => {
  await store.dispatch('getMessengers');
})

</script>

<template>
    <div class="row bg-white text-black div-rounded mt-4 div-padding">
      <div class="col">

          <form @submit.prevent="saveOrder">
              <div class="mb-2">
                  <label for="name" class="form-label">{{$t('Name')}}:</label>
                  <input v-model="clientForm.name" placeholder="" type="text" name="name" id="name" class="form-control">
                  <Errors :errors="clientFormErrors.name"/>
              </div>

              <div class="mb-2">
                  <label for="surname" class="form-label">{{$t('Surname')}}:</label>
                  <input v-model="clientForm.surname" placeholder="" type="text" name="surname" id="surname" class="form-control">
                  <Errors :errors="clientFormErrors.surname"/>
              </div>

              <div class="mb-2">
                  <label for="email" class="form-label">{{$t('Email')}}:</label>
                  <input v-model="clientForm.email" placeholder="" type="email" name="email" id="email" class="form-control">
                  <Errors :errors="clientFormErrors.email"/>
              </div>

              <div class="mb-2">
                  <label for="phone" class="form-label">{{$t('Phone')}}:</label>
                  <input v-model="clientForm.phone" placeholder="" type="text" name="phone" id="phone" class="form-control">
                  <Errors :errors="clientFormErrors.phone"/>
              </div>

              <div class="mb-2">
                  <label for="comment" class="form-label">{{$t('Comment')}}:</label>
                  <textarea v-model="clientForm.comment" placeholder="" type="text" name="comment" id="comment" class="form-control"></textarea>
                  <Errors :errors="clientFormErrors.comment"/>
              </div>

              <div class="mb-2">
                <div>
                  <label>{{$t('Preferred messenger')}}</label>
                  <div v-for="item in messengers" :key="item.id" class="form-check">
                    <input
                        type="radio"
                        :id="'messenger_' + item.id"
                        v-model="clientForm.preferred_messenger_id"
                        :value="item.id"
                        class="form-check-input"
                    />
                    <label :for="'messenger_' + item.id" class="form-check-label">
                      <img :src="item.image" :alt="item.name" class="mr-2 messenger-img" />
                      {{ item.name }}
                    </label>
                  </div>
                    <Errors :errors="clientFormErrors.preferred_messenger_id"/>
                </div>
              </div>

              <div class="mb-2">
                  <PrimaryButton type="submit">{{$t('Submit')}}</PrimaryButton>
              </div>
          </form>

      </div>

    </div>


</template>

<style scoped>

</style>
