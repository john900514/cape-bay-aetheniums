<template>
    <input type="text" :name="name" v-model="inputText" class="form-control route-slug" :placeholder="placeholder">
</template>

<script>
import { mapMutations } from 'vuex';

export default {
    name: "ProjectSlugTextComponent",
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
            setSlug: 'projectManagement/urlSlug'
        })
    },
    mounted() {
        if((this.preloadedValue !== '') || this.preloadedValue !== undefined){
            this.inputText = this.preloadedValue;
        }
        console.log('Doops we are here!')
    }
}
</script>

<style scoped>

</style>
