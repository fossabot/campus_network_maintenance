import BabelPolyFill from 'babel-polyfill'

import Vue from 'vue'
import ElementUI from 'element-ui'

import VueRouter from 'vue-router'
import routes from './routes'

import Axios from 'axios'

import App from './App.vue'

Vue.use(ElementUI)
Vue.use(VueRouter)

const router = new VueRouter({
    root: '/admin',
    routes: routes
})

const http = Axios.create({
    baseURL: '/',
    timeout: 10000,
    validateStatus: function (status) {
        return true
    }
})

let loading

http.interceptors.request.use((config) => {
    loading = ElementUI.Loading.service({lock: true})
    return config
}, (error) => {
    return Promise.reject(error)
})

http.interceptors.response.use((response) => {
    loading.close()
    if (response.status === 200) {
        return response
    } else if (response.status === 422 || response.status === 423) {
        const errors = response.data.errors
        let message
        if (errors) {
            for (let key in errors) {
                if (errors.hasOwnProperty(key)) {
                    message = errors[key][0]
                }
            }
        } else {
            message = response.data
        }
        ElementUI.Notification.error({
            title: '提交数据不符合要求',
            message: message,
            duration: 5000
        })
        return response
    } else {
        ElementUI.Notification.error({
            title: '错误',
            message: '服务器发生错误',
            duration: 0
        })
        return response
    }
}, (error) => {
    return Promise.reject(error)
})

Vue.prototype.$http = http

if (document.body.clientWidth < 992) {
    ElementUI.Notification.warning({
        title: '提示',
        message: '建议使用 1920x1080 分辨率',
        duration: 0
    })
}

const app = new Vue({
    router: router,
    render: h => h(App)
}).$mount('#app')
