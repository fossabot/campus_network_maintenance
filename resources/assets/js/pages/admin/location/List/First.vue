<template>
    <div class="location-list">
        <el-table :data="data" border>
            <el-table-column prop="first" label="一级区域"></el-table-column>
            <el-table-column label="操作" width="80">
                <template slot-scope="scope">
                    <el-button size="mini" type="danger" @click="deleteFirst(scope.row.id)">删除</el-button>
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
                    '/api/admin/location/first'
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            deleteFirst(id) {
                this.$confirm('删除一级区域需要手动删除其二级区域，确认删除吗？', '提示', {
                    type: 'warning',
                    center: true
                }).then(() => {
                    this.$http.post('/api/admin/location/delete', {
                        id: id
                    }).then((response) => {
                        if (response.status === 200) {
                            this.$notify.success({
                                message: '删除成功',
                                duration: 2000
                            })
                        }
                        this.getData()
                    })
                })
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
