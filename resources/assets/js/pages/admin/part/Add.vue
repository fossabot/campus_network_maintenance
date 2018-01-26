<template>
    <div class="part-add">
        <el-table :data="data" border>
            <el-table-column prop="id" label="id" width="70"></el-table-column>
            <el-table-column prop="part.name" label="增加备件"></el-table-column>
            <el-table-column prop="number" label="增加个数"></el-table-column>
            <el-table-column prop="admin.name" label="操作用户"></el-table-column>
            <el-table-column prop="created_at" label="增加时间"></el-table-column>
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
                this.$http.get('/api/admin/part/add').then((response) => {
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
