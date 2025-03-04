import axios from 'axios';

const state = {
    statuses: [],
};

const getters = {
    statuses: state => state.statuses
};

const mutations = {
    setStatuses (state, value) {
        state.statuses = value;
    }
};

const actions = {
    async getStatuses({ commit}) {
        try {
            const response = await axios.get(route('statuses.index'));
            commit('setStatuses', response.data);
        } catch (error) {
            commit('setStatuses', []);
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
