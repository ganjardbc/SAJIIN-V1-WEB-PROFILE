import Web from '../components/layouts/Web.vue';
import Login from '../components/auth/Login.vue';
import Home from '../components/web/Index.vue';
import NotFoundWeb from '../components/web/404.vue';
import HowToOrders from '../components/web/infos/HowToOrders.vue';
import AboutUs from '../components/web/infos/AboutUs.vue';
import Pricing from '../components/web/pricing/Index.vue';
import Features from '../components/web/features/Index.vue';
import ArticlePublic from '../components/web/articles/Index.vue';
import ArticlePublicList from '../components/web/articles/List.vue';

const routes = {
    path: '/',
    component: Web,
    children: [
        // main
        {
            name: 'home',
            path: '/',
            component: Home
        },
        {
            name: 'home2',
            path: '/home',
            component: Home
        },

        // auth
        {
            name: 'login',
            path: '/login',
            component: Login
        },

        // articles
        {
            name: 'articles',
            path: '/articles',
            component: ArticlePublicList
        },
        {
            name: 'article-public',
            path: '/article/:id',
            component: ArticlePublic
        },

        // info
        {
            name: 'how-to-orders',
            path: '/how-to-orders',
            component: HowToOrders
        },
        {
            name: 'pricing',
            path: '/pricing',
            component: Pricing 
        },
        {
            name: 'features',
            path: '/features',
            component: Features
        },
        {
            name: 'about-us',
            path: '/about-us',
            component: AboutUs
        },
        {
            name: '404WEB',
            path: '/not-found',
            component: NotFoundWeb
        }
    ]
}

export default routes