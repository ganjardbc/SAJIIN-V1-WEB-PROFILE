require('./bootstrap');
window.Vue = require('vue');
 
import App from './components/App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import VueCookies from 'vue-cookies';
import Vuex from 'vuex';
import axios from 'axios';
import {routes} from './routes';
import store from './store';
import SmartTable from 'vuejs-smart-table';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en';
import 'element-ui/lib/theme-chalk/index.css';
import 'element-ui/lib/theme-chalk/base.css';
import 'element-ui/lib/theme-chalk/display.css';
import "../icons/fontawesome/css/all.min.css";
import "../animations/app.css";
import Vue from 'vue';
import VueCarousel from 'vue-carousel';
import VueHtmlToPaper from 'vue-html-to-paper';
import * as VueGoogleMaps from 'vue2-google-maps';
import VueGtag from "vue-gtag";
import VueAnimateOnScroll from 'vue-animate-onscroll';
import VueYouTubeEmbed from 'vue-youtube-embed';
import VueQrcodeReader from "vue-qrcode-reader";
import VueMeta from 'vue-meta';

const api = 'http://localhost:8000';
// const api = 'https://undangabi.com';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = api;

const moment = require('moment');
require('moment/locale/id');

Vue.use(VueMeta, {
    refreshOnceOnNavigation: true
});
Vue.use(VueQrcodeReader);
Vue.use(VueYouTubeEmbed);
Vue.use(ElementUI, { locale });
Vue.use(VueAnimateOnScroll);
Vue.use(VueGtag, {
    config: { id: "G-EEDXRP7WP4" }
});
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyBnNII1sSFEROSdhElSg6e994uUv2zgUmA',
        region: 'ID',
        language: 'ID',
    },
});
Vue.use(require('vue-moment'), { moment });
Vue.use(VueCarousel);
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueCookies);
Vue.use(SmartTable);

const options = {
    styles: [
        `${api}/css/app.css`
    ],
    timeout: 1000, 
    autoClose: true, 
}
  
Vue.use(VueHtmlToPaper, options);

Vue.$cookies.config('7d');
Vue.prototype.appName = 'Saji-in';
Vue.prototype.initUrl = window.location.protocol+'//'+window.location.host;
Vue.prototype.apiURL = api;
Vue.prototype.adminImageThumbnailUrl = api + '/contents/users/thumbnails/';
Vue.prototype.adminImageCoverUrl = api + '/contents/users/covers/';
Vue.prototype.brideImageThumbnailUrl = api + '/contents/brides/thumbnails/';
Vue.prototype.brideImageCoverUrl = api + '/contents/brides/covers/';
Vue.prototype.galleryImageThumbnailUrl = api + '/contents/galleries/thumbnails/';
Vue.prototype.galleryImageCoverUrl = api + '/contents/galleries/covers/';
Vue.prototype.invitationImageThumbnailUrl = api + '/contents/invitations/thumbnails/';
Vue.prototype.invitationImageCoverUrl = api + '/contents/invitations/covers/';
Vue.prototype.themeImageThumbnailUrl = api + '/contents/themes/thumbnails/';
Vue.prototype.themeImageCoverUrl = api + '/contents/themes/covers/';
Vue.prototype.parentImageThumbnailUrl = api + '/contents/parents/thumbnails/';
Vue.prototype.parentImageCoverUrl = api + '/contents/parents/covers/';
Vue.prototype.eventImageThumbnailUrl = api + '/contents/events/thumbnails/';
Vue.prototype.eventImageCoverUrl = api + '/contents/events/covers/';
Vue.prototype.guestImageThumbnailUrl = api + '/contents/guests/thumbnails/';
Vue.prototype.guestImageCoverUrl = api + '/contents/guests/covers/';
Vue.prototype.commentImageThumbnailUrl = api + '/contents/comments/thumbnails/';
Vue.prototype.commentImageCoverUrl = api + '/contents/comments/covers/';
Vue.prototype.specialthankImageThumbnailUrl = api + '/contents/specialthanks/thumbnails/';
Vue.prototype.specialthankImageCoverUrl = api + '/contents/specialthanks/covers/';
Vue.prototype.articleImageThumbnailUrl = api + '/contents/articles/thumbnails/';
Vue.prototype.articleImageCoverUrl = api + '/contents/articles/covers/';
Vue.prototype.benefitImageThumbnailUrl = api + '/contents/benefits/thumbnails/';
Vue.prototype.benefitImageCoverUrl = api + '/contents/benefits/covers/';
Vue.prototype.feedbackImageThumbnailUrl = api + '/contents/feedbacks/thumbnails/';
Vue.prototype.feedbackImageCoverUrl = api + '/contents/feedbacks/covers/';
Vue.prototype.songImageThumbnailUrl = api + '/contents/songs/thumbnails/';
Vue.prototype.songImageCoverUrl = api + '/contents/songs/covers/';
Vue.prototype.songUrl = api + '/contents/songs/';

const token = Vue.$cookies.get('token'); 
const router = new VueRouter({
    mode: 'history',
    routes: routes,
    base: process.env.BASE_URL,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return {x: 0, y: 0}
        }
    }
});
 
const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App),
});

store.dispatch('auth/me', token).then(() => {
    app
});