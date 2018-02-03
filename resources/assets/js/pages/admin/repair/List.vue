<template>
    <div class="repair-list">
        <div class="search">
            <el-form ref="search" :model="search" label-width="100px">
                <el-row>
                    <el-col :md="6">
                        <el-form-item label="状态"><el-select v-model="search.status_id"><el-option v-for="item in status" :key="item.value" :label="item.label" :value="item.value"></el-option></el-select></el-form-item>
                    </el-col>
                    <el-col :md="6" v-if="parseInt(admin.role_id) === 9">
                        <el-form-item label="分类"><el-select v-model="search.type_id"><el-option v-for="item in type" :key="item.id" :label="item.name" :value="item.id"></el-option></el-select></el-form-item>
                    </el-col>
                    <el-col :md="6">
                        <el-form-item label="报障人学号"><el-input v-model="search.user_id"></el-input></el-form-item>
                    </el-col>
                    <el-col :md="6">
                        <el-form-item label="报障人手机"><el-input v-model="search.user_mobile"></el-input></el-form-item>
                    </el-col>
                </el-row>
                <el-row type="flex" justify="center">
                    <el-col :md="7">
                        <el-form-item label="自定义时间"><el-date-picker v-model="search.time" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" value-format="yyyy-MM-dd" unlink-panels></el-date-picker></el-form-item>
                    </el-col>
                    <el-col :md="5">
                        <el-form-item><el-button type="primary" @click="getData">查询</el-button></el-form-item>
                    </el-col>
                </el-row>
            </el-form>
        </div>
        <el-table :data="data" border>
            <el-table-column type="expand">
                <template slot-scope="scope">
                    <el-form class="repair-detail" label-position="left" inline>
                        <el-form-item label="开始报障时间"><span>{{ scope.row.created_at }}</span></el-form-item>
                        <el-form-item label="开始维修时间"><span>{{ scope.row.accepted_at }}</span></el-form-item>
                        <el-form-item label="维修完成时间"><span>{{ scope.row.repaired_at }}</span></el-form-item>
                        <el-form-item label="评价完成时间"><span>{{ scope.row.completed_at }}</span></el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column prop="id" label="流水号" width="100"></el-table-column>
            <el-table-column prop="status" label="状态" width="80"></el-table-column>
            <el-table-column prop="type.name" label="分类" width="150" show-overflow-tooltip></el-table-column>
            <el-table-column label="区域" width="200" show-overflow-tooltip><template slot-scope="scope">{{ scope.row.location.first }} {{ scope.row.location.second }}#{{ scope.row.user_room }}</template></el-table-column>
            <el-table-column prop="user_id" label="报障人学号" width="150"></el-table-column>
            <el-table-column prop="user_name" label="报障人姓名" width="100"></el-table-column>
            <el-table-column prop="user_description" label="故障描述" show-overflow-tooltip></el-table-column>
            <el-table-column prop="created_at" label="报障时间" width="135"></el-table-column>
            <el-table-column label="操作" width="175">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/repair/detail/' + scope.row.id)">查看</el-button>
                    <el-button v-if="scope.row.status_id === 1" size="mini" type="success" @click="acceptRepair(scope.row.id)">开始维修</el-button>
                    <el-button v-if="scope.row.status_id === 2" size="mini" type="success" @click="finishRepair(scope.row.id)">维修完成</el-button>
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
                admin: {},
                total: 20,
                data: [],
                status: [
                    {label: '已删除', value: 0},
                    {label: '未完成', value: 12},
                    {label: '已完成', value: 34},
                    {label: '全部', value: 12340}
                ],
                type: [],
                search: {
                    per: 20,
                    page: 1,
                    time: [],
                    status_id: parseInt(admin.role_id) === 9 ? 12340 : 12,
                    type_id: '',
                    user_id: '',
                    user_mobile: ''
                }
            }
        },
        methods: {
            getData() {
                this.$http.post(
                    '/api/admin/repair/list', this.search
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
            getType() {
                this.$http.get(
                    '/api/admin/type/list'
                ).then((response) => {
                    if (response.status === 200) {
                        this.type = response.data
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
            },
            acceptRepair(id) {
                this.lock = true
                this.$http.post(
                    '/api/admin/repair/change', {
                        id: id,
                        type: 'accept'
                    }).then((response) => {
                    this.lock = false
                    if (response.status === 200) {
                        this.$notify.success({
                            message: '开始维修',
                            duration: 2000
                        })
                        this.getData()
                    }
                })
            },
            finishRepair(id) {
                this.lock = true
                this.$http.post(
                    '/api/admin/repair/change', {
                        id: id,
                        type: 'finish'
                    }).then((response) => {
                    this.lock = false
                    if (response.status === 200) {
                        this.$notify.success({
                            message: '完成维修',
                            duration: 2000
                        })
                        this.getData()
                    }
                })
            }
        },
        mounted() {
            this.admin = window.admin
            this.getType()
            this.getData()
        }
    }
</script>

<style>
    .repair-list .repair-detail {
        font-size: 0;
    }

    .repair-list .repair-detail label {
        width: 100px;
        color: #99a9bf;
    }

    .repair-list .repair-detail .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 50%;
    }
</style>
