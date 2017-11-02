import Layout from './pages/admin/Layout.vue'

const routes = [
    {
        path: '/',
        component: require('./pages/admin/auth/Login.vue')
    },
    {
        path: '/repair',
        component: Layout,
        children: [
            {
                path: 'list',
                component: require('./pages/admin/repair/List.vue')
            }
        ]
    },
    {
        path: '*',
        redirect: '/'
    }
]

export default routes
