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

                    if(!this.preloaded) {
                        if(this.preloadedValue !== '') {
                            this.selectedLibrary = this.preloadedValue;
                        }

                        this.preloaded = true;
                    }

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
                console.log(this.libraries[lib]+', select!');
            }
        },
        data() {
            return {
                nullValueLabel: 'Loading Libraries..',
                selectedLibrary: '',
                libraries: '',
                preloaded: false,
            }
        },
        computed: {
            ...mapGetters({
                loading: 'projectManagement/loading',
                libraryOptions: 'projectManagement/libraryOptions',
            })
        },
        methods: {
            ...mapMutations({
                setToken: 'projectManagement/token',
                setActiveLib: 'projectManagement/activeLibrary',
            }),
            ...mapActions({
                getLibs: 'projectManagement/getAvailableLibraries'
            })
        },
        mounted() {
            console.log('Library Select!', this.token);
            this.setToken(this.token);
            this.getLibs();
            setTimeout(function () {
                $('.xy').select2({
                    theme: "bootstrap"
                });
            }, 250)
            console.log('Library Select! Mounted');


        }
    }
</script>

<style scoped>
    .xy, .xz {
        width: 100%;
    }
</style>
