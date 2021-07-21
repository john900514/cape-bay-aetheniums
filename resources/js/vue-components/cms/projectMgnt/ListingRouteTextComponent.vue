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
                console.log('selectedLib ', lib);
                console.log('project routes  ', this.libraryRoutes);
                if(this.libraryRoutes !== undefined) {
                    let r = this.libraryRoutes[lib];

                    this.urlPartOfTheText = r.replace('libraries','projects');
                }
            },
        },
        data() {
            return {
                urlPartOfTheText: '',
                //inputText: '',
                placeholder: 'url will be auto-gend\'d here',
            }
        },
        computed: {
            inputText() {
                if(this.urlSlug === '') {
                    return this.urlPartOfTheText
                }

                return this.urlPartOfTheText + '/'+this.urlSlug;
            },
            ...mapGetters({
                selectedLib: 'projectManagement/activeLibrary',
                urlSlug: 'projectManagement/urlSlug',
                libraryRoutes: 'projectManagement/availableLibraryRoutes'
            })
        },
        methods: {},
        mounted() {
            console.log('Listing Route', this.preloadedValue);
            if(this.preloadedValue !== '') {
                console.log('Preloaded fucking value', this.preloadedValue)
                //this.urlPartOfTheText = this.preloadedValue;
            }
        }
    }
</script>

<style scoped>
    .listing-route {
        width: 100%;
    }
</style>
