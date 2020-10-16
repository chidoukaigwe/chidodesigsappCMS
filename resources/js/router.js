import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent';
import ArticleCreate from './views/ArticleCreate';
import ArticleShow from './views/ArticleShow';
import ArticleEdit from './views/ArticleEdit';
import ArticlesIndex from './views/ArticlesIndex';

//  To use a vue plugin, you use Vue.use
Vue.use(VueRouter);

export default new VueRouter({

    routes:[
        { path: '/', component:ExampleComponent},
        { path: '/articles', component:ArticlesIndex},
        { path: '/article/create', component:ArticleCreate},
        { path: '/article/:id', component:ArticleShow},
        { path: '/article/:id/edit', component:ArticleEdit}
    ],
    mode: 'history'

});
