import Vue from 'vue'
import route from 'ziggy'
import VueMeta from 'vue-meta'
import { InertiaApp } from '@inertiajs/inertia-vue'
import { Ziggy } from '../assets/js/ziggy'
import { BootstrapVue } from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2'
import DatatableFlex from './Componentes/DatatableFlex'
import VueAxios from 'vue-axios'
import axios from   'axios'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'sweetalert2/dist/sweetalert2.min.css';
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

Vue.mixin({ methods: { route: (name, params, absolute) => route(name, params, absolute, Ziggy) } });

Vue.use(VueMeta)
Vue.use(InertiaApp)
Vue.use(BootstrapVue)
Vue.use(VueSweetalert2)
Vue.use(VueAxios, axios)

Vue.component('datatable-flex', DatatableFlex)

const app = document.getElementById('app')

new Vue({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - AvaliD` : 'AvaliD'
    },
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./Paginas/${name}`).default,
        },
    }),
}).$mount(app)
