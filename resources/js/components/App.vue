<template>
    <div class="container-fluid">

        <nav class="navbar nav-pills nav-fill">

            <li class="nav-link nav-item align-self-center" :class="[currentPage.includes('/dashboard') ? activeClass : '']">
                <router-link to='/dashboard'>Dashboard</router-link>
            </li>

            <li class="nav-link nav-item align-self-center" :class="[currentPage.includes('/articles') ? activeClass : '']">
                <router-link to="/articles">Articles</router-link>
            </li>

            <li class="nav-link nav-item align-self-center" :class="[currentPage.includes('/article/create') ? activeClass : '']">
                <router-link to="/article/create">Add New Article</router-link>
            </li>

            <li class="nav-link nav-item searchform">
                <SearchForm/>
            </li>
        </nav>

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
                activeClass: 'active',
            }
        },

        watch: {

            $route(to, from) {
                this.title = to.meta.title
            },

            title() {
                document.title = this.title + ' | Chido Designs CMS'
            }
        },
        computed: {
            currentPage() {
                return this.$route.path;
            }
        },
    }
</script>

<style scoped>

    .router-link-active{
        color: white;
    }

    @media only screen and (max-width: 768px) {
        .navbar {
            display: block;
        }

        .searchform {
            margin: 8% 0;
            padding: 0;
        }
    }


</style>
