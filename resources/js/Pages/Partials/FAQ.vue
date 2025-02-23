<script setup>
import { useI18n } from 'vue-i18n';
import {computed, reactive, watch} from 'vue';

// Set up i18n
const { t, locale } = useI18n();

const bus_and_plane = new URL('@/img/bus_and_plane.svg', import.meta.url).href;
const dog_and_cat = new URL('@/img/dog_and_cat.svg', import.meta.url).href;
const timing = new URL('@/img/timing.svg', import.meta.url).href;
const many_points = new URL('@/img/many_points.svg', import.meta.url).href;
const usdt = new URL('@/img/usdt.svg', import.meta.url).href;

const data = reactive([
  {
    id: 'faq1',
    keyLabel: 'Hate travelling by bus? Afraid of flights?',
    keyText: 'We understand you perfectly and will make your trip as comfortable as possible.',
    img: bus_and_plane,
    showDefault: true,
  },
  {
    id: 'faq2',
    keyLabel: 'Want to travel with your beloved pets?',
    keyText: 'Travels with your furry friends on long distances are not very good for your nerves when use flights or public transport. We are here to help make your journey as comfy as possible.',
    img: dog_and_cat,
    showDefault: false,
  },
  {
    id: 'faq3',
    keyLabel: 'Need to travel urgently?',
    keyText: 'There are times when you just need a quick and safe drive. We are here to help you.',
    img: timing,
    showDefault: false,
  },
  {
    id: 'faq4',
    keyLabel: 'Want to order a special route with several destinations?',
    keyText: 'This is a unique proposal from us compared to other competitors. You just need to give us the desired route from google maps to manager and we calculate the price immediately.',
    img: many_points,
    showDefault: false,
  },
  {
    id: 'faq5',
    keyLabel: 'Want to pay with crypto (USDT)?',
    keyText: 'We accept payment in USDT, please note that the price in USDT will be +10%, means 1000 euros = 1100 USDT (based on currency exchange difference).',
    img: usdt,
    showDefault: false,
  }
]);

// Computed properties to dynamically translate data based on the language
const translatedData = computed(() => {
  return data.map(item => ({
    ...item,
    label: t(item.keyLabel), // Translate label dynamically
    text: t(item.keyText), // Translate text dynamically
  }));
});


// Watch the locale and update the translations when it changes
watch(
    () => locale.value,
    () => {
        // Update the translations for each faq item when locale changes
        data.forEach((item) => {
            item.label = t(item.keyLabel);  // Update label with the translated text
            item.text = t(item.keyText);  // Update text with the translated text
        });
    },
    { immediate: true } // This ensures it updates when the component is first mounted
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
