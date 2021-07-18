import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const pageManagement = {
    namespaced: true,
    state() {
        return {
            url: '',
            loading: false,
            token: '',
            pageOptions: '',
        };
    },
    mutations: {
        url(state, uri) {
            state.url = uri;
        },

        loading(state, flag) {
            state.loading = flag;
        },
        token(state, val) {
            state.token = val;
        },
        pageOptions(state, options) {
            state.pageOptions = options;
        },

    },
    getters: {
        url(state) {
            return state.url;
        },

        loading(state) {
            return state.loading;
        },
        token({ token }) {
            return token
        },
        pageOptions({ pageOptions }) {
            return pageOptions;
        },
    },
    actions: {
        getPagesMadeForArticles({ commit, getters }) {
            commit('loading', true)
            console.log('Retrieving Article Posts...');
            let url = `/api/pages?asSelectData=true&articles=true&token=${getters.token}`;

            axios.get(url)
                .then(({ data }) => {
                    console.log(data);
                    commit('pageOptions', data);

                    setTimeout(function () {
                        commit('loading', false)
                    }, 250);

                })
                .catch(err => {
                    alert('aww!')
                });

        },
        getAvailableLibraries({ commit, getters }) {
            commit('loading', true)
            console.log('Retrieving Libs...')
            let url = `/api/libraries?asSelectData=true&projects=true&topics=true&articles=true&token=${getters.token}`;

            axios.get(url)
                .then(({ data }) => {
                    console.log(data);
                    commit('libraryOptions', data['libraries']);
                    commit('projectOptions', data['projects']);
                    commit('topicOptions', data['topics']);
                    commit('articleOptions', data['articles']);

                    setTimeout(function () {
                        commit('loading', false)
                    }, 1000);

                })
                .catch(err => {
                    alert('aww!')
                });
        },
    }
};

export default pageManagement;
