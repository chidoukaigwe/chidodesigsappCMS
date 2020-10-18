<template>

    <div class="container">

       <div v-if="loading" class="text-center">
           <div class="spinner-border" role="status">
             <span class="sr-only">Loading...</span>
            </div>
       </div>

       <div v-else>

            <div>
                <a href="#" type="button" class="btn btn-lg btn-info mb-3 text-white" @click="$router.back()"> &larr; Back</a>
            </div>

            <div class="card">

            <div class="card-header mb-3 text-center">
                <h3>{{article.title}}</h3>
            </div>

            <div class="card mt-3 mb-3">
                <div class="card-header">
                    The Post
                </div>
                <div class="card-body" v-html="article.body">{{article.body}}</div>
            </div>

            <div class="card mt-3 mb-3">
                <div class="card-header">
                    The Excerpt
                </div>
                <p class="card-body" v-html="article.excerpt">{{article.excerpt}}</p>
            </div>

            <div class="card mt-3 mb-3">
                <div class="card-header">
                   Meta Data
                </div>
                <div class="card-body">
                    <p> {{ 'Created On: ' + article.created_at}}</p>
                    <p> {{ 'Last Updated: ' + article.last_updated}} </p>
                </div>
            </div>

            <div class="card-header">

                <router-link :to="'/article/' +  article.article_id + '/edit'" class="btn btn-info mb-1 mt-2 rounded text-white">Edit</router-link>
                <a href="#" class="btn btn-danger mb-1 mt-2 rounded" @click="modal = ! modal" data-toggle="modal" data-target=".bd-example-modal-sm">Delete</a>

                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <p class="p-3">Are you sure you want to delete this article?</p>
                            <div class="card-body text-center">
                                <button type="button" class="btn btn-info text-white" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" @click="destroy" data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

       </div>

    </div>

</template>

<script>
    export default {

        name: "ArticleShow",

        mounted() {
            axios.get('/api/article/' + this.$route.params.id)
                .then(response => {
                    this.article = response.data.data;
                    this.loading = false
                })
                .catch(error => {
                    this.loading = false

                    if(error.response.status === 404) {

                        this.$router.push('/articles');

                    }

                });
        },

        data: function () {
            return {
                loading: true,
                article: null,
                modal: false
            }
        },

        methods: {
            destroy: function () {
                axios.delete('/api/article/' + this.$route.params.id)
                .then(response => {
                    this.$router.push('/articles');
                })
                .catch(error => {
                    alert('Internal Error. Unable to delete contact.');
                })
            }
        }

    }
</script>

<style scoped>

</style>
