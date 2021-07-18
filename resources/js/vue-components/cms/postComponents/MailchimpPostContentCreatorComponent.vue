<template>
    <div class="col-md-12 row creator-container">
        <div class="initial-btn-section col-md-12">
            <button type="button" class="btn btn-danger" @click="startANewSection()"><i class="la la-plus"></i>{{ (amtSections > 0) ? 'Another':'' }} New Section</button>
        </div>

        <div class="sections-section col-md-12" v-if="amtSections > 0">
            <div class="section col-md-12" v-for="(data, idx) in sections">
                <div v-show="idx in sections">
                    <collapsible-section
                        :section-no="idx"
                        :title="data.title"
                        :l-subsections="data.subsections"
                        @title-input="updateSectionTitle"
                        @subsection-input="updateSubSection"
                        @removal="removeSection"
                    ></collapsible-section>
                </div>
            </div>
        </div>
        <!-- This is the some of all inputs that will get passed to the backend as a json string literal-->
        <input type="hidden" :name="name" v-model="valueObj" />
    </div>
</template>

<script>
    import CollapsibleSection from "./subComponents/mailchimp/CollapsibleSectionComponent";

    export default {
        name: "MailchimpPostContentCreatorComponent",
        components: {
            CollapsibleSection
        },
        props: ['name', 'preloadedValue'],
        watch: {},
        data() {
            return {
                sectionLbl: 0,
                amtSections: 0,
                sections: {},
                valueObj: {},
            };
        },
        computed: {},
        methods: {
            startANewSection() {
                this.sections[this.sectionLbl] = {
                    title: '',
                    subsections: []
                };

                this.sectionLbl++;
                this.updateAmtOfSections();
                this.valueObj = this.setValueObj();
            },
            updateAmtOfSections() {
                let c = 0
                for(let idx in this.sections) {
                    c++;
                }
                this.amtSections = c;
                console.log(`amtSections is now ${this.amtSections} elements long`, this.sections);
            },
            setValueObj() {
                let r = JSON.stringify(this.sections);

                return r;
            },
            removeSection(idx) {
                console.log('Looking to remove section '+idx, (idx in this.sections));
                if(idx in this.sections) {
                    delete this.sections[idx];
                    console.log(this.sections[idx])
                }
                else {
                    console.log('Already removed. Is something wrong?',this.sections);
                }

                this.updateAmtOfSections();
                this.valueObj = this.setValueObj();
            },
            updateSectionTitle(args) {
                if('section' in args) {
                    let section = args.section;
                    this.sections[section].title = args.title;
                }

                console.log(args,this.sections);
                this.valueObj = this.setValueObj();
            },
            updateSubSection(args) {
                if('section' in args) {
                    let section = args.section;
                    this.sections[section].subsections = args.subsections;
                }

                console.log(args,this.sections);
                this.valueObj = this.setValueObj();
            },
        },
        mounted() {
            if(this.preloadedValue !== '') {
                this.sections = this.preloadedValue;
                this.updateAmtOfSections();

                for(let x in this.sections) {
                    this.sectionLbl++;
                }
                console.log(this.preloadedValue)
            }
        }
    }
</script>

<style scoped>
    @media screen {
        .creator-container {
            margin: 3% 0;
        }
    }

    @media screen and (max-width: 999px) {}

    @media screen and (min-width: 1000px) {}
</style>
