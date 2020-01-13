require('es7-object-polyfill');
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import {
    Datetime
} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.component('datetime', Datetime);
//Vue.use(Datetime)

Vue.config.productionTip = false;

Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.http.headers.common['Accept'] = 'application/json';
Vue.http.headers.common['Content-Type'] = 'application/json';



import StoreCommand from "./components/commands/StoreCommand";
const routes = [{
    path: '/commands/create',
    component: StoreCommand
}];

const router = new VueRouter({
    mode: 'history',
    routes: routes, // short for `routes: routes`
});

Vue.mixin({
    methods: {
        goback: function () {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
        }
    }
});

const vm = new Vue({
    router,
    el: '#app',
});

window.vm = vm;
