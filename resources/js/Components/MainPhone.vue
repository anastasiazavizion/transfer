<script setup>
import {computed} from "vue";
import {useI18n} from "vue-i18n";
const {t} = useI18n();
const mainPhone = import.meta.env.VITE_MAIN_PHONE;
const mainPhoneText = "tel:"+mainPhone;
const props = defineProps({
    showCallText:{
        type:Boolean,
        default:false
    }
})
const hrefText = computed(()=>{
    return (props.showCallText ? t('Call') : '') + ' ' + mainPhone;

})
</script>

<template>
    <a :href="mainPhoneText">{{hrefText}}</a>
</template>
