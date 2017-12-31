<template>
    <div class="part-use">
        <div class="search" v-if="parseInt(admin.role_id) === 9">
            <el-form ref="search" label-width="100px">
                <el-row type="flex" justify="center">
                    <el-col :md="7">
                        <el-form-item label="自定义时间">
                            <el-date-picker v-model="time" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" value-format="yyyy-MM-dd" unlink-panels></el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :md="5">
                        <el-form-item>
                            <el-button type="primary" @click="getData">筛选</el-button>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
        </div>
        <el-row>
            <ve-histogram :data="data1" :settings="settings" :loading="loading" :data-empty="data1.rows.length === 0"/>
        </el-row>
    </div>
</template>

<script>
    import 'v-charts/lib/style.css'

    export default {
        data() {
            return {
                admin: [],
                time: [],
                loading: true,
                settings: {
                    label: {normal: {show: true, position: 'top'}}
                },
                data1: {
                    columns: ['备件名称', '今日', '昨日', '本月', '总共', '自定义'],
                    rows: []
                }
            }
        },
        methods: {
            getData() {
                this.loading = true
                let start = this.time[0] ? this.time[0] : '0'
                let end = this.time[1] ? this.time[1] : '0'
                this.$http.get(
                    '/api/admin/part/use/' + start + '/' + end
                ).then((response) => {
                    if (response.status === 200) {
                        this.data1.rows = response.data.data1
                        this.loading = false
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            }
        },
        mounted() {
            this.admin = window.admin
            this.getData()
        }
    }
</script>
