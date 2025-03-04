import axios from 'axios';

const state = {
    orders: {},
    order:{},
    errors: [],
    updateOrderErrors: [],
};

const getters = {
    orders: state => state.orders,
    order: state => state.order,
    errors: state => state.errors,
    updateOrderErrors: state => state.updateOrderErrors,
};

const mutations = {
    setOrders (state, value) {
        state.orders = value;
    },
    setOrder (state, value) {
        state.order = value;
    },
    setErrors (state, value) {
        state.errors = value;
    },
    setUpdateOrderErrors (state, value) {
        state.updateOrderErrors = value;
    },
};

const actions = {
    async getOrders({ commit}) {
        try {
            const response = await axios.get(route('admin_orders.index'));
            commit('setOrders', response.data);
        } catch (error) {
            if(error.response.status === 403){
                commit('setErrors',{auth:true});
            }else{
                commit('setErrors',error.response.data.errors);
            }
        }
    },

    async updateOrder({ commit}, data) {
        commit('setUpdateOrderErrors',[]);
        try{
            const response =  await axios.put(route('admin_orders.update', {order:data.id}), data);
        } catch (error) {
            if (error.response.status === 422) {
                commit('setUpdateOrderErrors', error.response.data.errors);
            } else {
                commit('setUpdateOrderErrors', [{'other': 'Some other errors'}]);
            }
        }

    },

    async deleteOrder({ commit}, data) {
        try{
            const response =  await axios.delete(route('admin_orders.destroy', {order:data.id}));
        } catch (error) {
            console.log(error);
        }

    },

    async getOrder({commit}, id) {
        try {
            const response = await axios.get(route('admin_orders.show', { order: id }));
            commit('setOrder', response.data);
        } catch (error) {
            commit('setOrder', null);
        }
    },

};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
