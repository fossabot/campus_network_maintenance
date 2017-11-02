<template>
    <div class="type-list">
        <el-table :data="data" border>
            <el-table-column type="expand">
                <template slot-scope="scope">
                    <el-form class="type-detail" label-position="left" inline>
                        <el-form-item label="自动完成时间">
                            <span>{{ scope.row.auto_complete_hours }}</span>
                        </el-form-item>
                        <el-form-item label="用户默认评价">
                            <span>{{ scope.row.auto_complete_stars }}</span>
                        </el-form-item>
                        <el-form-item label="需要用户验证">
                            <span>{{ scope.row.real_user_auth }}</span>
                        </el-form-item>
                        <el-form-item label="允许用户创建">
                            <span>{{ scope.row.allow_user_create }}</span>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column prop="name" label="分类名称" width="250"></el-table-column>
            <el-table-column prop="introduction" label="分类描述"></el-table-column>
            <el-table-column label="操作" width="110">
                <template slot-scope="scope">
                    <el-button size="mini">查看 / 编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                total: 4000,
                per: 20,
                page: 1,
                data: [
                    {
                        id: 1,
                        name: '校园网络',
                        introduction: '校园网络',
                        auto_complete_hours: 72,
                        auto_complete_stars: 5,
                        real_user_auth: '是',
                        allow_user_create: '是'
                    },
                    {
                        id: 2,
                        name: '多媒体教室',
                        introduction: '多媒体教室',
                        auto_complete_hours: '禁止',
                        auto_complete_stars: 5,
                        real_user_auth: '否',
                        allow_user_create: '否'
                    },
                    {
                        id: 3,
                        name: '一卡通',
                        introduction: '一卡通',
                        auto_complete_hours: '禁止',
                        auto_complete_stars: 5,
                        real_user_auth: '否',
                        allow_user_create: '否'
                    }
                ]
            }
        },
        methods: {
            getData() {
                console.log(this.per)
                console.log(this.page)
            }
        }
    }
</script>

<style>
    .type-list .type-detail {
        font-size: 0;
    }

    .type-list .type-detail label {
        width: 100px;
        color: #99a9bf;
    }

    .type-list .type-detail .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 50%;
    }
</style>
