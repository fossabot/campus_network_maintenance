<template>
    <div class="part-use">
        <el-table :data="data" border>
            <el-table-column prop="id" label="id" width="70"></el-table-column>
            <el-table-column prop="part.name" label="使用备件"></el-table-column>
            <el-table-column prop="number" label="使用个数"></el-table-column>
            <el-table-column prop="admin.name" label="使用者"></el-table-column>
            <el-table-column prop="created_at" label="使用时间"></el-table-column>
            <el-table-column label="操作" width="115">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/repair/detail/' + scope.row.id)">查看维修单</el-button>
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
                this.$http.get('/api/admin/part/use').then((response) => {
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
