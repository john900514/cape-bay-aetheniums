<template>
    <input type="text" :name="name" v-model="inputText" class="form-control listing-route" readonly :placeholder="placeholder">
</template>

<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default {
        name: "ListingRouteTextComponent",
        props: ['name', 'preloadedValue'],
        watch: {
            selectedLib(lib) {
                console.log('selectedLib '+ lib);
                this.inputText = '/library';
            },
            selectedProj(proj) {
                this.inputText = this.projectRoutes[proj];
            },
            selectedTopic(topic) {
                this.inputText = this.inputText + '/articles'
            }
        },
        data() {
            return {
                inputText: '',
                placeholder: 'url will be auto-gend\'d here',
            }
        },
        computed: {
            ...mapGetters({
                selectedLib: 'articleManagement/activeLibrary',
                selectedProj: 'articleManagement/activeProject',
                selectedTopic: 'articleManagement/activeTopic',
                projectRoutes: 'articleManagement/availableProjectRoutes'
            })
        },
        methods: {},
        mounted() {
            console.log('Listing Route', this.preloadedValue);
            if(this.preloadedValue !== '') {
                this.inputText = this.preloadedValue;
            }
        }
    }
</script>

<style scoped>
    .listing-route {
        width: 100%;
    }
</style>
