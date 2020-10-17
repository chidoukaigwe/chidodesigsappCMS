<template>
    <div class="container-fluid">

        <ul class="nav justify-content-around mb-5 d-flex flex-row">
            <router-link to='/' class="nav-link nav-item">Dashboard</router-link>
            <router-link to="/articles" class="nav-link nav-item">
                Articles
            </router-link>
             <router-link to="/article/create" class="nav-link nav-item">
                Add New Article
            </router-link>
            <div>
                <SearchForm/>
            </div>
        </ul>

        <router-view></router-view>

    </div>
</template>

<script>
    import SearchForm from '../components/SearchForm';
    export default {
        name: "App",

        props: [
            'user'
        ],

        components: {
            SearchForm
        },

        created() {

            this.title = this.$route.meta.title;

            window.axios.interceptors.request.use(
                (config) => {

                    if(config.method === 'get'){
                        config.url = config.url + '?api_token=' + this.user.api_token
                     }else{

                          config.data =  {

                            ...config.data,
                            api_token: this.user.api_token

                        };

                     }



                    return config

                }
            )
        },

        data: function () {
            return {
                title: '',
            }
        },

        watch: {

            $route(to, from) {
                this.title = to.meta.title
            },

            title() {
                document.title = this.title + ' | Chido Designs CMS'
            }
        }
    }
</script>

<style lang="scoped">

</style>
