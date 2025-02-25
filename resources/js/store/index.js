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
        calculateFormErrors:[],
        cars:[]
    },
    mutations: {
        setFormData(state, formData) {
            state.formData = { ...formData }; // Set form data to the store
        },
        setCars(state, data) {
            state.cars = data;
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

        async getCars({commit}, formData) {
            commit('setCars', []);
            try {
                const response =  await axios.get(route('cars'));
                commit('setCars', response.data);
            } catch (error) {
                commit('setCars', []);
            }
        },

        async saveOrder({commit}, data) {
            console.log(data);
            try{
                const response =  await axios.post(route('orders.store'), data);
            } catch (error) {

                console.log(error);
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
        getCars: (state) => state.cars,
        getCalculateFormErrors: (state) => state.calculateFormErrors,
    },

    plugins: [createPersistedState()]
});
