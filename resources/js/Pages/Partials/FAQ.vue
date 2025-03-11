<script setup>
import { useI18n } from 'vue-i18n';
import {computed, reactive, watch} from 'vue';
const { t, locale } = useI18n();

const data = reactive([
  {
    id: 'faq1',
    keyLabel: 'Hate travelling by bus? Afraid of flights?',
    keyText: 'We understand you perfectly and will make your trip as comfortable as possible.',
    img: '/images/faq/plane_and_bus_2.webp',
    showDefault: true,
  },
  {
    id: 'faq2',
    keyLabel: 'Want to travel with your beloved pets?',
    keyText: 'Travels with your furry friends on long distances are not very good for your nerves when use flights or public transport. We are here to help make your journey as comfy as possible.',
    img: '/images/faq/cat_and_dog_2.webp',
    showDefault: false,
  },
  {
    id: 'faq3',
    keyLabel: 'Need to travel urgently?',
    keyText: 'There are times when you just need a quick and safe drive. We are here to help you.',
    img: '/images/faq/time_clock_2.webp',
    showDefault: false,
  },
  {
    id: 'faq4',
    keyLabel: 'Want to order a special route with several destinations?',
    keyText: 'This is a unique proposal from us compared to other competitors. You just need to give us the desired route from google maps to manager and we calculate the price immediately.',
    img: '/images/header/little_car_map_2.webp',
    showDefault: false,
  },
  {
    id: 'faq5',
    keyLabel: 'Want to pay with crypto (USDT)?',
    keyText: 'We accept payment in USDT, please note that the price in USDT will be +10%, means 1000 euros = 1100 USDT (based on currency exchange difference).',
    img: '/images/faq/crypto_2.webp',
    showDefault: false,
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
    <div class="faq-accordion-holder">
        <div class="accordion" id="faqAccordion">
            <div v-for="item in translatedData" :key="item.id" class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        :class="{ collapsed: !item.showDefault }"
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="'#' + item.id"
                    >
                        <img class="acc-item-icon" :src="item.img" :alt="item.label">
                        {{ item.label }}
                    </button>
                </h2>
                <div :class="{ show: item.showDefault }" :id="item.id" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ item.text }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
