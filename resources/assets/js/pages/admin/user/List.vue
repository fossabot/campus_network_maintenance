<template>
    <div class="user-list">
        <el-table :data="data" border>
            <el-table-column label="分类">
                <template slot-scope="scope">
                    <span v-if="scope.row.role_id != 9">{{ scope.row.type }}</span>
                    <span v-else>{{ scope.row.role }}</span>
                </template>
            </el-table-column>
            <el-table-column label="权限">
                <template slot-scope="scope">{{ scope.row.role }}</template>
            </el-table-column>
            <el-table-column prop="username" label="帐号" width="200"></el-table-column>
            <el-table-column prop="name" label="姓名" width="200"></el-table-column>
            <el-table-column label="操作" width="80">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/user/detail/' + scope.row.id)">修改</el-button>
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
                this.$http.get(
                    '/api/admin/user/list'
                ).then((response) => {
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
