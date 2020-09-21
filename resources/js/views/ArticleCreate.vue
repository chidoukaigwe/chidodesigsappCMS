<template>
    <div class="container">

        <h2>Create A New Post</h2>
        <hr>
        <form @submit.prevent="addArticle" class="mt-3">

            <div class="form-group mb-3">
                <label for="title">Add A Post Title *</label>
                <input type="text" id="title" class="form-control" placeholder="Title" v-model="article.title">
            </div>

            <label for="body">Add Post Content *</label>
            <div class="form-group mt-3" id="editor">
                <textarea class="form-control" id="body" placeholder="Body" v-model="article.body"></textarea>
            </div>

             <div class="form-group mt-3">
                <label for="excerpt">Add Post Excerpt *</label>
                <textarea class="form-control" id="excerpt" placeholder="Excerpt" v-model="article.excerpt"></textarea>
            </div>

            <button type="submit" class="btn btn-lg btn-primary mt-3">Publish</button>
        </form>
    </div>

</template>

<script>
    //  Bring in CKEditor
    const ClassicEditor = require( '@ckeditor/ckeditor5-build-classic');

    export default {
        name: "ArticleCreate",

        data() {
            return{
                 article: {
                    id: '',
                    title: '',
                    excerpt:'',
                    body: ''
                },
                article_id: '',
            }
        },

        methods: {

            addArticle: function () {
                this.article.body = editor.getData();
                axios.post('/api/article', this.article)
                .then(response => {

                })
                .catch(errors => {

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

<style lang="scoped">

</style>
