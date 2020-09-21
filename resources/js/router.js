import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent';
import ArticleCreate from './views/ArticleCreate';

//  To use a vue plugin, you use Vue.use
Vue.use(VueRouter);

export default new VueRouter({

    routes:[
        { path: '/', component:ExampleComponent},
        { path: '/article/create', component:ArticleCreate}
    ],
    mode: 'history'

});
