/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vuex from 'vuex';
Vue.use(Vuex);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('library-select', require('./vue-components/cms/articleMgnt/LibrarySelectComponent.vue').default);
Vue.component('library-select-topic-context', require('./vue-components/cms/topicMgnt/LibrarySelectComponent.vue').default);
Vue.component('library-select-project-context', require('./vue-components/cms/projectMgnt/LibrarySelectComponent.vue').default);
Vue.component('project-select', require('./vue-components/cms/articleMgnt/ProjectSelectComponent.vue').default);
Vue.component('project-select-topic-context', require('./vue-components/cms/topicMgnt/ProjectSelectComponent.vue').default);
Vue.component('topic-select', require('./vue-components/cms/articleMgnt/TopicSelectComponent.vue').default);
Vue.component('article-assign', require('./vue-components/cms/articleMgnt/ArticleAssignSelectComponent.vue').default);
Vue.component('article-route-listing-text', require('./vue-components/cms/articleMgnt/ListingRouteTextComponent.vue').default);
Vue.component('topic-route-listing-text',   require('./vue-components/cms/topicMgnt/ListingRouteTextComponent.vue').default);
Vue.component('project-route-listing-text', require('./vue-components/cms/projectMgnt/ListingRouteTextComponent.vue').default);
Vue.component('library-route-listing-text', require('./vue-components/cms/libraryMgnt/ListingRouteTextComponent.vue').default);
Vue.component('project-slug-text', require('./vue-components/cms/projectMgnt/ProjectSlugTextComponent.vue').default);
Vue.component('library-slug-text', require('./vue-components/cms/libraryMgnt/LibrarySlugTextComponent.vue').default);

Vue.component('code-highlight', require('./vue-components/cms/postComponents/CodeHighlightComponent.vue').default);
Vue.component('twilio-style-content-creator', require('./vue-components/cms/postComponents/TwilioPostContentCreatorComponent.vue').default);
Vue.component('mailchimp-style-content-creator', require('./vue-components/cms/postComponents/MailchimpPostContentCreatorComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VuexStore from './vuex-store/store';
window.store = VuexStore;

const app = new Vue({
    el: '#app',
    store,
    watch: {
    },
    data() {
        return {
        }
    },
    computed: {},
    methods: {
    },
    mounted() {
        console.log('Lost in the library? Watch your step!');
    },
});
