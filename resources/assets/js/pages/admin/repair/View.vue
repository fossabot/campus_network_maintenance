<template>
    <div class="repair-view">
        <div class="search" v-if="parseInt(admin.role_id) === 9">
            <el-form ref="search" label-width="100px">
                <el-row type="flex" justify="center">
                    <el-col :md="5">
                        <el-form-item label="分类">
                            <el-select v-model="type_id">
                                <el-option v-for="item in type" :key="item.id" :label="item.name" :value="item.id"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
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
            <h4>报障单完成数</h4>
            <ve-histogram :data="data1" :settings="settings1" :loading="loading" :data-empty="data1.rows.length === 0"></ve-histogram>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="12">
                <h4>今日报障单完成数</h4>
                <ve-pie :data="data2" :loading="loading" :data-empty="data2.rows.length === 0"></ve-pie>
            </el-col>
            <el-col :span="12">
                <h4>本月报障单完成数</h4>
                <ve-pie :data="data3" :loading="loading" :data-empty="data3.rows.length === 0"></ve-pie>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import 'v-charts/lib/style.css'

    export default {
        data() {
            return {
                admin: [],
                type: [],
                type_id: 0,
                time: [],
                loading: true,
                data1: {
                    columns: ['维修人员', '今日', '昨日', '本月', '上个月', '自定义'],
                    rows: []
                },
                settings1: {
                    label: {normal: {show: true, position: 'top'}}
                },
                data2: {
                    columns: ['维修人员', '数量'],
                    rows: []
                },
                data3: {
                    columns: ['维修人员', '数量'],
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
                    '/api/admin/repair/view/' + this.type_id + '/' + start + '/' + end
                ).then((response) => {
                    if (response.status === 200) {
                        this.data1.rows = response.data.data1
                        this.data2.rows = response.data.data2
                        this.data3.rows = response.data.data3
                        this.loading = false
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            getType() {
                this.$http.get(
                    '/api/admin/type/list'
                ).then((response) => {
                    if (response.status === 200) {
                        this.type = response.data
                        this.type.push({id: 0, name: '显示全部'})
                    }
                })
            }
        },
        mounted() {
            this.admin = window.admin
            this.type_id = parseInt(this.admin.role_id) !== 9 ? this.admin.type_id : 0
            this.getType()
            this.getData()
        }
    }
</script>
