<script setup>
const data = [
    {
        id: 'faq1',
        label: 'How do I book a trip?',
        text: 'You can book a trip by filling out the form and clicking the "Search" button.',
        showDefault: true
    },

    {
        id: 'faq2',
        label: 'Can I cancel my booking?',
        text: 'Yes, you can cancel your booking before the departure date.',
        showDefault: false
    },

    {
        id: 'faq3',
        label: 'What payment methods are accepted?',
        text: 'We accept credit cards, PayPal, and bank transfers.',
        showDefault: false
    },
];
</script>

<template>

    <div class="faq-accordion-holder">
        <h3>FAQ</h3>
        <div class="accordion" id="faqAccordion">
            <div v-for="item in data" class="accordion-item">
                <h2 class="accordion-header">
                    <button :class="{collapsed:!item.showDefault}" class="accordion-button" type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#'+item.id">
                        {{ item.label }}
                    </button>
                </h2>
                <div :class="{show : item.showDefault}" :id="item.id" class="accordion-collapse collapse"
                     data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ item.text }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
