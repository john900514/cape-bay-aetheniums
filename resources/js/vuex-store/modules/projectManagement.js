import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const projectManagement = {
    namespaced: true,
    state() {
        return {
            url: '',
            loading: false,
            token: '',
            libraryOptions: {},
            projectOptions: {},
            availableProjects: '',
            articleOptions: {},
            activeLibrary: '',
            activeProject: '',
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

        loading(state, flag) {
            state.loading = flag;
        },
        token(state, val) {
            state.token = val;
        },
        libraryOptions(state, options) {
            state.libraryOptions = options;
        },
        projectOptions(state, options) {
            state.projectOptions = options;
        },
        articleOptions(state, options) {
            state.articleOptions = options;
        },
        activeLibrary(state, idx) {
            console.log('Fuck you');
            state.activeLibrary = idx;
        },
    },
    getters: {
        url(state) {
            return state.url;
        },
        urlSlug(state) {
            return state.urlSlug;
        },

        loading(state) {
            return state.loading;
        },
        token({ token }) {
            return token
        },
        libraryOptions({ libraryOptions }) {
            return libraryOptions
        },
        projectOptions({ projectOptions }) {
            return projectOptions
        },
        articleOptions({ articleOptions }) {
            return articleOptions
        },
        activeLibrary({ activeLibrary }) {
            return activeLibrary;
        },
        activeProject({ activeProject }) {
            return activeProject;
        },
        activeTopic({ activeTopic }) {
            return activeTopic;
        },
        availableProjects({ activeLibrary, projectOptions }) {
            return projectOptions[activeLibrary];
        },
        availableLibraryRoutes({ libraryOptions, activeLibrary }) {
            return libraryOptions.routes;
        },
        availableProjectRoutes({ activeLibrary, projectOptions }) {
            return projectOptions[activeLibrary].routes;
        },
    },
    actions: {
        getAvailableLibraries({ commit, getters }) {
            commit('loading', true)
            console.log('Retrieving Libs...')
            let url = `/api/libraries?asSelectData=true&projects=true&token=${getters.token}`;

            axios.get(url)
                .then(({ data }) => {
                    console.log(data);
                    commit('libraryOptions', data['libraries']);
                    commit('projectOptions', data['projects']);

                    setTimeout(function () {
                        commit('loading', false)
                    }, 1000);

                })
                .catch(err => {
                    alert('aww!')
                });
        },
        triggerExportAllJob({ commit }, args) {
            commit('loading', true)

            axios.post('/admin/export-all', args)
                .then(({data}) => {
                    console.log(data)
                    commit('loading', false)

                    if(data['success']) {
                        alert('Export Job queue\'d up. It will be emailed to you when completed.')
                    }
                    else {
                        alert('Export failed. Please try again');
                    }
                })
                .catch(err => {

                });
        }
    }
};

export default projectManagement;
