<template>
    <div>
        <select class="xy" :name="name" v-model="selectedLibrary">
            <option value="" disabled>{{ nullValueLabel }}</option>
            <option v-if="libraries !== ''" v-for="(name, id) in libraries" :value="id">{{ name }}</option>
        </select>
    </div>

</template>

<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default {
        name: "LibrarySelectComponent",
        props: ['name', 'token', 'preloadedValue'],
        watch: {
            loading(flag) {
                if(flag) {
                    this.nullValueLabel = 'Loading Libraries..';
                }
                else {
                    let _this = this;
                    this.nullValueLabel = 'Select a Library';
                    setTimeout(function () {
                        $('.xy').select2({
                            theme: "bootstrap"
                        }).on('select2:select', function(e) {
                            _this.selectedLibrary = $(this).val();
                        });
                    }, 500)
                }
            },
            libraryOptions(options) {
                console.log('updated library options');
                this.libraries = options.select;
            },
            selectedLibrary(lib) {
                this.setActiveLib(lib);
                console.log(this.libraries[lib]+', sucka!');
            }
        },
        data() {
            return {
                nullValueLabel: 'Loading Libraries..',
                selectedLibrary: '',
                libraries: ''
            }
        },
        computed: {
            ...mapGetters({
                loading: 'articleManagement/loading',
                libraryOptions: 'articleManagement/libraryOptions',
            })
        },
        methods: {
            ...mapMutations({
                setToken: 'articleManagement/token',
                setActiveLib: 'articleManagement/activeLibrary',
                setProjects: 'articleManagement/activeProject',
                setTopics: 'articleManagement/activeTopic',
            }),
            ...mapActions({
                getLibs: 'articleManagement/getAvailableLibraries'
            })
        },
        mounted() {
            console.log('Library Select!', this.token);
            this.setToken(this.token);
            this.getLibs();
            $('.xy').select2({
                theme: "bootstrap"
            })
            console.log('Library Select! Mounted');

            if(this.preloadedValue !== '') {
                this.selectedLibrary = this.preloadedValue;
            }
        }
    }
</script>

<style scoped>
    .xy, .xz {
        width: 100%;
    }
</style>
