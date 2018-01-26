<template>
    <div class="part-list">
        <el-table :data="data" border>
            <el-table-column prop="id" label="id" width="70"></el-table-column>
            <el-table-column prop="name" label="备件名称"></el-table-column>
            <el-table-column prop="left_number" label="剩余数量"></el-table-column>
            <el-table-column label="操作" width="200">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/part/detail/' + scope.row.id)">修改</el-button>
                    <el-button size="mini" type="primary" @click="addNumber(scope.row.id)">添加备件数量</el-button>
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
            },
            addNumber(id) {
                this.$prompt('添加备件数量', '提示', {
                    confirmButtonText: '确认添加',
                    cancelButtonText: '取消'
                }).then(({value}) => {
                    if (parseInt(value) > 0) {
                        this.$http.post('/api/admin/part/number', {
                            id: id,
                            number: value
                        }).then((response) => {
                            if (response.status === 200) {
                                this.getData()
                                this.$notify.success({
                                    message: '添加成功',
                                    duration: 2000
                                })
                            }
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
