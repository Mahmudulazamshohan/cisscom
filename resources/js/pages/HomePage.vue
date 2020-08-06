<template>
    <div class="container">
        <el-row>
            <el-col :span="18">
                <apexchart type="pie" width="380" :options="chartOptions"></apexchart>
            </el-col>
            <el-col :span="6">
                <input type="file"
                       ref="file_uploader"
                       @change="handleFileChange"
                       :style="{display:'none'}"
                       accept=".xlsx, .xls, .csv"
                >
                <el-button size="small" type="primary" @click="handleCsv">
                    Upload CSV
                </el-button>
                <el-button size="small" type="primary" @click="handleAdd">
                    Add
                </el-button>
            </el-col>
        </el-row>
        <data-table :items="products" :loading="loading" @item-rerender="itemRerender"/>
        <el-dialog title="Add Products" :visible.sync="visible">
            <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                <el-form-item label="Manufacturer" prop="manufacturer">
                    <el-input type="text" v-model="ruleForm.manufacturer" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="Model" prop="model">
                    <el-input type="text" v-model="ruleForm.model" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="Year" prop="year">
                    <el-input v-model.number="ruleForm.year"></el-input>
                </el-form-item>
                <el-form-item label="Country" prop="country">
                    <el-input v-model.number="ruleForm.country"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="visible = false">Cancel</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">
                    Add
                </el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import DataTable from '../components/DataTable.vue'

    export default {
        components: {
            DataTable
        },
        created() {

        },
        mounted() {
            this.fetchProducts()

        },

        data() {
            return {
                chartOptions: {},
                products: [],
                loading: true,
                visible: false,
                ruleForm: {
                    manufacturer: '',
                    model: '',
                    year: '',
                    country:''
                },
                rules: {
                    manufacturer: [
                        { required: true, message: 'Please input manufacturer', trigger: 'blur' },
                    ],
                    model: [
                        { required: true, message: 'Please input model', trigger: 'blur' },
                    ],
                    year: [
                        { required: true, message: 'Please input year', trigger: 'blur' },
                    ] ,
                    country: [
                        { required: true, message: 'Please input country', trigger: 'blur' },
                    ]
                }

            }
        },
        methods: {
            onLoaded() {
                this.isLoaded = !this.isLoaded
            },
            handleCsv() {
                this.$refs.file_uploader.click()
            },
            handleAdd() {
                this.visible = true
            },
            handleFileChange(e) {
                var file = e.target.files[0]
                var formData = new FormData()
                formData.append('csv_file', file)
                axios.post('api/products', formData)
                    .then(res => {
                        console.log(res)
                    })
                this.$refs.file_uploader.value = ''
            },
            fetchProducts() {
                axios.get('api/products')
                    .then(({data}) => {
                        var data = data.data
                        this.products = data.products
                        this.loading = false
                        var labels = data.product_counts.map(product_count => {
                            return product_count.manufacturer
                        })
                        var series = data.product_counts.map(product_count => {
                            return product_count.total
                        })
                        this.chartOptions = {
                            chart: {
                                width: 380,
                                type: 'pie',
                            },
                            series,
                            labels,
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
                        }
                        //this.chartOptions.labels =
                    })
            },
            itemRerender(row) {
                //alert(row.id)
                this.fetchProducts()
            },
            submitForm(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post('api/products',this.ruleForm)
                            .then((res)=>{
                              //  console.log(res)
                                this.visible =false
                                this.fetchProducts()
                                this.$refs[formName].resetFields();
                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }


        }
    }
</script>
