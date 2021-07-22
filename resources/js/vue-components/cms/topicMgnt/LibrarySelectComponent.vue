<template>
    <div>
        <select class="xy" :name="name" v-model="selectedLibrary" v-if="libraries !== ''">
            <option value="" disabled>{{ nullValueLabel }}</option>
            <option v-if="libraries !== ''" v-for="(name, id) in libraries" :value="id">{{ name }}</option>
        </select>
        <div v-if="libraries === ''">
            <select class="x" :name="name" v-model="selectedLibrary" disabled>
                <option value="">{{ nullValueLabel }}</option>
            </select>
        </div>

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
                    }, 100)
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
                libraries: '',
                hideFake: false
            }
        },
        computed: {
            ...mapGetters({
                loading: 'topicManagement/loading',
                libraryOptions: 'topicManagement/libraryOptions',
            })
        },
        methods: {
            ...mapMutations({
                setToken: 'topicManagement/token',
                setActiveLib: 'topicManagement/activeLibrary',
                setProjects: 'topicManagement/activeProject',
                setTopics: 'topicManagement/activeTopic',
            }),
            ...mapActions({
                getLibs: 'topicManagement/getAvailableLibraries'
            })
        },
        mounted() {
            console.log('Library Select!', this.token);
            this.setToken(this.token);
            this.getLibs();
            $('.x').select2({
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
    .xy, .x {
        width: 100%;
    }
</style>
