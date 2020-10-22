<template>
    <div class="container mb-5 mt-5">
        <h2>Create A New Post</h2>
        <hr>
        <div class="row">
            <div class="col-sm-9">
                <form @submit.prevent="addArticle" class="mt-3">

                    <InputField name="title" label="Add A Post Title *" :errors="errors" placeholder="Title" @update:field="article.title = $event" />

                    <TextareaField name="body" :errors="errors" @update:textarea="article.body = $event"/>

                    <InputField name="excerpt" label="Add A Post Excerpt*" :errors="errors" placeholder="Excerpt" @update:field="article.excerpt = $event" />

                    <button type="submit" class="btn btn-lg btn-primary mt-3">Publish</button>
                </form>
            </div>
            <div class="col-sm-3">
                <!-- <div class="card">
                    <div class="card-body text-center">
                        <a href="" @click="$router.back()"> &larr; Go Back</a>
                    </div>
                </div> -->
            </div>
        </div>
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

                axios.post('/api/article', this.article)
                .then(response => {
                    this.$router.push(response.data.links.self)
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                });
           },

        },

         mounted() {

            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    window.editor = editor;
                } )
                .catch( err => {
                    console.error( err );
                } );

        }
    };
</script>

<style scoped>

    @media only screen and (max-width: 768px) {

        /* Hide Back Button In Mobile View */

        .back-btn{
            display: none;
        }

    }


</style>
