<template>
    <div>
        <select class="wx" :name="name" v-model="selectedProject" v-if="pjs !== ''">
            <option value="" disabled>Select a Project</option>
            <option  v-for="(name, id) in pjs" :value="id">{{ name }}</option>
        </select>
        <div v-if="pjs === ''">
            <select class="w" :name="name" v-model="selectedProject"  disabled>
                <option value="" disabled >Requires Library Selection</option>
            </select>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default {
        name: "ProjectSelectComponent",
        props: ['name', 'preloadedValue'],
        watch: {
            availableProjects(options) {
                console.log('new project options', options);
                if(this.showFake) {
                    console.log('W  bro');
                    //$('.w').data('select2').destroy();
                    this.showFake = false;
                }

                this.pjs = options['select'];
            },
            pjs(js) {
                let _this = this;

                if((this.preloadedValue !== '') && (!this.presetSet)) {
                    this.selectedProject = this.preloadedValue;
                    this.presetSet = false;
                }

                setTimeout(function() {
                    $('.wx').select2({
                        theme: "bootstrap"
                    }).on('select2:select', function(e) {
                        _this.selectedProject = $(this).val();
                    });
                }, 250)
            },
            activeLibrary(lib) {
                this.selectedProject = '';
            },
            selectedProject(proj) {
                this.setProject(proj)
            }
        },
        data() {
            return {
                nullValueLabel: 'Select a Project',
                selectedProject: '',
                pjs: '',
                showFake: true,
                presetSet: false,
            }
        },
        computed: {
            ...mapGetters({
                loading: 'topicManagement/loading',
                activeLibrary: 'topicManagement/activeLibrary',
                availableProjects: 'topicManagement/availableProjects',
            })
        },
        methods: {
            ...mapMutations({
                setProject: 'topicManagement/activeProject'
            })
        },
        mounted() {
            console.log('Project Select!', this.preloadedValue)
            $('.w').select2({
                theme: "bootstrap"
            })
            console.log('Project Select! Mounted');
        }
    }
</script>

<style scoped>
    .w, .wx {
        width: 100%;
    }
</style>
