import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from "./auth.js";
import admin_orders from "./admin/orders.js";
import statuses from "./admin/statuses.js";

export default createStore({
    modules: {
        auth,
        statuses,
        admin_orders,
    },
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
        clientFormErrors:[],
        cars:[],
        newOrderId : null,
        order : null,
        messengers: []
    },
    mutations: {
        setFormData(state, formData) {
            state.formData = { ...formData }; // Set form data to the store
        },
        setOrder(state, data) {
            state.order = data;
        },
        setCars(state, data) {
            state.cars = data;
        },
        setMessengers(state, data) {
            state.messengers = data;
        },
        setNewOrderId(state, data) {
            state.newOrderId = data;
        },
        setCalculateFormErrors(state, data) {
            state.calculateFormErrors = data;
        },
        setClientFormErrors(state, data) {
            state.clientFormErrors = data;
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

        async getCars({commit}) {
            try {
                const response =  await axios.get(route('cars'));
                commit('setCars', response.data);
            } catch (error) {
                commit('setCars', []);
            }
        },

        async getMessengers({commit}) {
            try {
                const response =  await axios.get(route('messengers.index'));
                commit('setMessengers', response.data);
            } catch (error) {
                commit('setMessengers', []);
            }
        },


        async getOrder({commit}, id) {
            try {
                const response = await axios.get(route('orders.show', { order: id }));
                commit('setOrder', response.data);
            } catch (error) {
                commit('setOrder', null);
            }
        },

        async saveOrder({commit}, data) {
            commit('setClientFormErrors',[]);
            try{
                const response =  await axios.post(route('orders.store'), data);
                commit('setNewOrderId', response.data.id);
            } catch (error) {
                if (error.response.status === 422) {
                    commit('setClientFormErrors', error.response.data.errors);
                } else {
                    commit('setClientFormErrors', [{'other': 'Some other errors'}]);
                }
                commit('setNewOrderId', null);
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
        getNewOrderId: (state) => state.newOrderId,
        getCars: (state) => state.cars,
        getOrder: (state) => state.order,
        getMessengers: (state) => state.messengers,
        getClientFormErrors: (state) => state.clientFormErrors,
        getCalculateFormErrors: (state) => state.calculateFormErrors,
    },

    plugins: [createPersistedState()]
});
