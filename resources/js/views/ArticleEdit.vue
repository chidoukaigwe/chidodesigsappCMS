<template>
    <div class="container">

        <!-- <div>
            <a href="#" type="button" class="btn btn-sm btn-danger mb-3 text-white" @click="$router.back()"> &larr; Back</a>
        </div> -->

        <h2>{{'Edit: ' + article.title}}</h2>
        <hr>
        <form @submit.prevent="addArticle" class="mt-3">

            <InputField name="title" label="Edit Post Title" :errors="errors" placeholder="Title" @update:field="article.title = $event" :data="article.title" />

            <TextareaField name="body" :errors="errors" @update:textarea="article.body = $event" :data="article.body"/>

            <InputField name="excerpt" label="Edit Post Excerpt" :errors="errors" placeholder="Excerpt" @update:field="article.excerpt = $event" :data="article.excerpt"/>

            <button type="submit" class="btn btn-lg btn-primary mt-3">Update Post</button>
        </form>
    </div>

</template>

<script>
    //  Bring in CKEditor
    const ClassicEditor = require( '@ckeditor/ckeditor5-build-classic');

    import InputField from '../components/InputField';
    import TextareaField from '../components/TextareaField';

    export default {
        name: "ArticleCreate",

        components:{
            InputField,
            TextareaField
        },


         mounted() {

            axios.get('/api/article/' + this.$route.params.id)
                .then(response => {
                    this.article.body = editor.setData(response.data.data.body)
                    this.article = response.data.data;
                    this.loading = false
                })
                .catch(error => {
                    this.loading = false

                    if(error.response.status === 404) {

                        this.$router.push('/articles');

                    }

                });

             ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    window.editor = editor;
                } )
                .catch( err => {
                    console.error( err );
                } );

        },

        data() {
            return{
                 article: {
                    id: '',
                    title: '',
                    body: '',
                    excerpt:'',
                },
                article_id: '',
                errors: null,
            }
        },


        methods: {

            addArticle: function () {

                this.article.body = editor.getData();

                axios.patch('/api/article/' + this.$route.params.id, this.article)
                .then(response => {
                    this.$router.push(response.data.links.self)
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                });
           },

        },


    };
</script>

<style lang="scoped">

</style>
