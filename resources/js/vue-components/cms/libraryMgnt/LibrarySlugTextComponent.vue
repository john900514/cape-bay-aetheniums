<template>
    <input type="text" :name="name" v-model="inputText" class="form-control route-slug" :placeholder="placeholder">
</template>

<script>
    import {mapMutations} from "vuex";

    export default {
        name: "LibrarySlugTextComponent",
        props: ['name', 'preloadedValue'],
        watch: {
            inputText(text) {
                this.setSlug(text);
            }
        },
        data() {
            return {
                inputText: '',
                placeholder: 'last leg of listing route',
            };
        },
        computed: {},
        methods: {
            ...mapMutations({
                setSlug: 'libraryManagement/urlSlug'
            })
        },
        mounted() {
            console.log('Doops we are here!')
            if(this.preloadedValue !== '') {
                this.inputText = this.preloadedValue;
                this.setSlug(this.preloadedValue);
            }
        }
    }
</script>

<style scoped>

</style>
