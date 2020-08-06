<template>
    <div>
        <div class="search-right-align">
            <div class="input-box">
                <el-input
                    prefix-icon="el-icon-search"
                    type="text"
                    size="small"
                    placeholder="Search from here"
                    v-model="search"
                    @keydown="handleSearchChange"
                ></el-input>
                <el-button
                    icon="el-icon-printer"
                    type="primary"
                    size="small"
                    v-print="printObj"
                >
                </el-button>
            </div>

        </div>
        <el-table
            v-loading="loading"
            :data="itemList"
            style="width: 100%"
            id="table-print">

            <el-table-column
                prop="manufacturer"
                label="Manufacturer"
                width="180">
                <template slot-scope="{row}">
                    <span v-if="!row.edit">
                        {{row.manufacturer}}
                    </span>
                    <div v-else>
                        <el-input v-model="row.manufacturer" class="edit-input" size="small"/>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                prop="model"
                label="Model"
                width="180">
                <template slot-scope="{row}">
                    <span v-if="!row.edit">
                        {{row.model}}
                    </span>
                    <div v-else>
                        <el-input v-model="row.model" class="edit-input" size="small"/>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                prop="year"
                label="Year">
                <template slot-scope="{row}">
                    <span v-if="!row.edit">
                        {{row.year}}
                    </span>
                    <div v-else>
                        <el-input v-model="row.year" class="edit-input" size="small"/>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                prop="country"
                label="Country">
                <template slot-scope="{row}">
                    <span v-if="!row.edit">
                        {{row.country}}
                    </span>
                    <div v-else>
                        <el-input v-model="row.country" class="edit-input" size="small"/>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                label="Action">
                <template slot-scope="{row}">
                    <el-button v-if="!row.edit" icon="el-icon-edit" type="primary" size="small"
                               @click="editAction(row)">Edit
                    </el-button>
                    <el-button v-else type="primary" size="small" @click="updateAction(row)">Save</el-button>
                    <el-button icon="el-icon-delete" type="danger" size="small" @click="deleteAction(row)">Delete
                    </el-button>
                </template>

            </el-table-column>
        </el-table>
        <div class="pagination-right-align">
            <div class="block">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage"
                    :page-sizes="[5, 10, 20, 30]"
                    :page-size="itemsPerPage"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="2">
                </el-pagination>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "DataTable",
        props: ['items', 'loading'],
        data() {
            return {
                currentPage: 1,
                itemsPerPage:5,
                totalPages:0,
                printObj: {
                    id: "table-print",
                    popTitle: 'Product details',
                },
                search: ''
            }
        },
        mounted() {
        },
        methods: {
            handleSizeChange(size) {
                this.itemsPerPage = size
            },
            handleCurrentChange(page) {
                this.currentPage = page
            },
            editAction(row) {
                console.log(row)
                row.edit = true
            },
            updateAction(row) {
                row.edit = false
                axios.put(`api/products/${row.id}`,row)
                    .then(res => {
                        this.$emit('item-rerender', row)
                    })
            },
            deleteAction(row) {
                var index = this.items.indexOf(row)
                this.items.splice(index, 1)
                axios.delete(`api/products/${row.id}`)
                    .then(res => {
                        this.$emit('item-rerender', row)
                    })

            },
            handleSearchChange(e) {
                console.log(e)
            }
        },
        computed: {
            itemList() {
                if(this.currentPage >= this.itemsPerPage){
                    this.currentPage = this.totalPages;
                }
                this.totalPages = (this.items.length % this.itemsPerPage) + 1
                // console.log(this.items.length % this.itemsPerPage)
                var index = this.currentPage * this.itemsPerPage - this.itemsPerPage
                var searchResults = this.items.filter(item => {
                    return item.model.toLowerCase().includes(this.search.toLowerCase()) || item.manufacturer.toLowerCase().includes(this.search.toLowerCase())
                })
                return searchResults.slice(index, index + this.itemsPerPage)
            }
        }
    }
</script>

<style scoped>

</style>
