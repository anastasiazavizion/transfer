<script setup>
import { useI18n } from 'vue-i18n';
import {computed, reactive, watch} from 'vue';

// Set up i18n
const { t, locale } = useI18n();


const data = reactive([
  {
    id: 'faq1',
    keyLabel: 'How do I book a trip?',
    keyText: 'You can book a trip by filling out the form and clicking the "Search" button.',
    showDefault: true,
  },
  {
    id: 'faq2',
    keyLabel: 'Can I cancel my booking?',
    keyText: 'Yes, you can cancel your booking before the departure date.',
    showDefault: false,
  },
  {
    id: 'faq3',
    keyLabel: 'What payment methods are accepted?',
    keyText: 'We accept credit cards, PayPal, and bank transfers.',
    showDefault: false,
  },
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
        <h3>FAQ</h3>
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
