<template>
    <div class="container">
        <apexchart type="pie" width="380" :options="chartOptions" :series="series"></apexchart>
        <el-table
            :data="tableData"
            style="width: 100%">
            <el-table-column
                prop="date"
                label="Date"
                width="180">
                <template slot-scope="{row}">
                    <span v-if="!row.edit">
                        {{row.date}}
                    </span>
                    <div v-else>
                        <el-input v-model="row.date" class="edit-input" size="small" />
                    </div>

                </template>
            </el-table-column>
            <el-table-column
                prop="name"
                label="Name"
                width="180">
            </el-table-column>
            <el-table-column
                prop="address"
                label="Address">
            </el-table-column>
            <el-table-column
                label="Action">
                <template slot-scope="{row}">
                    <el-button v-if="!row.edit" type="primary" size="small" @click="editAction(row)">Edit</el-button>
                    <el-button v-else type="primary" size="small" @click="saveAction(row)">Save</el-button>
                    <el-button type="danger" size="small" @click="deleteAction(row)">Delete</el-button>
                </template>

            </el-table-column>
        </el-table>
        <div class="pagination-right-align">
            <div class="block">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage"
                    :page-sizes="[100, 200, 300, 400]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="400">
                </el-pagination>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                series: [1, 2, 3, 4, 5,2,3,1,2,5,6],
                chartOptions: {
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E','Team F','Team G','H','I','A','D'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    dataLabels: {
                        formatter(val, opts) {
                            const name = opts.w.globals.series[opts.seriesIndex]
                            return [name]
                        }
                    },
                },
                tableData: [{
                    date: '2016-05-03',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                    edit:false
                }, {
                    date: '2016-05-02',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                    edit:false
                }, {
                    date: '2016-05-04',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                    edit:false
                }, {
                    date: '2016-05-01',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                    edit:false
                }],
                currentPage:5
            }
        },
        methods: {
            onLoaded() {
                this.isLoaded = !this.isLoaded
            },
            handleSizeChange(val) {
                console.log(`${val} items per page`);
            },
            handleCurrentChange(val) {
                console.log(`current page: ${val}`);
            },
            editAction(row){
               row.edit=true
            },
            saveAction(row){
               row.edit=false
            },
            deleteAction(row){
                var index = this.tableData.indexOf(row)
                this.tableData.splice(index,1)
            }
        }
    }
</script>
