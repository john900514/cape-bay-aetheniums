<template>
    <div class="col-md-12 section-container">
        <div class="col-md-12 section-top row">
            <i :class="toggleViewIcon" @click="toggleViewSection()"></i><h3>{{ sectionTitle }}</h3>
        </div>
        <div class="col-md-12" :class="'section'+sectionNo">
            <div class="form-section col-md-12 row">
                <div class="form-group col-sm-12">
                    <label>Section Title</label>
                    <input type="text" v-model="titleInput" class="form-control"/>
                </div>
            </div>
            <div class="form-group col-sm-12" v-for="(data, idx) in subSections" v-if="(idx in subSections)">
                <collapsible-sub-section
                    :section-no="sectionNo"
                    :subsection-no="idx"
                    :type="data.type"
                    :ss-props="data.properties"
                    @field-type-set="setFieldType"
                    @properties-set="setProperties"
                    @removal="removeSubSection"
                ></collapsible-sub-section>
            </div>

            <div class="trash-btn-section col-md-12">
                <button type="button" class="btn btn-danger" @click="startANewSubSection()"><i class="la la-plus"></i>{{ (amtSubSections > 0) ? 'Another':'' }} New SubSection</button>
                <button type="button" class="btn btn-warning" @click="removeThisSection()"><i class="la la-trash"></i>Delete Section {{ (parsedSectionNo + 1) }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import CollapsibleSubSection from "./CollapsibleSubSectionComponent";
export default {
    name: "CollapsibleSectionComponent",
    components: {
        CollapsibleSubSection
    },
    props: ['sectionNo', 'title', 'lSubsections'],
    watch: {
        showWholeSection(flag) {
            if(flag) {
                $('.section'+this.sectionNo).slideDown();
            }
            else {
                $('.section'+this.sectionNo).slideUp();
            }
        },
        titleInput(text) {
            this.$emit('title-input', { section: this.sectionNo, title: text});
        }

    },
    data() {
        return {
            showWholeSection: true,
            titleInput: '',
            subSectionLbl: 0,
            amtSubSections: 0,
            subSections: {},
        }
    },
    computed: {
        sectionTitle() {
            if(this.titleInput !== '') {
                return `Section - ${this.titleInput}`;
            }

            return `Section ${ (this.parsedSectionNo + 1) }`;
        },
        parsedSectionNo() {
            return parseInt(this.sectionNo);
        },
        toggleViewIcon() {
            if(this.showWholeSection) {
                return 'la la-minus-square';
            }

            return 'la la-plus-square';
        },
    },
    methods: {
        toggleViewSection() {
            this.showWholeSection = !this.showWholeSection;
        },
        startANewSubSection() {
            this.subSections[this.subSectionLbl] = {
                type: '',
                properties: {},
            };
            this.subSectionLbl++;
            this.updateAmtOfSubSections();

            this.$emit('subsection-input', {
                section: this.sectionNo,
                subsections: this.subSections
            })
        },
        setFieldType(args) {
            let ss = this.subSections[args.subsection];
            ss.type = args.type;
            switch(args.type) {
                case 'textbody':
                    ss.properties = {
                        content: ''
                    };
                    break;

                case 'content-tip':
                    ss.properties = {
                        content: '',
                        tipBorderColor: '',
                        icon: '',
                        iconColor: '',
                    };
                    break;

                case 'code-highlight':
                    ss.properties = {
                        code: '',
                        language: '',
                    };
                    break;
            }

            this.subSections[args.subsection] = ss;
            this.updateAmtOfSubSections();
            this.$emit('subsection-input', {
                section: this.sectionNo,
                subsections: this.subSections
            })
        },
        setProperties(args) {
            let ss = this.subSections[args.subsection];

            if((ss !== undefined) && ('type' in ss)) {
                switch(ss.type) {
                    case 'textbody':
                        ss.properties = {
                            content: args.content
                        };
                        break;

                    case 'content-tip':
                        ss.properties = {
                            content: args.content,
                            tipBorderColor: args.tipBorderColor,
                            icon: args.icon,
                            iconColor: args.iconColor,
                        };
                        break;

                    case 'code-highlight':
                        ss.properties = {
                            code: args.code,
                            language: args.language,
                        };
                        break;
                }

                this.subSections[args.subsection] = ss;
                this.updateAmtOfSubSections();
                this.$emit('subsection-input', {
                    section: this.sectionNo,
                    subsections: this.subSections
                })
            }
        },
        removeThisSection() {
            // @todo, throw in a confirm here.
            this.$emit('removal', this.sectionNo);
        },
        removeSubSection(idx) {
            console.log('Looking to remove subsection '+idx, (idx in this.subSections));
            if(idx in this.subSections) {
                delete this.subSections[idx];
                console.log(`SubSection ${idx} is now `, this.subSections[idx])
            }
            else {
                console.log('Already removed. Is something wrong?',this.subSections);
            }

            this.updateAmtOfSubSections();
            this.$emit('subremoval', {
                section: this.sectionNo,
                subsection: idx
            });
            //this.valueObj = this.setValueObj();
        },
        updateAmtOfSubSections() {
            let c = 0
            for(let idx in this.subSections) {
                c++;
            }
            this.amtSubSections = c;
            console.log(`amtSubSections is now ${this.amtSubSections} elements long`, this.sections);
        },
    },
    mounted() {
        if(this.title !== '') {
            this.titleInput = this.title;
        }

        if((this.lSubsections !== []) && (this.lSubsections !== undefined)) {
            console.log('SubSections! ',this.lSubsections);
            this.subSections = this.lSubsections;
            this.updateAmtOfSubSections();
            for(let idx in this.subSections) {
                this.subSectionLbl++;
            }
            this.$emit('subsection-input', {
                section: this.sectionNo,
                subsections: this.subSections
            })
        }
    }

}
</script>

<style scoped>
    @media screen {
        .section-container {
            border: 2px solid #000;
            margin-top: 3%;
            padding-bottom: 3%;
        }

        .section-top {
            margin: 5% 0 2.5%;
        }

        .section-top i {
            cursor: pointer;
            padding-right: 2rem;
            font-size: 2em;
        }
    }

    @media screen and (max-width: 999px) {}

    @media screen and (min-width: 1000px) {}
</style>
