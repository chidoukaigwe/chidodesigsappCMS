<template>
    <div class="container-fluid">

        <ul class="nav justify-content-center mb-3">
            <router-link to="/" class="nav-link nav-item active">
                Articles
            </router-link>
             <router-link to="/article/create" class="nav-link nav-item">
                Add New Article
            </router-link>
        </ul>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "App",

        props: [
            'user'
        ],

        mounted() {
            window.axios.interceptors.request.use(
                (config) => {

                    config.data =  {

                        ...config.data,
                        api_token: this.user.api_token

                    };

                    return config

                }
            )
        }
    }
</script>

<style lang="scoped">

</style>
