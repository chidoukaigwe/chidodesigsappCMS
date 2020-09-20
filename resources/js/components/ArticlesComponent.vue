<template>
    <div>
        <h2 class="mt-3">Articles</h2>

        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="article.title">
            </div>
              <div class="form-group" id="editor">
                <textarea class="form-control" placeholder="Body" v-model="article.body" ></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save</button>
        </form>

        <hr>

        <nav aria-label="Page navigation example">

            <ul class="pagination">

                <li v-bind:class="[{disabled: !pagination.prev_page_url}]"  class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}} </a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]"  class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)" >Next</a></li>

            </ul>

        </nav>

        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3> {{ article.title}}</h3>
            <div v-html="article.body"> {{article.body}} </div>
            <hr>
            <button @click="editArticle(article)" class="btn btn-warning mb-1">Edit</button>
            <button @click="deleteArticle(article.id)" class="btn btn-danger">Delete</button>
        </div>

    </div>
</template>

<script>
    const ClassicEditor = require( '@ckeditor/ckeditor5-build-classic' );

    export default {
        data() {
            return{
                articles: [],
                article:{
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination: {},
                edit: false,
            }
        },
        created() {
            this.fetchArticles();

        },

        methods: {

            fetchArticles(page_url) {
                let vm = this;
                page_url = page_url || '/api/articles'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.articles = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                   .catch(err => console.log(err));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            deleteArticle(id) {
              if (confirm('Are You Sure?')) {
                  fetch(`api/article/${id}`, {
                      method: 'delete'
                  })
                  .then(res => res.json())
                  .then(data => {
                      alert('Article Removed');
                      this.fetchArticles();
                  })
                  .catch(err => console.log(err));
              }
            },
           addArticle() {
               //   Add An Article
               if(this.edit === false) {

                   //  Grab Article Body From Editor
                    this.article.body = editor.getData();
                   fetch('api/article', {
                       method: 'post',
                       body: JSON.stringify(this.article),
                       headers:{
                           'content-type': 'application/json'
                       }
                   })
                   .then(res => res.json())
                   .then(data => {
                       this.article.title = '';
                       this.article.body = editor.setData('');
                       alert('Article Added');
                       this.fetchArticles();
                   })
                   .catch(err => console.log(err));
               } else{
                    // Edit Article
                   this.article.body = editor.getData();
                   fetch('api/article', {
                       method: 'put',
                       body: JSON.stringify(this.article),
                       headers:{
                           'content-type': 'application/json'
                       }
                   })
                   .then(res => res.json())
                   .then(data => {
                       this.article.title = '';
                       this.article.body = editor.setData('');
                       alert('Article Updated');
                       this.fetchArticles();
                   })
                   .catch(err => console.log(err));
               }
           },
           editArticle(article) {
               this.edit = true;
               this.article.id = article.id;
               this.article.article_id = article.id;
               this.article.title = article.title;
               this.article.body = editor.setData(article.body);
           }
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
