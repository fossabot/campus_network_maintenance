import Layout from './pages/admin/Layout.vue'

const mustLogin = (to, from, next) => {
    if (window.User.hasLogin) {
        next()
    } else {
        next('/auth/login')
    }
}

const routes = [
    {
        path: '/',
        beforeEnter: mustLogin
    },
    {
        path: '/auth/login',
        component: require('./pages/admin/auth/Login.vue')
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
                component: require('./pages/admin/repair/List.vue')
            },
            {
                path: 'create',
                name: '新增报障单',
                component: require('./pages/admin/repair/Create.vue')
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
                component: require('./pages/admin/user/List.vue')
            },
            {
                path: 'create',
                name: '新增维修人员',
                component: require('./pages/admin/user/Create.vue')
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
                component: require('./pages/admin/type/List.vue')
            },
            {
                path: 'create',
                name: '新增维修分类',
                component: require('./pages/admin/type/Create.vue')
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
                path: 'list',
                name: '维修地区列表',
                component: require('./pages/admin/location/List.vue')
            },
            {
                path: 'create',
                name: '新增维修地区',
                component: require('./pages/admin/location/Create.vue')
            },
            {
                path: 'allot',
                name: '分配维修地区',
                component: require('./pages/admin/location/Allot.vue')
            },
            {
                path: '*',
                redirect: '/location/list'
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
                component: require('./pages/admin/part/List.vue')
            },
            {
                path: 'create',
                name: '新增维修备件',
                component: require('./pages/admin/part/Create.vue')
            },
            {
                path: 'use',
                name: '维修备件使用情况',
                component: require('./pages/admin/part/Use.vue')
            },
            {
                path: '*',
                redirect: '/part/list'
            }
        ]
    },
    {
        path: '*',
        redirect: '/'
    }
]

export default routes
