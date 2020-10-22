import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent';
import ArticleCreate from './views/ArticleCreate';
import ArticleShow from './views/ArticleShow';
import ArticleEdit from './views/ArticleEdit';
import ArticlesIndex from './views/ArticlesIndex';
import Dashboard from './views/Dashboard';

//  To use a vue plugin, you use Vue.use
Vue.use(VueRouter);

export default new VueRouter({

    routes: [{
            path: '/dashboard',
            component: Dashboard,
            meta: { title: 'Welcome' },
        },

        {
            path: '/articles',
            component: ArticlesIndex,
            meta: { title: 'Articles' },
        },

        {
            path: '/article/create',
            component: ArticleCreate,
            meta: { title: 'Add New Article' },
        },

        {
            path: '/article/:id',
            component: ArticleShow,
            meta: { title: 'Details For Article' },
        },

        {
            path: '/article/:id/edit',
            component: ArticleEdit,
            meta: { title: 'Edit Article' },
        }
    ],
    mode: 'history'

});