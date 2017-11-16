<template>
    <div class="type-detail">
        <el-row>
            <el-col :md="12">
                <el-form :model="data" :rules="rules" ref="data" label-width="120px">
                    <el-form-item label="备件名称" prop="name">
                        <el-input v-model="data.name"></el-input>
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
                    name: ''
                },
                rules: {
                    name: [
                        {required: true, message: '请输入备件名称', trigger: 'blur'},
                        {max: 64, message: '维修备件的长度不得超过64个字符', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            getData() {
                this.$http.get(
                    '/api/admin/part/detail/' + this.$route.params.id
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/part/update', this.data
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200) {
                                this.$notify.success({
                                    message: '修改成功',
                                    duration: 2000
                                })
                                this.$router.replace('/part/list')
                            }
                        })
                    }
                })
            },
            resetForm(data) {
                this.$refs[data].resetFields()
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
