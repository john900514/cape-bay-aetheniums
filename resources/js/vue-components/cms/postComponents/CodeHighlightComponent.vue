<template>
    <div class="col-sm-6 col-md-10">
        <vue-code-highlight :language="language">
              <pre>
                  <code>{{ code }}</code>
             </pre>
        </vue-code-highlight>
    </div>
</template>

<script>
    import { component as VueCodeHighlight } from 'vue-code-highlight';

    import "vue-code-highlight/themes/window.css";
    import 'prism-es6/components/prism-markup-templating';
    import 'prism-es6/components/prism-php';

    export default {
        name: "CodeHighlightComponent",
        components: {
            VueCodeHighlight
        },
        props: ['language', 'code', 'theme'],
        watch: {},
        data() {
            return {};
        },
        computed: {
        },
        methods: {
            highlightCode(code) {
                return Prism.highlight(code, Prism.languages[this.language], this.language);
            },
            setTheme(theme) {
                require(`vue-code-highlight/themes/${theme}.css`);
            }
        },
        mounted() {
            this.setTheme(this.theme)
        }
    }
</script>

<style scoped>

</style>
