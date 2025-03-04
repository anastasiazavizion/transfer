import axios from 'axios';

const state = {
    authenticated: false,
    user: {},
    errors: [],
};

const getters = {
    authenticated: state => state.authenticated,
    user: state => state.user,
    errors: state => state.errors,
};

const mutations = {
    SET_AUTHENTICATED (state, value) {
        state.authenticated = value;
    },
    SET_USER (state, value) {
        state.user = value;
    },
    setErrors (state, value) {
        state.errors = value;
    },
};

const actions = {
    async login({ commit, dispatch}, payload) {
        try {
            await axios.post(route('login'), payload);
            commit('setErrors', []);
            await dispatch('getUser');
        } catch (error) {
            if(error.response.status === 403){
                commit('setErrors',{auth:true});
            }else{
                commit('setErrors',error.response.data.errors);
            }
        }
    },

    async getUser({ commit }, payload) {
        try {
            const response = await axios.get(route('user'));
            const { user } = response.data;
            commit('SET_USER', user);
            commit('SET_AUTHENTICATED', true);
            commit('setErrors', []);
        } catch (error) {
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
            commit('setErrors', error.response.data.errors);
        }
    },

    async logout({commit}) {
        try{
            await axios.post(route('logout'));
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
        }catch (error){

        }
    },
    async clearErrors({commit}) {
        commit('setErrors', []);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
