<script setup>

import {ref} from "vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import {data} from "autoprefixer";
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

function saveOrder(){
    const payload = {
        ...clientForm.value,
        ...props
    };
    store.dispatch('saveOrder', payload)
    router.push({name:'success'});
}

</script>

<template>

    <div class="row bg-white text-black div-rounded mt-4 div-padding">
      <div class="col">

          <form @submit.prevent="saveOrder">
              <div class="mb-2">
                  <label for="name" class="form-label">{{$t('Name')}}:</label>
                  <input v-model="clientForm.name" placeholder="" type="text" name="name" id="name" class="form-control">
              </div>

              <div class="mb-2">
                  <label for="surname" class="form-label">{{$t('Surname')}}:</label>
                  <input v-model="clientForm.surname" placeholder="" type="text" name="surname" id="surname" class="form-control">
              </div>

              <div class="mb-2">
                  <label for="email" class="form-label">{{$t('Email')}}:</label>
                  <input v-model="clientForm.email" placeholder="" type="email" name="email" id="email" class="form-control">
              </div>

              <div class="mb-2">
                  <label for="phone" class="form-label">{{$t('Phone')}}:</label>
                  <input v-model="clientForm.phone" placeholder="" type="text" name="phone" id="phone" class="form-control">
              </div>


              <div class="mb-2">
                  <label for="comment" class="form-label">{{$t('Comment')}}:</label>
                  <textarea v-model="clientForm.comment" placeholder="" type="text" name="comment" id="comment" class="form-control"></textarea>
              </div>

              <div class="mb-2">
                  <label for="comment" class="form-label">{{$t('Preferred messenger')}}:</label>
                  <select id="preferred_messenger_id" name="preferred_messenger_id" class="form-control" v-model="clientForm.preferred_messenger_id">
                      <option value="0">{{$t('Select')}}</option>
                      <option value="1">Viber</option>
                      <option value="2">Telegram</option>
                      <option value="3">WhatsUp</option>
                  </select>

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
