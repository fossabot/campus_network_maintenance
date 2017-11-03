<template>
    <div class="location-allot">
        <el-transfer v-model="value" :data="data" filterable :filter-method="filterMethod"></el-transfer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: [
                    {
                        key: '',
                        label: ''
                    }
                ],
                value: [],
                filterMethod(query, item) {
                    return 1
                }
            }
        },
        methods: {
            getData() {
                this.$http.get('/api/admin/location/second').then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            }
        }
    }
</script>

<style>
    .location-allot .el-transfer-panel {
        min-height: 400px;
        min-width: 300px;
    }
</style>
