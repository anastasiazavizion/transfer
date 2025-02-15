import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

export default createStore({
    state: {
        formData: {
            address_from: '',
            address_to: '',
            meeting_date: '',
            meeting_time: '',
            adults: 1,
            children: 0,
            suitcases: 0,
            addRoadBack: false,
        },
        calculateFormErrors:[]
    },
    mutations: {
        setFormData(state, formData) {
            state.formData = { ...formData }; // Set form data to the store
        },
        setCalculateFormErrors(state, data) {
            state.calculateFormErrors = data;
        },
    },
    actions: {
        async validateFormData({commit}, formData) {
            commit('setCalculateFormErrors', []);
            try {
                const response =  await axios.post('/api/validateCalculateForm', formData);
            } catch (error) {
                if (error.response.status === 422) {
                    commit('setCalculateFormErrors', error.response.data.errors);
                } else {
                    commit('setCalculateFormErrors', [{'other': 'Some other errors'}]);
                }
            }
        },

        async updateFormData({commit}, formData) {
            commit('setFormData', formData);
        },
        async updateCalculateFormErrors({commit}, data) {
            commit('setCalculateFormErrors', data);
        },
    },
    getters: {
        getFormData: (state) => state.formData,
        getCalculateFormErrors: (state) => state.calculateFormErrors,
    },

    plugins: [createPersistedState()]
});
