<template>
    <div class="col-md-12 subsection-container column">
        <div class="col-md-12 subsection-top row bg-light-blue">
            <div class="bar-left row align-items-center"><i :class="toggleViewIcon + ' left-icon'" @click="toggleViewSubSection()"></i></div>
            <div class="bar-center row align-items-center"><h3>{{ subsectionTitle }}</h3></div>
            <div class="row bar-right"><button type="button" class="btn btn-ghost-danger" @click="removeThisSubSection"><i class="la la-trash right-icon"></i></button></div>
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

            <div class="form-group col-md-12" v-if="fieldTypeInput === 'figure-image'">
                <label>Image Url</label>
                <input type="text" v-model="imgUrlInput" class="form-control" :id="'text-img-url-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-12" v-if="fieldTypeInput === 'figure-image'">
                <label>Alt Text (For ADA)</label>
                <input type="text" v-model="altTextInput" class="form-control" :id="'text-alt-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-6" v-if="fieldTypeInput === 'figure-image'">
                <label>Height</label>
                <input type="text" v-model="heightInput" class="form-control" :id="'text-height-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-6" v-if="fieldTypeInput === 'figure-image'">
                <label>Width</label>
                <input type="text" v-model="widthInput" class="form-control" :id="'text-width-'+sectionNo+subsectionNo" />
            </div>

            <div class="form-group col-md-12" v-if="fieldTypeInput === 'card'">
                <label>Background Color</label>
                <input type="text" v-model="bgColorInput" class="form-control" :id="'text-alt-'+sectionNo+subsectionNo" />
            </div>
            <div class="form-group col-md-12" v-if="fieldTypeInput === 'card'">
                <label>Content</label>
                <textarea v-model="textbodyContent" class="form-control" :id="'textbody-'+sectionNo+subsectionNo"></textarea>
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
            switch(type) {
                case 'textbody':
                case 'card':
                    let _this = this;
                    setTimeout(function () {
                        _this.turnOnEasyMde();
                    }, 250);

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
            else {
                payload = {
                    subsection: this.subsectionNo,
                    content: content,
                    bgColor: this.bgColorInput
                }
            }

            this.$emit('properties-set', payload)
        },
        bgColorInput(className) {
            let payload = {
                subsection: this.subsectionNo,
                content: this.textbodyContent,
                bgColor: className
            }

            this.$emit('properties-set', payload)
        },
        imgUrlInput(src) {
            let payload = {
                subsection: this.subsectionNo,
                src: src,
                alt: this.altTextInput,
                height: this.heightInput,
                width: this.widthInput,
            }

            this.$emit('properties-set', payload)
        },
        altTextInput(alt) {
            let payload = {
                subsection: this.subsectionNo,
                src: this.imgUrlInput,
                alt: alt,
                height: this.heightInput,
                width: this.widthInput,
            }

            this.$emit('properties-set', payload)
        },
        heightInput(height) {
            let payload = {
                subsection: this.subsectionNo,
                src: this.imgUrlInput,
                alt: this.altTextInput,
                height: height,
                width: this.widthInput,
            }

            this.$emit('properties-set', payload)
        },
        widthInput(width) {
            let payload = {
                subsection: this.subsectionNo,
                src: this.imgUrlInput,
                alt: this.altTextInput,
                height: this.heightInput,
                width: width,
            }

            this.$emit('properties-set', payload)
        },
    },
    data() {
        return {
            showWholeSubSection: true,
            fieldTypeInput: '',
            textbodyContent: '',
            bgColorInput: '',

            imgUrlInput: '',
            altTextInput: '',
            heightInput: '',
            widthInput: '',
        };
    },
    computed: {
        fieldTypeOptions() {
            return {
                textbody: 'Text/HTML Box',
                'figure-image': 'Figure/Image',
                card: 'Card Widget'
            };
        },
        subsectionTitle() {
            return `SubSection ${ (this.parsedSubSectionNo + 1) }`;
        },
        parsedSubSectionNo() {
            return parseInt(this.subsectionNo);
        },
        toggleViewIcon() {
            if(this.showWholeSubSection) {
                return 'la la-minus-square';
            }

            return 'la la-plus-square';
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

                case 'figure-image':
                    console.log('presetting subsection imgUrlInput '+ this.type);
                    console.log('presetting subsection altTextInput '+ this.type);
                    console.log('presetting subsection heightInput '+ this.type);
                    console.log('presetting subsection widthInput '+ this.type);
                    this.imgUrlInput = this.ssProps.src;
                    this.altTextInput = this.ssProps.alt;
                    this.heightInput = this.ssProps.height;
                    this.widthInput = this.ssProps.width;

                    payload = {
                        subsection: this.subsectionNo,
                        src: this.ssProps.src,
                        alt: this.ssProps.alt,
                        height: this.ssProps.height,
                        width: this.ssProps.width,
                    }

                    this.$emit('properties-set', payload)
                    break;

                case 'card':
                    console.log('presetting subsection textbodyContent '+ this.type);
                    console.log('presetting subsection bgColorInput '+ this.type);
                    this.textbodyContent = this.ssProps.content;
                    this.bgColorInput = this.ssProps.bgColor;

                    payload = {
                        subsection: this.subsectionNo,
                        content: this.ssProps.content,
                        bgColor: this.ssProps.bgColor
                    }
                    this.$emit('properties-set', payload)
                    break;

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
}

@media screen and (max-width: 999px) {}

@media screen and (min-width: 1000px) {}
</style>
