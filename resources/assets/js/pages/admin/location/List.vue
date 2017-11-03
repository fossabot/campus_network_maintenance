<template>
    <div class="location-list">
        <el-table :data="data" border>
            <el-table-column prop="first" label="主要地区" width="300" :filters="filters" :filter-method="filterFirst" filter-placement="right">
                <template slot-scope="scope">{{scope.row.first}}</template>
            </el-table-column>
            <el-table-column prop="second" label="次要地区"></el-table-column>
            <el-table-column label="操作" width="80">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/location/detail/' + scope.row.id)">修改</el-button>
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
                this.$http.get('/api/admin/location/first').then((response) => {
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
                this.$http.get('/api/admin/location/second').then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            filterFirst(value, row) {
                return row.first === value;
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
