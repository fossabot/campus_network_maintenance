<template>
    <el-container style="height: 100%;">
        <el-header>
            <div class="title">校园网络运维系统</div>
            <el-row type="flex" justify="end" style="margin-left: 190px;">
                <el-col :span="4" style="width: 150px;">
                    <div class="grid-content">用户名</div>
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
                            <span slot="title">报障单</span>
                            <el-menu-item index="/repair/list">报障单列表</el-menu-item>
                            <el-menu-item index="/repair/create">新增报障单</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="user">
                        <template slot="title">
                            <span slot="title">维修人员</span>
                        </template>
                        <el-menu-item-group>
                            <span slot="title">维修人员</span>
                            <el-menu-item index="/user/list">维修人员列表</el-menu-item>
                            <el-menu-item index="/user/create">新增维修人员</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="type">
                        <template slot="title">
                            <span slot="title">维修分类</span>
                        </template>
                        <el-menu-item-group>
                            <span slot="title">维修分类</span>
                            <el-menu-item index="/type/list">维修分类列表</el-menu-item>
                            <el-menu-item index="/type/create">新增维修分类</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="location">
                        <template slot="title">
                            <span slot="title">维修地区</span>
                        </template>
                        <el-menu-item-group>
                            <span slot="title">维修地区</span>
                            <el-menu-item index="/location/list">维修地区列表</el-menu-item>
                            <el-menu-item index="/location/create">新增维修地区</el-menu-item>
                        </el-menu-item-group>
                        <el-menu-item-group>
                            <span slot="title">分配维修地区</span>
                            <el-menu-item index="/location/allot">分配维修地区</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-submenu index="part">
                        <template slot="title">
                            <span slot="title">维修备件</span>
                        </template>
                        <el-menu-item-group>
                            <span slot="title">维修备件</span>
                            <el-menu-item index="/type/list">维修备件列表</el-menu-item>
                            <el-menu-item index="/type/create">新增维修备件</el-menu-item>
                        </el-menu-item-group>
                        <el-menu-item-group>
                            <span slot="title">维修备件日志</span>
                            <el-menu-item index="/type/create">维修备件使用情况</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                </el-menu>
            </el-aside>
            <el-main>
                <el-row>
                    <el-col :span="12">
                        <h2 style="margin-bottom: 20px;">{{ $route.name }}</h2>
                    </el-col>
                    <el-col :span="12">
                        <el-breadcrumb style="float: right;">
                            <el-breadcrumb-item v-for="item in $route.matched" :key="item.path" :to="{path: item.path}">
                                {{ item.name }}
                            </el-breadcrumb-item>
                        </el-breadcrumb>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <router-view></router-view>
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
    </el-container>
</template>

<style>
    .el-header {
        color: #fefefe;
        background-color: #409EFF;
        line-height: 60px;
    }

    .el-header .title {
        position: absolute;
        width: 179px;
        font-size: 20px;
        font-weight: bold;
        border-right: 1px solid #E0E0E0;
    }

    .el-aside {
        background-color: #EDF2FC;
        height: 100%;
    }

    .el-main {
        background-color: #FEFEFE;
        height: 100%;
    }
</style>
