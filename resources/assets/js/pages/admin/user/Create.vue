<template>
    <div class="user-create">
        <el-row>
            <el-col :md="12">
                <el-form :model="data" :rules="rules" ref="data" label-width="120px">
                    <el-form-item label="维修分类" prop="type_id">
                        <el-select v-model="data.type_id" filterable>
                            <el-option v-for="item in type" :key="item.id" :label="item.name" :value="item.name"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="管理员帐号" prop="username">
                        <el-input v-model="data.username"></el-input>
                    </el-form-item>
                    <el-form-item label="管理员密码" prop="password">
                        <el-input v-model="data.password"></el-input>
                    </el-form-item>
                    <el-form-item label="管理员姓名" prop="name">
                        <el-input v-model="data.name"></el-input>
                    </el-form-item>
                    <el-form-item label="手机号码" prop="mobile">
                        <el-input v-model="data.mobile"></el-input>
                    </el-form-item>
                    <el-form-item label="公司名称" prop="company">
                        <el-input v-model="data.company"></el-input>
                    </el-form-item>
                    <el-form-item label="设为管理员" prop="role_id" required>
                        <el-switch v-model="data.role_id"></el-switch>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" :loading="lock" @click="submitForm('data')">修改</el-button>
                        <el-button @click="resetForm('data')">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lock: false,
                type: [],
                data: {
                    type_id: '',
                    username: '',
                    password: '',
                    name: '',
                    mobile: '',
                    company: '',
                    role_id: ''
                },
                rules: {
                    type_id: [
                        {required: true, message: '请选择维修分类', trigger: 'blur'}
                    ],
                    username: [
                        {required: true, message: '请输入管理员帐号', trigger: 'blur'},
                        {min: 6, max: 24, message: '管理员帐号长度必须是6-24个字符', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '请输入管理员密码', trigger: 'blur'},
                        {min: 6, max: 24, message: '管理员密码长度必须是6-24个字符', trigger: 'blur'}
                    ],
                    name: [
                        {required: true, message: '请输入管理员姓名', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            getData() {
                this.$http.get(
                    '/api/admin/type/list'
                ).then((response) => {
                    if (response.status === 200) {
                        this.type = response.data
                    }
                })
            },
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/user/create', this.data
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200) {
                                this.$notify.success({
                                    message: '修改成功',
                                    duration: 2000
                                })
                                if (this.password) {
                                    window.location.href = '/admin'
                                } else {
                                    this.getData()
                                }
                            }
                        })
                    }
                })
            },
            resetForm(data) {
                this.$refs[data].resetFields()
                this.getData()
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
