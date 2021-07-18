<template>
    <select class="doodoo" :name="name" v-model="selectedPost">
        <option value="" disabled>{{ nullValueLabel }}</option>
        <option v-if="posts !== ''" v-for="(name, slug) in posts" :value="slug">{{ name }}</option>
    </select>
</template>

<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex';
    export default {
        name: "ArticleAssignSelectComponent",
        props: ['name', 'token', 'preloadedValue'],
        watch: {
            availablePosts(posts) {
                let _this = this;
                this.posts = posts;
                this.nullValueLabel = 'Select a Post to Assign';


                setTimeout(function () {
                    $('.doodoo').select2({
                        theme: "bootstrap"
                    }).on('select2:select', function(e) {
                        _this.selectedPost = $(this).val();
                    });
                }, 500)
            },
            selectedPost(post) {

            }
        },
        data() {
            return {
                nullValueLabel: 'Loading Assignable Pages & Posts..',
                selectedPost: '',
                posts: ''
            }
        },
        computed: {
            ...mapGetters({
                availablePosts: 'pageManagement/pageOptions'
            }),
        },
        methods: {
            ...mapMutations({
                setToken: 'pageManagement/token',
            }),
            ...mapActions({
                getPosts: 'pageManagement/getPagesMadeForArticles'
            })
        },
        mounted() {
            console.log('Article Assign!', this.token);
            this.setToken(this.token);
            this.getPosts();
            $('.doodoo').select2({
                theme: "bootstrap"
            })
            console.log('Article Assign! Mounted', this.preloadedValue);

            if((this.preloadedValue !== '')) {// && (!this.presetSet)) {
                this.selectedPost = this.preloadedValue;
                //this.presetSet = false;
            }
        }
    }
</script>

<style scoped>
    .doodoo {
        width: 100%;
    }
</style>
