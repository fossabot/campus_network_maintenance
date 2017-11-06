<template>
    <div class="repair-detail">
        <div v-if="data.status_id == 0" class="title">当前状态：【{{ data.status }}】</div>
        <el-row>
            <el-col :md="12">
                <el-steps v-if="data.status_id > 0" :active="data.status_id" align-center>
                    <el-step title="等待维修"></el-step>
                    <el-step title="正在维修"></el-step>
                    <el-step title="维修完成"></el-step>
                    <el-step title="评价完成"></el-step>
                </el-steps>
            </el-col>
        </el-row>
        <el-row :gutter="20" style="margin-top: 30px;">
            <el-col :md="12" v-if="data.status_id == 1">
                <el-form :model="data" :rules="rules" ref="data" label-width="120px">
                    <el-form-item label="报障人学号" prop="user_id">
                        <el-input v-model="data.user_id"></el-input>
                    </el-form-item>
                    <el-form-item label="报障人姓名" prop="user_name">
                        <el-input v-model="data.user_name"></el-input>
                    </el-form-item>
                    <el-form-item label="报障人手机号码" prop="user_mobile">
                        <el-input v-model="data.user_mobile"></el-input>
                    </el-form-item>
                    <el-form-item label="报障分类" prop="type_id">
                        <el-select v-model="data.type_id" @change="changeType" filterable>
                            <el-option v-for="item in type" :key="item.id" :label="item.name" :value="item.id"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="报障地区" prop="location_id">
                        <el-select v-model="data.location_id">
                            <el-option-group v-for="first in location" :key="first.label" :label="first.label">
                                <el-option v-for="second in first.options" :key="second.id" :label="second.value" :value="second.id"></el-option>
                            </el-option-group>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="故障房间号" prop="user_room">
                        <el-input v-model="data.user_room"></el-input>
                    </el-form-item>
                    <el-form-item label="报障描述" prop="user_description">
                        <el-input type="textarea" v-model="data.user_description" :autosize="{minRows: 3}"></el-input>
                    </el-form-item>
                    <el-form-item label="维修记录" v-if="data.status_id >= 2" required>
                        <el-input type="textarea" v-model="data.repair_description" :autosize="{minRows: 3}"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" :loading="lock" @click="submitForm('data')">修改</el-button>
                        <el-button type="success" :loading="lock" @click="acceptRepair">开始维修</el-button>
                        <el-button type="danger" :loading="lock" @click="deleteRepair">删除</el-button>
                        <el-button @click="resetForm('data')">重置刷新</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
            <el-col :md="12" v-if="data.status_id != 1">
                <el-card>
                    <el-form class="detail" label-position="right">
                        <el-form-item label="报障人学号">
                            <span>{{ data.user_id }}</span>
                        </el-form-item>
                        <el-form-item label="报障人姓名">
                            <span>{{ data.user_name }}</span>
                        </el-form-item>
                        <el-form-item label="报障人手机号码">
                            <span>{{ data.user_mobile }}</span>
                        </el-form-item>
                        <el-form-item label="报障分类">
                            <span>{{ data.type }}</span>
                        </el-form-item>
                        <el-form-item label="报障地区">
                            <span>{{ data.location.first }} {{ data.location.second }}</span>
                        </el-form-item>
                        <el-form-item label="故障房间号">
                            <span>{{ data.user_room }}</span>
                        </el-form-item>
                        <el-form-item label="报障描述">
                            <span>{{ data.user_description }}</span>
                        </el-form-item>
                    </el-form>
                </el-card>
            </el-col>
            <el-col :md="12">
                <div class="title">维修人员备注</div>
                <el-card>
                    <el-collapse v-if="data.admin_description.length" accordion>
                        <el-collapse-item v-for="item in data.admin_description" :key="item.id" :title="item.admin + ' ' + item.created_at">
                            <div>{{ item.description }}</div>
                        </el-collapse-item>
                    </el-collapse>
                    <div v-else>暂无备注</div>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                flag: false,
                lock: false,
                type: [],
                location: [],
                data: {
                    user_id: '',
                    user_name: '',
                    user_mobile: '',
                    type_id: '',
                    type: '',
                    location_id: '',
                    location: {
                        first: '',
                        second: ''
                    },
                    user_room: '',
                    user_description: '',
                    repair_description: '',
                    admin_description: []
                },
                rules: {
                    user_id: [
                        {required: true, message: '请输入报障人学号', trigger: 'blur'}
                    ],
                    user_name: [
                        {required: true, message: '请输入报障人姓名', trigger: 'blur'}
                    ],
                    user_mobile: [
                        {required: true, message: '请输入报障人手机号码', trigger: 'blur'}
                    ],
                    type_id: [
                        {type: 'number', required: true, message: '请选择报障分类', trigger: 'blur'}
                    ],
                    location_id: [
                        {type: 'number', required: true, message: '请选择报障地区', trigger: 'blur'}
                    ],
                    user_room: [
                        {required: true, message: '请输入故障房间号', trigger: 'blur'}
                    ],
                    user_description: [
                        {required: true, message: '请输入报障描述', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            getData() {
                this.flag = false
                this.$http.get(
                    '/api/admin/type/list'
                ).then((response) => {
                    if (response.status === 200) {
                        this.type = response.data
                    }
                })
                this.$http.get(
                    '/api/admin/repair/detail/' + this.$route.params.id
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.changeType(this.data.type_id)
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            changeType(type_id) {
                this.location = []
                if (this.flag) {
                    this.data.location_id = ''
                } else {
                    this.flag = true
                }
                this.$http.get(
                    '/api/admin/type/location/' + type_id + '/full'
                ).then((response) => {
                    if (response.status === 200) {
                        const data1 = response.data
                        for (const first in data1) {
                            if (data1.hasOwnProperty(first)) {
                                this.location.push({
                                    label: first,
                                    options: data1[first]
                                })
                            }
                        }
                    }
                })
            },
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/repair/update', this.data
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200) {
                                this.$notify.success({
                                    message: '修改成功',
                                    duration: 2000
                                })
                                this.getData()
                            }
                        })
                    }
                })
            },
            resetForm(data) {
                this.$refs[data].resetFields()
                this.getData()
            },
            acceptRepair() {
                this.lock = true
                this.$http.post(
                    '/api/admin/repair/change', {
                        id: this.data.id,
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
            finishRepair() {
                this.lock = true
                this.$http.post(
                    '/api/admin/repair/change', {
                        id: this.data.id,
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
            },
            deleteRepair() {
                this.$confirm('删除操作不可恢复，确认删除吗？', '提示', {
                    type: 'warning',
                    center: true
                }).then(() => {
                    this.lock = true
                    this.$http.post(
                        '/api/admin/repair/change', {
                            id: this.data.id,
                            type: 'delete'
                        }).then((response) => {
                        this.lock = false
                        if (response.status === 200) {
                            this.$notify.success({
                                message: '删除成功',
                                duration: 2000
                            })
                            this.getData()
                        }
                    })
                })
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>

<style>
    .repair-detail .title {
        padding: 10px 0 20px;
        font-size: 24px;
    }

    .repair-detail .detail {
        font-size: 0;
    }

    .repair-detail .detail label {
        width: 150px;
        color: #99a9bf;
    }

    .repair-detail .detail .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 100%;
    }
</style>
