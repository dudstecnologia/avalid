// require('./bootstrap');

// window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// const app = new Vue({
//     el: '#app',
// });

import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'

Vue.use(InertiaApp)

const app = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(app)
