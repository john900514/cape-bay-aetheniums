import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import pageManagement from "./modules/pageManagement";
import topicManagement from "./modules/topicManagement";
import libraryManagement from "./modules/libraryManagement";
import articleManagement from "./modules/articleManagement";
import projectManagement from "./modules/projectManagement";

export default new Vuex.Store({
    modules: {
        pageManagement,
        topicManagement,
        libraryManagement,
        articleManagement,
        projectManagement
    },
    state() {
        return {

        };
    },
    mutations: {

    },
    getters: {

    },
    actions: {

    }
});
