<template>
    <div class="repair-list">
        <el-table :data="data" border>
            <el-table-column type="expand">
                <template slot-scope="scope">
                    <el-form class="repair-detail" label-position="left" inline>
                        <el-form-item label="开始报障时间">
                            <span>{{ scope.row.created_at }}</span>
                        </el-form-item>
                        <el-form-item label="开始维修时间">
                            <span>{{ scope.row.accepted_at }}</span>
                        </el-form-item>
                        <el-form-item label="维修完成时间">
                            <span>{{ scope.row.repaired_at }}</span>
                        </el-form-item>
                        <el-form-item label="评价完成时间">
                            <span>{{ scope.row.completed_at }}</span>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column prop="id" label="id" width="50"></el-table-column>
            <el-table-column prop="status" label="状态" width="80"></el-table-column>
            <el-table-column prop="type.name" label="分类"></el-table-column>
            <el-table-column label="地区">
                <template slot-scope="scope">
                    {{ scope.row.location.first }} {{ scope.row.location.second }}
                </template>
            </el-table-column>
            <el-table-column prop="user_room" label="故障房间号" width="100"></el-table-column>
            <el-table-column prop="user_id" label="报障人学号" width="150"></el-table-column>
            <el-table-column prop="user_name" label="报障人姓名" width="110"></el-table-column>
            <el-table-column prop="user_mobile" label="报障人手机号码" width="150"></el-table-column>
            <el-table-column label="操作" width="110">
                <template slot-scope="scope">
                    <el-button size="mini" @click="$router.push('/repair/detail/' + scope.row.id)">查看 / 修改</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
            layout="sizes, prev, pager, next, jumper, ->, total"
            :total="total"
            :page-sizes="[20, 50, 100, 200]"
            :page-size="per"
            :current-page="page"
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            style="margin-top: 20px;"
        >
        </el-pagination>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                total: 4000,
                per: 20,
                page: 1,
                data: []
            }
        },
        methods: {
            getData() {
                this.$http.post(
                    '/api/admin/repair/list', {
                        per: this.per,
                        page: this.page
                    }
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            handleSizeChange(val) {
                this.per = val
                this.getData()
            },
            handleCurrentChange(val) {
                this.page = val
                this.getData()
            }
        },
        mounted() {
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
