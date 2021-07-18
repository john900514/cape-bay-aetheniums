<template>
    <input type="text" :name="name" v-model="inputText" class="form-control listing-route" readonly :placeholder="placeholder">
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';
export default {
    name: "ListingRouteTextComponent",
    props: ['name', 'preloadedValue'],
    watch: {

    },
    data() {
        return {
            urlPartOfTheText: '/library/libraries',
            //inputText: '',
            placeholder: 'url will be auto-gend\'d here',
        }
    },
    computed: {
        inputText() {
            if(this.urlSlug === '') {
                return this.urlPartOfTheText
            }

            return this.urlPartOfTheText + '/'+this.urlSlug;
        },
        ...mapGetters({
            urlSlug: 'libraryManagement/urlSlug',
        })
    },
    methods: {},
    mounted() {
        console.log('Listing Route', this.preloadedValue);
        if(this.preloadedValue !== '') {
            //this.urlPartOfTheText = this.preloadedValue;
        }
    }
}
</script>

<style scoped>

</style>
