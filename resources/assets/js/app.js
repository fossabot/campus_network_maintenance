// window.Vue = require('vue');
// window.axios = require('axios');
//
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//
// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

import Vue from 'vue'
import ElementUI from 'element-ui'
// import Axios from 'axios'

import App from './App.vue'

Vue.use(ElementUI)

const app = new Vue({
    el: '#app',
    render: h => h(App)
})
