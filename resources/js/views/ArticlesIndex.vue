<template>
  <div class="container">

    <div v-if="loading" class="text-center">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <div v-else class="row">

      <div v-if="articles.length === 0">
        <p>
          No articles yet/
          <router-link to="/article/create">Get Started</router-link>
        </p>
      </div>

      <div v-else class="container">
          <h2 class="mt-3 mb-3 text-primary">Latest Articles</h2>
          <hr>
      </div>

      <div v-for="article in articles" :key="article.title" class="card border-primary mx-3 mt-3 mb-3 col-sm-3">
        <router-link :to="'/article/' + article.data.article_id">
          <div class="card-header bg-transparent border-primary mb-3 text-center">
            <h4 class="card-title text-primary">{{ article.data.title }}</h4>
          </div>
        </router-link>
          <div class="card-body text-primary mb-3">
            <p class="card-text">{{ article.data.excerpt }}</p>
          </div>
          <div class="card-footer bg-transparent border-primary text-primary text-center">{{'Created On: ' + article.data.created_at}}</div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "ArticlesIndex",

  mounted() {
    axios
      .get("/api/articles")
      .then((response) => {
        this.articles = response.data.data;
        this.loading = false;
      })
      .catch((error) => {
        this.loading = false;
        alert("Unable to fetch contacts");
      });
  },

  data: function () {
    return {
      loading: true,
      articles: null,
    };
  },
};
</script>

<style scoped>
</style>
