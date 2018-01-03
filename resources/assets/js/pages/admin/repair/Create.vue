<template>
    <div class="repair-create">
        <el-row>
            <el-col :md="12">
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
                    <el-form-item label="报障区域" prop="location_id">
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
                        <el-select v-model="data.user_description" @change="changeDescription">
                            <el-option v-for="item in description" :key="item.id" :label="item.description" :value="item.description"></el-option>
                        </el-select>
                        <el-input type="textarea" v-if="showDescription" v-model="data.user_description" :autosize="{minRows: 3}" style="margin-top: 22px;"></el-input>
                    </el-form-item>
                    <el-form-item label="维修完成">
                        <el-switch v-model="data.repair"></el-switch>
                    </el-form-item>
                    <el-form-item label="维修备注" v-if="data.repair" required>
                        <el-input type="textarea" v-model="data.repair_description" :autosize="{minRows: 3}"></el-input>
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
                type: [],
                location: [],
                description: [],
                showDescription: false,
                data: {
                    user_id: '',
                    user_name: '',
                    user_mobile: '',
                    type_id: '',
                    location_id: '',
                    user_room: '',
                    user_description: '',
                    repair: false,
                    repair_description: ''
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
                        {type: 'number', required: true, message: '请选择报障区域', trigger: 'blur'}
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
                this.$http.get(
                    '/api/admin/type/list'
                ).then((response) => {
                    if (response.status === 200) {
                        this.type = response.data
                    }
                })
            },
            getDescription(type) {
                this.$http.get(
                    '/api/admin/description/list/' + type
                ).then((response) => {
                    if (response.status === 200) {
                        this.description = response.data
                        this.description.push({id: 0, description: '其他'})
                        this.$message.success({
                            message: '获取成功'
                        })
                    }
                })
            },
            changeType(type_id) {
                this.getDescription(type_id)
                this.location = []
                this.data.location_id = ''
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
            changeDescription(description) {
                this.showDescription = description === '其他';
            },
            submitForm(data) {
                this.$refs[data].validate((valid) => {
                    if (valid) {
                        this.lock = true
                        this.$http.post(
                            '/api/admin/repair/create', this.data
                        ).then((response) => {
                            this.lock = false
                            if (response.status === 200) {
                                this.$notify.success({
                                    message: '新增成功',
                                    duration: 2000
                                })
                                this.$router.replace('/repair/detail/' + response.data)
                            }
                        })
                    }
                })
            },
            resetForm(data) {
                this.$refs[data].resetFields()
                this.showDescription = false
                this.getData()
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
