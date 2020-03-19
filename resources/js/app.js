import Vue from 'vue'
import route from 'ziggy'
import VueMeta from 'vue-meta'
import { InertiaApp } from '@inertiajs/inertia-vue'
import { Ziggy } from '../assets/js/ziggy'

Vue.mixin({ methods: { route: (name, params, absolute) => route(name, params, absolute, Ziggy) } });

Vue.use(VueMeta)
Vue.use(InertiaApp)

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
