<template>
    <div class="type-create">
        <el-row>
            <el-col :md="12">
                <el-form :model="data" :rules="rules" ref="data" label-width="120px">
                    <el-form-item label="分类名称" prop="name">
                        <el-input v-model="data.name"></el-input>
                    </el-form-item>
                    <el-form-item label="分类描述" prop="introduction">
                        <el-input v-model="data.introduction"></el-input>
                    </el-form-item>
                    <el-form-item label="自动完成时间" prop="auto_complete_hours">
                        <el-input-number v-model="data.auto_complete_hours" :min="0" :max="720"></el-input-number>
                        <span>小时</span> <span class="tip">（0为禁止报障单自动完成）</span>
                    </el-form-item>
                    <el-form-item label="用户默认评价" prop="auto_complete_stars">
                        <el-input-number v-model="data.auto_complete_stars" :min="1" :max="5"></el-input-number>
                        <span>星</span> <span class="tip">（1星最低 5星最高）</span>
                    </el-form-item>
                    <el-form-item label="需要用户验证" prop="real_user_auth">
                        <el-switch v-model="data.real_user_auth"></el-switch>
                        <span class="tip">（是否验证学号姓名）</span>
                    </el-form-item>
                    <el-form-item label="允许用户创建" prop="allow_user_create">
                        <el-switch v-model="data.allow_user_create"></el-switch>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" :loading="lock" @click="submitForm('data')">新增</el-button>
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
                    name: '',
                    introduction: '',
                    auto_complete_hours: 0,
                    auto_complete_stars: 5,
                    real_user_auth: true,
                    allow_user_create: true
                },
                rules: {
                    name: [
                        {required: true, message: '请输入分类名称', trigger: 'blur'},
                        {max: 64, message: '分类名称的长度不得超过64个字符', trigger: 'blur'}
                    ],
                    introduction: [
                        {max: 128, message: '分类描述的长度不得超过64个字符', trigger: 'blur'}
                    ],
                    auto_complete_hours: [{required: true}],
                    auto_complete_stars: [{required: true}],
                    real_user_auth: [{required: true}],
                    allow_user_create: [{required: true}]
                }
            }
        },
        methods: {
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/type/create', this.data
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200 && parseInt(response.data)) {
                                this.$notify.success({
                                    message: '新增成功',
                                    duration: 2000
                                })
                                this.$router.replace('/type/list')
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

<style>
    .type-create .tip {
        color: #878D99;
    }
</style>
