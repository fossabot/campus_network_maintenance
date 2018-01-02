<template>
    <div class="location-create">
        <el-row>
            <el-col :md="12">
                <el-tabs type="card" value="first">
                    <el-tab-pane label="新增一级区域" name="first">
                        <el-form :model="data1" :rules="rules" ref="data1" label-width="120px">
                            <el-form-item label="一级区域名称" prop="first">
                                <el-input v-model="data1.first"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" :loading="lock" @click="submitForm('data1')">新增</el-button>
                                <el-button @click="resetForm('data1')">重置</el-button>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane label="新增二级区域" name="second">
                        <el-form :model="data2" :rules="rules" ref="data2" label-width="120px">
                            <el-form-item label="一级区域名称" prop="first">
                                <el-select v-model="data2.first" filterable>
                                    <el-option v-for="item in first" :key="item.id" :label="item.first" :value="item.first"></el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="二级区域名称" prop="second">
                                <el-input v-model="data2.second"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" :loading="lock" @click="submitForm('data2')">新增</el-button>
                                <el-button @click="resetForm('data2')">重置</el-button>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lock: false,
                first: {},
                data1: {
                    first: ''
                },
                data2: {
                    first: '',
                    second: ''
                },
                rules: {
                    first: [
                        {required: true, message: '请输入一级区域', trigger: 'blur'},
                        {max: 64, message: '分类名称的长度不得超过64个字符', trigger: 'blur'}
                    ],
                    second: [
                        {required: true, message: '请输入二级区域', trigger: 'blur'},
                        {max: 128, message: '分类描述的长度不得超过64个字符', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            getFirst() {
                this.$http.get('/api/admin/location/first').then((response) => {
                    if (response.status === 200) {
                        this.first = response.data
                    }
                })
            },
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/location/create', this[data]
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200) {
                                this.$notify.success({
                                    message: '新增成功',
                                    duration: 2000
                                })
                                if (data === 'data1') {
                                    this.$router.replace('/location/list/first')
                                } else {
                                    this.$router.replace('/location/list/second')
                                }
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
            this.getFirst()
        }
    }
</script>
