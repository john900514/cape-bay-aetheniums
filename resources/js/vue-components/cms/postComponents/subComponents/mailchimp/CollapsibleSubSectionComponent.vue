<template>
    <div class="col-md-12 subsection-container column">
        <div class="col-md-12 subsection-top row bg-warning">
            <div class="bar-left row align-items-center text-black"><i :class="toggleViewIcon + ' left-icon'" @click="toggleViewSubSection()"></i></div>
            <div class="bar-center row align-items-center text-black"><h3>{{ subsectionTitle }}</h3></div>
            <div class="row bar-right"><button type="button" class="btn btn-ghost-danger" @click="removeThisSubSection()"><i class="la la-trash right-icon"></i></button></div>
        </div>
        <div class="col-md-12 row" :class="'subsection'+sectionNo+subsectionNo">
            <div class="form-group col-md-12">
                <label>Type</label>
                <select :class="'col-md-12 field-type-'+sectionNo+subsectionNo" v-model="fieldTypeInput">
                    <option value="" disabled>Select a Field Type</option>
                    <option v-for="(fieldName, id) in fieldTypeOptions" :value="id">{{ fieldName }}</option>
                </select>
            </div>

            <div class="form-group col-md-12" v-if="fieldTypeInput === 'textbody'">
                <label>Content</label>
                <textarea v-model="textbodyContent" class="form-control" :id="'textbody-'+sectionNo+subsectionNo"></textarea>
            </div>

            <div class="form-group col-md-12" v-if="fieldTypeInput === 'content-tip'">
                <label>Icon</label>
                <input type="text" v-model="icon" class="form-control" :id="'text-icon-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-12" v-if="fieldTypeInput === 'content-tip'">
                <label>Icon Color</label>
                <input type="text" v-model="iconColor" class="form-control" :id="'text-icon-color-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-12" v-if="fieldTypeInput === 'content-tip'">
                <label>Tip Border Color</label>
                <input type="text" v-model="tipBorderColor" class="form-control" :id="'text-tb-color-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-12" v-if="fieldTypeInput === 'content-tip'">
                <label>Content</label>
                <textarea v-model="textbodyContent" class="form-control" :id="'textbody-'+sectionNo+subsectionNo"></textarea>
            </div>

            <div class="form-group col-md-12" v-if="fieldTypeInput === 'code-highlight'">
                <label>Code Language</label>
                <select :class="'col-md-12 code-highlight-'+sectionNo+subsectionNo" v-model="codeHighlightInput">
                    <option value="" disabled>Select a Coding Language</option>
                    <option v-for="(langName, langSlug) in languageOptions" :value="langSlug">{{ langName }}</option>
                </select>
            </div>
            <div class="form-group col-md-12" v-if="fieldTypeInput === 'code-highlight'">
                <label>Code Snippet</label>
                <textarea v-model="codeSnippetContent" class="form-control" :id="'textbody-'+sectionNo+subsectionNo"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CollapsibleSubSectionComponent",
    components: {},
    props: ['sectionNo','subsectionNo', 'type', 'ssProps'],
    watch: {
        showWholeSubSection(flag) {
            if(flag) {
                $('.subsection'+this.sectionNo+this.subsectionNo).slideDown();
            }
            else {
                $('.subsection'+this.sectionNo+this.subsectionNo).slideUp();
            }
        },
        fieldTypeInput(type) {
            let _this = this;
            switch(type) {
                case 'textbody':
                case 'content-tip':

                    setTimeout(function () {
                        _this.turnOnEasyMde();
                    }, 250);
                   break;

               case 'code-highlight':
                   setTimeout(function () {
                       $('.code-highlight-'+_this.sectionNo+_this.subsectionNo).select2({
                           theme: "bootstrap"
                       }).on('select2:select', function(e) {
                           _this.codeHighlightInput = $(this).val();
                       });

                       _this.turnOnEasyMde();
                   }, 100);
               break;


            }

            // let the CollapsibleSectionComponent know some values were changeds
            this.$emit('field-type-set', { type: type, subsection: this.subsectionNo});
        },
        textbodyContent(content) {
            let payload = {};
            if(this.fieldTypeInput === 'textbody') {
                payload = {
                    subsection: this.subsectionNo,
                    content: content
                }
            }
            else if(this.fieldTypeInput === 'content-tip') {
                payload = {
                    subsection: this.subsectionNo,
                    content: content,
                    tipBorderColor: this.tipBorderColor,
                    icon: this.icon,
                    iconColor: this.iconColor,
                }
            }
            else if(this.fieldTypeInput === 'code-highlight') {
                payload = {
                    subsection: this.subsectionNo,
                    code: content,
                    language: this.codeHighlightInput
                }
            }

            this.$emit('properties-set', payload)
        },
        codeSnippetContent(content) {
            let payload = {
                subsection: this.subsectionNo,
                code: content,
                language: this.codeHighlightInput
            }

            console.log('codeSnippetContent - just look at the screen');
            this.$emit('properties-set', payload)
        },
        icon(icon) {
            let payload = {
                subsection: this.subsectionNo,
                content: this.textbodyContent,
                tipBorderColor: this.tipBorderColor,
                icon: icon,
                iconColor: this.iconColor,
            }

            this.$emit('properties-set', payload)
        },
        iconColor(color) {
            let payload = {
                subsection: this.subsectionNo,
                content: this.textbodyContent,
                tipBorderColor: this.tipBorderColor,
                icon: this.icon,
                iconColor: color,
            }

            this.$emit('properties-set', payload)
        },
        tipBorderColor(color) {
            let payload = {
                subsection: this.subsectionNo,
                content: this.textbodyContent,
                tipBorderColor: color,
                icon: this.icon,
                iconColor: this.iconColor,
            }

            this.$emit('properties-set', payload)
        },
        codeHighlightInput(input) {
            let payload = {
                subsection: this.subsectionNo,
                code: this.codeSnippetContent,
                language: input
            }

            console.log('codeHighlightInput - just look at the screen');
            this.$emit('properties-set', payload)
        },
    },
    data() {
        return {
            showWholeSubSection: true,
            fieldTypeInput: '',
            codeHighlightInput: '',
            textbodyContent: '',
            codeSnippetContent: '',
            icon: 'la la-automobile',
            iconColor: 'text-success',
            tipBorderColor: 'border-success'
        };
    },
    computed: {
        fieldTypeOptions() {
            return {
                textbody: 'Text/HTML Box',
                //ul: 'Unordered List',
                //ol: 'Ordered List',
                'content-tip': 'Content Tip',
                'code-highlight': 'Code Highlight',
            };
        },
        languageOptions() {
            return {
                php: 'PHP',
                json: 'JSON',
                html: 'HTML',
                css: 'CSS',
                javascript: 'JavaScript',
                sql: 'Generic Structured Querying Languages (SQL)',
                url: 'URL',
                bash: 'Bash Script',
                regex: 'Regular Expressions',
                liquid: 'Liquid (Shopify)',
                objectivec: 'Objective-C',
                kotlin: 'Kotlin',
                graphql: 'GraphQL (Lame)',
                ruby: 'Ruby'
            }
            code-highlight
        },
        toggleViewIcon() {
            if(this.showWholeSubSection) {
                return 'la la-minus-square';
            }

            return 'la la-plus-square';
        },
        subsectionTitle() {
            return `SubSection ${ (this.parsedSubSectionNo + 1) }`;
        },
        parsedSubSectionNo() {
            return parseInt(this.subsectionNo);
        },
    },
    methods: {
        turnOnEasyMde() {
            let _this = this;
            let elementId = `textbody-${this.sectionNo}${this.subsectionNo}`;

            let configurationObject = {
                element:document.getElementById(elementId),
            };

            configurationObject = Object.assign(configurationObject, {}, {});

            let easyMDE = new EasyMDE(configurationObject);

            easyMDE.options.minHeight = easyMDE.options.minHeight || "300px";
            easyMDE.codemirror.getScrollerElement().style.minHeight = easyMDE.options.minHeight;

            // update the original textarea on keypress
            easyMDE.codemirror.on("change", function(){
                //configurationObject.element.val(easyMDE.value());
                _this.textbodyContent = easyMDE.value();
            });
        },
        toggleViewSubSection() {
            this.showWholeSubSection = !this.showWholeSubSection;
        },
        removeThisSubSection() {
            this.$emit('removal', this.subsectionNo);
        }
    },
    mounted() {
        let _this = this;
        if((this.type !== '') && (this.type !== undefined)) {
            console.log('presetting subsection type '+ this.type);
            this.fieldTypeInput = this.type;
            this.$emit('field-type-set', { type: this.type, subsection: this.subsectionNo});
        }

        if((this.ssProps !== undefined)) {
            let payload = {};
            switch(this.fieldTypeInput) {
                case 'textbody':
                    console.log('presetting subsection textbodyContent '+ this.type);
                    this.textbodyContent = this.ssProps.content;
                    payload = {
                        subsection: this.subsectionNo,
                        content: this.ssProps.content
                    }
                    this.$emit('properties-set', payload)
                    break;

                case 'content-tip':
                    console.log('presetting subsection textbodyContent '+ this.type);
                    this.textbodyContent = this.ssProps.content;
                    this.tipBorderColor = this.ssProps.tipBorderColor;
                    this.icon = this.ssProps.icon;
                    this.iconColor = this.ssProps.iconColor;
                    payload = {
                        subsection: this.subsectionNo,
                        content: this.ssProps.content,
                        tipBorderColor: this.ssProps.tipBorderColor,
                        icon: this.ssProps.icon,
                        iconColor: this.ssProps.iconColor,
                    }
                    this.$emit('properties-set', payload)
                    break;

                case 'code-highlight':
                    console.log('presetting subsection codeSnippetContent '+ this.type);
                    this.codeHighlightInput = this.ssProps.language;
                    this.codeSnippetContent = this.ssProps.code;
                    payload = {
                        subsection: this.subsectionNo,
                        code: this.ssProps.code,
                        language: this.ssProps.language
                    }
                    this.$emit('properties-set', payload)
            }
        }
        console.log('subsection properties', [this.ssProps]);

        setTimeout(function () {
            $('.field-type-'+_this.sectionNo+_this.subsectionNo).select2({
                theme: "bootstrap"
            }).on('select2:select', function(e) {
                _this.fieldTypeInput = $(this).val();
            });
        }, 100);
    }
}
</script>

<style scoped>
@media screen {
    .subsection-container {
        border: 1px solid #666;
        margin-top: 1.5%;
        padding-bottom: 1.5%;
    }

    .subsection-top {
        margin: 2.5% 0 1.25%;
    }

    .subsection-top .left-icon {
        cursor: pointer;
        padding-right: 1rem;
        font-size: 1.25em;
    }

    .subsection-top .right-icon {
        cursor: pointer;
        font-size: 1.25em;
    }

    .subsection-top h3 {
        font-size: 1.25em;
        margin-top: 2% !important;
    }

    .bar-left {
        width: 15%;
    }

    .bar-center {
        width: 70%;
    }

    .bar-right {
        width: 20%;
        justify-content: flex-end;
    }

    .editor-toolbar {
        border: 1px solid #ddd;
        border-bottom: none;
    }

    .text-black {
        color: #000;
    }
}

@media screen and (max-width: 999px) {}

@media screen and (min-width: 1000px) {}
</style>
