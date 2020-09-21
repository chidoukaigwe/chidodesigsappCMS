
import Vue from 'vue';
import router from './router';
import App from './components/App';

require('./bootstrap');

// window.Vue = require('vue');



// Vue.component('article-component', require('./components/ArticlesComponent.vue').default);
// Vue.component('navbar', require('./components/Navbar.vue').default);



const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
