<template>
    <el-container style="height: 100%;">
        <el-header>
            <div class="title">校园网络运维系统</div>
            <el-row type="flex" justify="end" style="margin-left: 190px;">
                <el-col :span="4" style="width: 150px;text-align: right;">
                    <el-dropdown :show-timeout="0" @command="clickItem">
                        <span style="cursor: pointer;color: #fefefe;">
                            {{ admin.name }}
                            <i class="el-icon-arrow-down el-icon--right"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item v-if="parseInt(admin.role_id) !== 9" disabled>{{ admin.type }}</el-dropdown-item>
                            <el-dropdown-item disabled>{{ admin.role }}</el-dropdown-item>
                            <el-dropdown-item command="profile" divided>修改资料</el-dropdown-item>
                            <el-dropdown-item command="logout">退出登录</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </el-col>
            </el-row>
        </el-header>
        <el-container>
            <el-aside width="200px">
                <el-menu :default-active="$route.path" :unique-opened="true" background-color="#EDF2FC" router>
                    <el-submenu index="repair">
                        <template slot="title">
                            <span slot="title">报障单</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="/repair/view">报障单总览</el-menu-item>
                            <el-menu-item index="/repair/list">报障单列表</el-menu-item>
                            <el-menu-item index="/repair/create">新增报障单</el-menu-item>
                            <el-menu-item v-if="$route.path.substr(0, 15) === '/repair/detail/'" :index="$route.path">修改报障单</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="user" v-if="parseInt(admin.role_id) >= 5">
                        <template slot="title">
                            <span slot="title">维修人员</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="/user/list">维修人员列表</el-menu-item>
                            <el-menu-item index="/user/create">新增维修人员</el-menu-item>
                            <el-menu-item v-if="$route.path.substr(0, 13) === '/user/detail/'" :index="$route.path">修改维修人员</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="type" v-if="parseInt(admin.role_id) === 9">
                        <template slot="title">
                            <span slot="title">维修分类</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="/type/list">维修分类列表</el-menu-item>
                            <el-menu-item index="/type/create">新增维修分类</el-menu-item>
                            <el-menu-item v-if="$route.path.substr(0, 13) === '/type/detail/'" :index="$route.path">修改维修分类</el-menu-item>
                            <el-menu-item v-if="$route.path.substr(0, 15) === '/type/location/'" :index="$route.path">分配维修区域</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="location" v-if="parseInt(admin.role_id) === 9">
                        <template slot="title">
                            <span slot="title">维修区域</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="/location/list/first">一级区域列表</el-menu-item>
                            <el-menu-item index="/location/list/second">二级区域列表</el-menu-item>
                            <el-menu-item index="/location/create">新增维修区域</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="part" v-if="parseInt(admin.role_id) === 9">
                        <template slot="title">
                            <span slot="title">维修备件</span>
                        </template>
                        <el-menu-item-group>
                            <span slot="title">维修备件</span>
                            <el-menu-item index="/part/list">维修备件列表</el-menu-item>
                            <el-menu-item index="/part/create">新增维修备件</el-menu-item>
                            <el-menu-item v-if="$route.path.substr(0, 13) === '/part/detail/'" :index="$route.path">修改维修备件</el-menu-item>
                        </el-menu-item-group>
                        <el-menu-item-group>
                            <span slot="title">维修备件日志</span>
                            <el-menu-item index="/part/add">维修备件添加记录</el-menu-item>
                            <el-menu-item index="/part/use">维修备件使用情况</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="description" v-if="parseInt(admin.role_id) >= 5">
                        <template slot="title">
                            <span slot="title">故障类别</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="/description/list">故障类别列表</el-menu-item>
                            <el-menu-item index="/description/create">新增故障类别</el-menu-item>
                            <el-menu-item v-if="$route.path.substr(0, 20) === '/description/detail/'" :index="$route.path">修改故障类别</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                </el-menu>
            </el-aside>
            <el-main>
                <el-row>
                    <el-col :span="12"><h2 style="margin-bottom: 20px;">{{ $route.name }}</h2></el-col>
                    <el-col :span="12"><el-breadcrumb style="float: right;"><el-breadcrumb-item v-for="item in $route.matched" :key="item.path" :to="{path: item.path}">{{ item.name }}</el-breadcrumb-item></el-breadcrumb></el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <router-view/>
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
    export default {
        data() {
            return {
                admin: window.admin
            }
        },
        methods: {
            clickItem(command) {
                switch (command) {
                    case 'profile':
                        this.$router.push('/profile/detail')
                        break;
                    case 'logout':
                        this.$confirm('确认退出吗？', '提示', {
                            type: 'warning',
                            center: true
                        }).then(() => {
                            this.$http.post('/api/admin/auth/logout').then(() => {
                                this.$notify.success({
                                    message: '退出成功',
                                    duration: 2000
                                })
                                this.$loading({body: true, lock: true})
                                window.location.href = '/admin/'
                            })
                        })
                        break;
                    default:
                        this.$router.push('/')
                        break;
                }
            }
        }
    }
</script>

<style>
    .el-container {
        height: 100%;
    }

    .el-header {
        color: #fefefe;
        background-color: #409eff;
        line-height: 60px;
    }

    .el-header .title {
        position: absolute;
        width: 179px;
        font-size: 20px;
        font-weight: bold;
        border-right: 1px solid #e0e0e0;
    }

    .el-aside {
        background-color: #edf2fc;
        height: 100%;
    }

    .el-main {
        background-color: #fefefe;
        height: 100%;
        overflow-y: scroll;
    }

    .el-select {
        width: 100%;
    }
</style>
