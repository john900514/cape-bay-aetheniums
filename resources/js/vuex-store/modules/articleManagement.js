import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const articleManagement = {
    namespaced: true,
    state() {
        return {
            url: '',
            loading: false,
            token: '',
            libraryOptions: {},
            projectOptions: {},
            availableProjects: '',
            topicOptions: {},
            articleOptions: {},
            activeLibrary: '',
            activeProject: '',
            activeTopic: ''
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
        libraryOptions(state, options) {
            state.libraryOptions = options;
        },
        projectOptions(state, options) {
            state.projectOptions = options;
        },
        topicOptions(state, options) {
            state.topicOptions = options;
        },
        articleOptions(state, options) {
            state.articleOptions = options;
        },
        activeLibrary(state, idx) {
            state.activeLibrary = idx;
        },
        activeProject(state, idx) {
            state.activeProject = idx;
        },
        activeTopic(state, idx) {
            state.activeTopic = idx;
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
        libraryOptions({ libraryOptions }) {
            return libraryOptions
        },
        projectOptions({ projectOptions }) {
            return projectOptions
        },
        topicOptions({ topicOptions }) {
            return topicOptions
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
        availableProjectRoutes({ activeLibrary, projectOptions }) {
            return projectOptions[activeLibrary].routes;
        },
        availableTopics({ activeProject, topicOptions }) {
            if(activeProject === '') {
                return '';
            }
            return topicOptions[activeProject];
        },
    },
    actions: {
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

export default articleManagement;
