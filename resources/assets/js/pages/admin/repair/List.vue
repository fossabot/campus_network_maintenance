<template>
    <div class="type-list">
        <el-table :data="data" border stripe>
            <el-table-column prop="name" label="分类名称" width="200"></el-table-column>
            <el-table-column prop="introduction" label="分类描述"></el-table-column>
            <el-table-column label="操作">
                <el-button size="mini">编辑</el-button>
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
                data: [
                    {
                        id: 1,
                        name: '校园网络报障',
                        introduction: '校园网络报障'
                    }
                ]
            }
        },
        methods: {
            getData() {
                console.log(this.per)
                console.log(this.page)
            },
            handleSizeChange(val) {
                this.per = val
                this.getData()
            },
            handleCurrentChange(val) {
                this.page = val
                this.getData()
            }
        }
    }
</script>
