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
                    <el-button size="mini" @click="$router.push('/type/detail/' + scope.row.id)">查看 / 编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: []
            }
        },
        methods: {
            getData() {
                this.$http.get('/api/admin/type/list').then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            }
        },
        mounted() {
            this.getData()
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
