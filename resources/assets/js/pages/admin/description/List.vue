<template>
    <div class="description-list">
        <el-table :data="data" border>
            <el-table-column prop="type.name" label="分类"></el-table-column>
            <el-table-column prop="description" label="故障类别描述"></el-table-column>
            <el-table-column prop="admin_description" label="默认解决方法"></el-table-column>
            <el-table-column label="操作" width="110"><template slot-scope="scope"><el-button size="mini" @click="$router.push('/description/detail/' + scope.row.id)">查看 / 修改</el-button></template></el-table-column>
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
                    '/api/admin/description/list/0'
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
