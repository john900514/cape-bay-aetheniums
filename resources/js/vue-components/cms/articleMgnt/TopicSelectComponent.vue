<template>
    <select class="topic-select" :name="name" v-model="selectedTopic" :disabled="topics === ''">
        <option value="" disabled >{{ nullValueLabel }}</option>
        <option v-if="topics !== ''" v-for="(name, id) in topics" :value="id">{{ name }}</option>
    </select>
</template>

<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex';
    export default {
        name: "TopicSelectComponent",
        props: ['name', 'preloadedValue'],
        watch: {
            topics(topics) {
                let _this = this;
                this.selectedTopic = '';
                if(topics !== '') {
                    this.nullValueLabel = 'Select a Topic';

                    if((this.preloadedValue !== '') && (!this.presetSet)) {
                        this.selectedTopic = this.preloadedValue;
                        this.presetSet = false;
                    }

                    setTimeout(function() {
                        $('.topic-select').select2({
                            theme: "bootstrap"
                        }).on('select2:select', function(e) {
                            _this.selectedTopic = $(this).val();
                        });
                    }, 500)
                }
                else {
                    this.nullValueLabel = 'Requires Project Selection';

                    setTimeout(function() {
                        $('.topic-select').select2({
                            theme: "bootstrap"
                        });
                    }, 100)
                }

            },
            availableTopics(topics) {
                console.log('New topics', topics);
                if(topics === '') {
                    this.topics = topics;
                }
                else {
                    this.topics = topics['select'];
                }
            },
            selectedTopic(topic) {
                this.setActiveTopic(topic);
            }
        },
        data() {
            return {
                nullValueLabel: 'Requires Project Selection', //'Select a Topic',
                selectedTopic: '',
                topics: '',
                presetSet: false,
            }
        },
        computed: {
            ...mapGetters({
                loading: 'articleManagement/loading',
                availableTopics: 'articleManagement/availableTopics',
            })
        },
        methods: {
            ...mapMutations({
                setActiveTopic: 'articleManagement/activeTopic'
            })
        },
        mounted() {
            console.log('Topics Select!', this.preloadedValue)
            $('.topic-select').select2({
                theme: "bootstrap"
            })
            console.log('Topics Select! Mounted');
        }
    }
</script>

<style scoped>
    .topic-select {
        width: 100%;
    }
</style>
