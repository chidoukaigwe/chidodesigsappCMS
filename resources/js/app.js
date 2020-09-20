

require('./bootstrap');

window.Vue = require('vue');



Vue.component('article-component', require('./components/ArticlesComponent.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);



const app = new Vue({
    el: '#app',
});
