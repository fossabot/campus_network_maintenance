<template>
    <div class="description-detail">
        <el-row>
            <el-col :md="12">
                <el-form :model="data" :rules="rules" ref="data" label-width="120px">
                    <el-form-item label="维修分类" prop="type_id">
                        <el-select v-model="data.type_id" filterable>
                            <el-option v-for="item in type" :key="item.id" :label="item.name" :value="item.id"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="故障类别描述" prop="description">
                        <el-input type="textarea" v-model="data.description" :autosize="{minRows: 3}"></el-input>
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
                type: [],
                lock: false,
                data: {
                    type_id: '',
                    description: ''
                },
                rules: {
                    type_id: [
                        {type: 'number', required: true, message: '请选择维修分类', trigger: 'blur'}
                    ],
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
                    '/api/admin/description/detail/' + this.$route.params.id
                ).then((response) => {
                    if (response.status === 200) {
                        this.data = response.data
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
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/description/update', this.data
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
            }
        },
        mounted() {
            this.getData()
            this.getType()
        }
    }
</script>
