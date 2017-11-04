import Layout from './pages/admin/Layout.vue'

const redirect = (to, from, next) => {
    if (window.admin) {
        next('/repair/list')
    } else {
        next('/auth/login')
    }
}

const mustGuest = (to, from, next) => {
    if (window.admin) {
        next('/repair/list')
    } else {
        next()
    }
}

const mustLogin = (to, from, next) => {
    if (window.admin) {
        next()
    } else {
        next('/auth/login')
    }
}

const routes = [
    {
        path: '/',
        beforeEnter: redirect
    },
    {
        path: '/auth/login',
        component: require('./pages/admin/auth/Login.vue'),
        beforeEnter: mustGuest
    },
    {
        path: '/repair',
        redirect: '/repair/list'
    },
    {
        path: '/repair',
        name: '报障单',
        component: Layout,
        children: [
            {
                path: 'list',
                name: '报障单列表',
                component: require('./pages/admin/repair/List.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'create',
                name: '新增报障单',
                component: require('./pages/admin/repair/Create.vue'),
                beforeEnter: mustLogin
            },
            {
                path: '*',
                redirect: '/repair/list'
            }
        ]
    },
    {
        path: '/user',
        redirect: '/user/list'
    },
    {
        path: '/user',
        name: '维修人员',
        component: Layout,
        children: [
            {
                path: 'list',
                name: '维修人员列表',
                component: require('./pages/admin/user/List.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'create',
                name: '新增维修人员',
                component: require('./pages/admin/user/Create.vue'),
                beforeEnter: mustLogin
            },
            {
                path: '*',
                redirect: '/user/list'
            }
        ]
    },
    {
        path: '/type',
        redirect: '/type/list'
    },
    {
        path: '/type',
        name: '维修分类',
        component: Layout,
        children: [
            {
                path: 'list',
                name: '维修分类列表',
                component: require('./pages/admin/type/List.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'create',
                name: '新增维修分类',
                component: require('./pages/admin/type/Create.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'detail/:id',
                name: '修改维修分类',
                component: require('./pages/admin/type/Detail.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'location/:id',
                name: '分配维修地区',
                component: require('./pages/admin/type/Location.vue'),
                beforeEnter: mustLogin
            },
            {
                path: '*',
                redirect: '/type/list'
            }
        ]
    },
    {
        path: '/location',
        redirect: '/location/list'
    },
    {
        path: '/location',
        name: '维修地区',
        component: Layout,
        children: [
            {
                path: 'list/first',
                name: '主要地区列表',
                component: require('./pages/admin/location/List/First.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'list/second',
                name: '维修地区列表',
                component: require('./pages/admin/location/List/Second.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'create',
                name: '新增维修地区',
                component: require('./pages/admin/location/Create.vue'),
                beforeEnter: mustLogin
            },
            {
                path: '*',
                redirect: '/location/list/first'
            }
        ]
    },
    {
        path: '/part',
        redirect: '/part/list'
    },
    {
        path: '/part',
        name: '维修备件',
        component: Layout,
        children: [
            {
                path: 'list',
                name: '维修备件列表',
                component: require('./pages/admin/part/List.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'create',
                name: '新增维修备件',
                component: require('./pages/admin/part/Create.vue'),
                beforeEnter: mustLogin
            },
            {
                path: 'use',
                name: '维修备件使用情况',
                component: require('./pages/admin/part/Use.vue'),
                beforeEnter: mustLogin
            },
            {
                path: '*',
                redirect: '/part/list'
            }
        ]
    },
    {
        path: '/profile',
        redirect: '/profile/detail'
    },
    {
        path: '/profile',
        name: '个人资料',
        component: Layout,
        children: [
            {
                path: 'detail',
                name: '修改资料',
                component: require('./pages/admin/profile/Detail.vue'),
                beforeEnter: mustLogin
            },
            {
                path: '*',
                redirect: '/profile/edit'
            }
        ]
    },
    {
        path: '*',
        redirect: '/'
    }
]

export default routes
