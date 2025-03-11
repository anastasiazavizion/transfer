<script setup>
import { useI18n } from 'vue-i18n';
import {computed, reactive, watch} from 'vue';
const { t, locale } = useI18n();

const data = reactive([
  {
    id: 'hiw1',
    keyLabel: 'Calculate Route Price',
    icon: '<i class="bi bi-calculator step-icon"></i>',
    img: '/images/europe_1.webp',
    keyText: 'Choose destinations, date and time, amount of passengers and bags'
  },
  {
    id: 'hiw2',
    keyLabel: 'Select Available Car',
    icon: '<i class="bi bi-car-front step-icon"></i>',
    img: '/images/moving_cars.webp',
    keyText: 'Select one of the available cars if the price meets your budget'
  },
  {
    id: 'hiw3',
    keyLabel: 'Submit Your Contact Info',
      icon: '<i class="bi bi-envelope-check step-icon"></i>',
    img: '/images/contact_info.webp',
    keyText: 'Fill the contact info form, choose preferable messenger'
  },
  {
    id: 'hiw4',
    keyLabel: 'Get Our Direct Message',
      icon: '<i class="bi bi-chat-dots step-icon"></i>',
    img: '/images/call_center.webp',
    keyText: 'Our managers will contact you within 2 hours via preferred messenger'
  }
]);

const translatedData = computed(() => {
  return data.map(item => ({
    ...item,
    label: t(item.keyLabel),
    text: t(item.keyText),
  }));
});

watch(
    () => locale.value,
    () => {
        data.forEach((item) => {
            item.label = t(item.keyLabel);
            item.text = t(item.keyText);
        });
    },
    { immediate: true }
);
</script>

<template>
    <div class="row g-4"  >
        <div class="col-md-3" v-for="item in translatedData" :key="item.id">
            <div class="step p-4 shadow hiw-container">
                <div class="hiw-img-parent">
                    <img class="hiw-img" :src="item.img" :alt="item.label">
                    <span class="hiw-icon" v-html="item.icon"></span>
                </div>
                <h5>{{ item.label }}</h5>
                <p>
                    {{ item.text }}
                </p>
            </div>
        </div>
    </div>
</template>
