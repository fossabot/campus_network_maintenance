<template>
    <el-container class="login" style="height: 100%;">
        <el-header>
            <div style="text-align: center;padding-top: 50px;">
                <img src="/statics/img/logo.png" style="width: 95%;max-width: 420px;">
            </div>
        </el-header>
        <el-main style="height: 100%;">
            <el-row type="flex" justify="center" style="margin-top: 200px;">
                <el-col :md="8">
                    <el-form :model="data" :rules="rules" ref="data" label-width="100px">
                        <el-form-item label="管理员帐号" prop="username">
                            <el-input v-model="data.username" @keyup.enter.native="submitForm('data')"></el-input>
                        </el-form-item>
                        <el-form-item label="管理员密码" prop="password">
                            <el-input type="password" v-model="data.password" @keyup.enter.native="submitForm('data')"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" :loading="lock" @click="submitForm('data')">立即登录</el-button>
                            <el-button @click="resetForm('data')">重置</el-button>
                        </el-form-item>
                    </el-form>
                </el-col>
            </el-row>
        </el-main>
        <el-footer style="text-align: center;height: 200px;">
            <p>版权所有，保留一切权利！</p>
            <p>Copyright © {{ (new Date()).getFullYear() }} <b>江苏科技大学 张家港校区/苏州理工学院</b></p>
        </el-footer>
    </el-container>
</template>

<script>
    export default {
        data() {
            return {
                lock: false,
                data: {
                    username: '',
                    password: ''
                },
                rules: {
                    username: [
                        {required: true, message: '请输入管理员帐号', trigger: 'blur'},
                        {min: 6, max: 24, message: '管理员帐号长度必须是6-24个字符', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '请输入管理员密码', trigger: 'blur'},
                        {min: 6, max: 24, message: '管理员密码长度必须是6-24个字符', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/auth/login', this.data
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200 && response.data === 'success') {
                                this.$notify.success({
                                    message: '登录成功',
                                    duration: 2000
                                })
                                window.location.href = '/admin'
                            }
                        })
                    }
                })
            },
            resetForm(data) {
                this.$refs[data].resetFields()
            }
        }
    }
</script>
