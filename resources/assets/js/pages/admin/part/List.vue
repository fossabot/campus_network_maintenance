<template>
    <div class="part-list">
        <el-table :data="data" border>
            <el-table-column prop="id" label="id" width="70"></el-table-column>
            <el-table-column prop="name" label="备件名称"></el-table-column>
            <el-table-column label="操作" width="80">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/part/detail/' + scope.row.id)">修改</el-button>
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
                this.$http.get('/api/admin/part/list').then((response) => {
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
