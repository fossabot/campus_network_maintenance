import Layout from './pages/admin/Layout.vue'

const routes = [
    {
        path: '/',
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
        path: '*',
        redirect: '/'
    }
]

export default routes
