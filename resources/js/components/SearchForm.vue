<template>
    <div>

        <input class="form-control mr-sm-2" type="text" placeholder="Search Articles..." aria-label="Search" id="searchTerm" v-model="searchTerm" @input="search" @focus="focus = true">


         <div v-if="focus">
            <div class="card" style="width: 18rem;">
                <ul class="list-group list-group-flush" v-if="results == 0">
                   <li class="list-group-item"> No results found for '{{searchTerm}}'</li>
                </ul>
                <ul class="list-group list-group-flush" v-for="result in results" v-bind:key="result.id">
                    <router-link :to="result.links.self">
                         <li class="list-group-item">{{result.data.title}}</li>
                    </router-link>
                </ul>
            </div>
            <button class="btn btn-danger btn-block" @click="focus = false; searchTerm = '';">Canel</button>
        </div>

    </div>
</template>

<script>
import _ from 'lodash';

export default {
    name: "SearchForm",

    data: function () {
        return {
            searchTerm: '',
            focus: false,
            results: [],
        }
    },

    methods: {
        search: _.debounce(function(e) {

            if (this.searchTerm.length < 3) {

                return;

            }

             axios.post('/api/search', {searchTerm: this.searchTerm})
                .then(response => {
                    this.results = response.data.data;
                })
                .catch(error => {
                    console.log(error.response)
                });
        }, 300)
    }
}
</script>

<style scoped>

</style>
