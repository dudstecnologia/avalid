import Vue from 'vue'
import route from 'ziggy'
import VueMeta from 'vue-meta'
import { InertiaApp } from '@inertiajs/inertia-vue'
import { Ziggy } from '../assets/js/ziggy'
import Vuesax from 'vuesax'
import { BootstrapVue } from 'bootstrap-vue'

import 'vuesax/dist/vuesax.css'
import 'material-icons/iconfont/material-icons.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.mixin({ methods: { route: (name, params, absolute) => route(name, params, absolute, Ziggy) } });

Vue.use(VueMeta)
Vue.use(InertiaApp)
Vue.use(Vuesax)
Vue.use(BootstrapVue)

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
