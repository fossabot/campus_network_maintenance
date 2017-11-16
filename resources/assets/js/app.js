// 兼容性
import BabelPolyFill from 'babel-polyfill'

// 引入
import Vue from 'vue'
import ElementUI from 'element-ui'

import VeHistogram from 'v-charts/lib/histogram'
import VePie from 'v-charts/lib/pie'

import VueRouter from 'vue-router'
import routes from './routes'

import Axios from 'axios'

import App from './App.vue'

Vue.use(ElementUI)
Vue.use(VueRouter)

Vue.component(VeHistogram.name, VeHistogram)
Vue.component(VePie.name, VePie)

// 路由
const router = new VueRouter({
    root: '/admin',
    routes: routes
})

// 发送请求
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
    } else if (response.status === 404) {
        ElementUI.Notification.error({
            title: '错误',
            message: '未找到当前页面。',
            duration: 5000
        })
        return response
    } else if (response.status === 403) {
        ElementUI.Notification.error({
            title: '错误',
            message: '没有此操作的权限。',
            duration: 5000
        })
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
            title: '错误',
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

// 注册到 Vue
Vue.prototype.$http = http

// 建议宽度大于 992px
if (document.body.clientWidth < 992) {
    ElementUI.Notification.warning({
        title: '提示',
        message: '建议使用 1920x1080 分辨率',
        position: 'top-left',
        duration: 0
    })
}

const app = new Vue({
    router: router,
    render: h => h(App)
}).$mount('#app')
