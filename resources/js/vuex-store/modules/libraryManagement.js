import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const libraryManagement = {
    namespaced: true,
    state() {
        return {
            url: '',
            urlSlug: ''
        };
    },
    mutations: {
        url(state, uri) {
            state.url = uri;
        },
        urlSlug(state, slug) {
            state.urlSlug = slug;
        },

    },
    getters: {
        url(state) {
            return state.url;
        },
        urlSlug(state) {
            return state.urlSlug;
        },
    },
    actions: {

    }
};

export default libraryManagement;
