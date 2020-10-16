<template>
    <div>
        <input class="form-control mr-sm-2" type="text" placeholder="Search..." aria-label="Search" id="searchTerm" v-model="searchTerm" @input="search">
    </div>

</template>

<script>
export default {
    name: "SearchForm",

    data: function () {
        return {
            searchTerm: ''
        }
    },

    methods: {
        search: function () {
            axios.post('/api/search', {searchTerm: this.searchTerm})
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {

                });
        }
    }
}
</script>

<style scoped>

</style>
