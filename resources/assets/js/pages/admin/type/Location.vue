<template>
    <div class="type-location">
        <div class="title" v-if="type.name">当前分类：【{{ type.name }}】</div>
        <el-transfer v-model="value" :data="data" :titles="titles" filterable :filter-method="filterMethod"></el-transfer>
        <div class="button">
            <el-button type="primary" :loading="lock" @click="submitForm">确认分配</el-button>
            <el-button @click="resetForm">重置刷新</el-button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lock: false,
                type: {},
                data: [],
                value: [],
                titles: ['可选择地区', '已选择地区']
            }
        },
        methods: {
            getData() {
                this.$http.get(
                    '/api/admin/type/detail/' + this.$route.params.id
                ).then((response) => {
                    this.type = response.data
                })
                this.$http.get(
                    '/api/admin/type/location/' + this.$route.params.id
                ).then((response) => {
                    this.value = response.data
                })
                this.$http.get('/api/admin/location/second').then((response) => {
                    if (response.status === 200) {
                        this.data = []
                        const data = response.data
                        for (const key in data) {
                            if (data.hasOwnProperty(key)) {
                                this.data.push({
                                    key: data[key].id,
                                    label: data[key].first + ' （' + data[key].second + '）'
                                })
                            }
                        }
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            submitForm() {
                this.lock = true
                this.$http.post('/api/admin/type/location', {
                    id: this.$route.params.id,
                    locations: this.value
                }).then((response) => {
                    this.lock = false
                    if (response.status === 200) {
                        this.$notify.success({
                            message: '分配成功',
                            duration: 2000
                        })
                        this.resetForm()
                    }
                })
            },
            resetForm() {
                this.value = []
                this.getData()
            },
            filterMethod(query, item) {
                return item.label.indexOf(query) >= 0
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>

<style>
    .type-location .title {
        padding: 10px 0 20px;
        font-size: 24px;
    }

    .type-location .el-transfer-panel {
        min-height: 400px;
        min-width: 300px;
    }

    .type-location .el-transfer-panel__filter .el-input__inner {
        padding-left: 40px;
    }

    .type-location .button {
        margin-top: 20px;
    }
</style>
