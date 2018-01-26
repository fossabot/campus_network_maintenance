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
        <el-pagination layout="sizes, prev, pager, next, jumper, ->, total" :total="total" :page-sizes="[20, 50, 100, 200]" :page-size="search.per" :current-page="search.page" @size-change="handleSizeChange" @current-change="handleCurrentChange" style="margin-top: 20px;"></el-pagination>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                total: 20,
                data: [],
                search: {
                    per: 20,
                    page: 1
                }
            }
        },
        methods: {
            getData() {
                this.$http.get(
                    '/api/admin/part/use', {params: this.search}
                ).then((response) => {
                    if (response.status === 200) {
                        this.total = response.data.total
                        this.data = response.data.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            handleSizeChange(val) {
                this.search.per = val
                this.getData()
            },
            handleCurrentChange(val) {
                this.search.page = val
                this.getData()
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
