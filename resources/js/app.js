import axios from 'axios'
import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'

Vue.use(InertiaApp)
Vue.mixin({ methods: { route: window.route } })

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
window.axios.defaults.headers.common['Content-Type'] = 'application/json'

const app = document.querySelector('#app')

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        }
    })
}).$mount(app);
