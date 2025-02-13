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
    },
    mutations: {
        setFormData(state, formData) {
            state.formData = { ...formData }; // Set form data to the store
        },
    },
    actions: {
        updateFormData({ commit }, formData) {
            commit('setFormData', formData); // Commit mutation to update form data
        },
    },
    getters: {
        getFormData: (state) => state.formData, // Retrieve form data from store
    },

    plugins: [createPersistedState()]
});
