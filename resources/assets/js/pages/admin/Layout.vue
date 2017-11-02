<template>
    <el-container style="height: 100%;">
        <el-header>
            <div class="title">校园网络运维系统</div>
            <el-row type="flex" justify="end" style="margin-left: 190px;">
                <el-col :span="4" style="width: 150px;">
                    <div class="grid-content">哈哈</div>
                </el-col>
            </el-row>
        </el-header>
        <el-container>
            <el-aside width="200px" default-active="2">
                <el-menu>
                    <el-submenu index="1">
                        <template slot="title">
                            <span slot="title">导航一</span>
                        </template>
                    </el-submenu>
                    <el-menu-item index="2">
                        <span slot="title">导航二</span>
                    </el-menu-item>
                    <el-menu-item index="3">
                        <span slot="title">导航三</span>
                    </el-menu-item>
                </el-menu>
            </el-aside>
            <el-main>
                <router-view></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>


<script>
    export default {
        data() {
            return {}
        },
        methods: {

        }
    }
</script>


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
        border-right: 1px solid #e0e0e0;
    }

    .el-aside {
        height: 100%;
    }

    .el-main {
        background-color: #E6EBF5;
        height: 100%;
    }
</style>
