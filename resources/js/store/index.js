import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            successMessage: '',
        };
    },
    mutations: {
        setSuccessMessage(state, message) {
            state.successMessage = message;
        },
    },
    actions: {
        setSuccessMessage({ commit }, message) {
            commit('setSuccessMessage', message);
        },
    },
    getters: {
        successMessage: (state) => state.successMessage,
    }
});

export default store;
