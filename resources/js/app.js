require('es7-object-polyfill');
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import vSelect from 'vue-select';
import Datetime from 'vue-datetime';
import {
    library
} from '@fortawesome/fontawesome-svg-core';
import {
    faUserSecret,
    faMinusCircle
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome';

import 'vue-select/dist/vue-select.css';
import 'vue-datetime/dist/vue-datetime.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import {
    Settings
} from 'luxon';


library.add(
    faUserSecret,
    faMinusCircle
);

Vue.use(BootstrapVue);
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(Datetime)
Vue.component('v-select', vSelect);
Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.http.headers.common['Accept'] = 'application/json';
Vue.http.headers.common['Content-Type'] = 'application/json';



import StoreCommand from "./components/commands/StoreCommand";
const routes = [{
        path: '/commands/create',
        component: StoreCommand
    },
    {
        path: '/commands/:id/edit',
        component: StoreCommand,
        props: true
    }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes, // short for `routes: routes`
});

Vue.mixin({
    data: function () {
        return {
            lang: "en",
            LuxonSettings: Settings,
            FRSTATUS: {
                ENCOURS: 1,
                LIVRER: 2,
                ANNULER: 3
            },
            ENSTATUS: {
                ONGOING: 1,
                DELIVERED: 2,
                ABORTED: 3
            },
        }
    },
    computed: {
        STATUS: function () {
            return this[this.lang.toUpperCase() + "STATUS"];
        }
    },
    watch: {
        lang: function () {
            this.updateLocal();
            this.$forceUpdate();
        }
    },
    methods: {
        goback: function () {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
        },
        updateLocal: function () {
            this.LuxonSettings.defaultLocale = this.lang;
        }
    },
    created: function () {
        this.updateLocal();
    }

});

const vm = new Vue({
    router,
    el: '#app',
});

window.vm = vm;
