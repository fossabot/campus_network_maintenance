<template>
    <div class="profile-detail">
        <el-row>
            <el-col :md="12">
                <el-form :model="data" :rules="rules" ref="data" label-width="120px">
                    <el-form-item label="管理员帐号" prop="username">
                        <el-input v-model="data.username" disabled></el-input>
                    </el-form-item>
                    <el-form-item label="管理员密码" prop="password">
                        <el-input v-model="data.password" placeholder="不修改密码请留空"></el-input>
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
                data: {
                    username: '',
                    password: '',
                    name: '',
                    mobile: '',
                    company: ''
                },
                rules: {
                    password: [
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
                    '/api/admin/user/detail/' + window.admin.id
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    } else {
                        this.$router.go(-1)
                    }
                })
            },
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/user/update', this.data
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
