import BabelPolyFill from 'babel-polyfill'

import Vue from 'vue'
import ElementUI from 'element-ui'

import VueRouter from 'vue-router'
import routes from './routes'

import Axios from 'axios'

import App from './App.vue'

Vue.use(ElementUI)
Vue.use(VueRouter)

// Router
const router = new VueRouter({
    root: '/admin',
    routes: routes
})

// Axios
const http = Axios.create({
    baseURL: '/',
    timeout: 10000,
    headers: [
        {'X-Requested-With': 'XMLHttpRequest'},
        // {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content}
    ],
    xsrfHeaderName: 'X-CSRF-TOKEN',
    xsrfCookieName: document.head.querySelector('meta[name="csrf-token"]').content,
    validateStatus: function (status) {
        return true
    }
})

http.interceptors.request.use((config) => {
    return config
}, (error) => {
    return Promise.reject(error)
})

http.interceptors.response.use((response) => {
    return response
}, (error) => {
    return Promise.reject(error)
})

Vue.prototype.$http = http

const app = new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
