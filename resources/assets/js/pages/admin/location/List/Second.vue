<template>
    <div class="location-list">
        <el-table :data="data" border>
            <el-table-column prop="first" label="主要地区" width="300" :filters="filters" :filter-method="filterFirst" filter-placement="right">
                <template slot-scope="scope">{{scope.row.first}}</template>
            </el-table-column>
            <el-table-column prop="second" label="次要地区"></el-table-column>
            <el-table-column label="操作" width="80">
                <template slot-scope="scope">
                    <el-button size="mini" type="danger" @click="deleteLocation(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                filters: [],
                data: []
            }
        },
        methods: {
            getData() {
                this.$http.get(
                    '/api/admin/location/first'
                ).then((response) => {
                    if (response.status === 200) {
                        this.filters = []
                        const data = response.data
                        for (const key in data) {
                            if (data.hasOwnProperty(key)) {
                                this.filters.push({
                                    text: data[key].first,
                                    value: data[key].first
                                })
                            }
                        }
                    }
                })
                this.$http.get(
                    '/api/admin/location/second'
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            filterFirst(value, row) {
                return row.first === value
            },
            deleteLocation(id) {
                this.$confirm('此操作将删除次要地区且不可恢复，确认删除吗？', '提示', {
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
