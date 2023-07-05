<template>
    <div class="container-fluid">
                   <section  v-if="$gate.report_null()">
            <div class="row">
                <div class="col-sm-6">
                    <h3 style="color:#34495e"> 404 Error Page</h3>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active">404 Error Page </li>
                    </ol>
                </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <section class="content text-center">
                            <div class="error-page">
                                <h2 class="headline text-warning"> 404</h2>

                                <div class="error-content">
                                    <h3><i class="fa fa-exclamation-triangle text-warning"></i> Oops! Page not found.
                                    </h3>
                                    <p>
                                        We could not find the page you were looking for.
                                        Meanwhile, you may <router-link to="/dashboard">return to dashboard
                                        </router-link>
                                    </p>
                                </div>
                                <!-- /.error-content -->
                            </div>
                            <!-- /.error-page -->
                        </section>
                    </div>
                </div>
        </section>
        <section  v-if="$gate.report_is_NOTnull()">
            <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> VOID SALES</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> <router-link to="/report">Reports</router-link></li>
                        <li class="breadcrumb-item active"> Void sales</li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>

                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchCube" style="width:100%">
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search key:</label>
                                <input type="text" class="form-control" placeholder="Search ..." v-model="searchForm.searchForm" name="searchForm">
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date released from:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.from" name="from">
                            </div>
                        </div>
                           <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date released to:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > --> 
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.to" name="to">
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="ss.reference_no">Invoice #</option>
                                <option value="ss.sale_type">Sales type</option>
                                 <option value="ss.total_items">Quantity</option>
                                 <option value="ss.total_payment">Total</option>
                                 <option value="ss.updated_at">Date void</option>
                                </select>
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                               <button class="btn btn-info float-sm-right btn-block" style="color:white" type="submit">
                                   <i class="fa fa-search" aria-hidden="true"></i> Search
                                </button>
                            </div>
                        </div>
                     </form>

                        <!-- <div class="col-md-12">
                            <div class="form-group clearfix">
                              <label class="pr-2 "> Utilities:</label>
                              <br>

                               <downloadexcel class="btn btn-info btn-block export mb-2" style="color:white" :fields = "void_fields" :fetch="exportData" name="Void sales.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                            </div>
                        </div>


                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <router-link to="/report"><button class="btn btn-success float-sm-right btn-block">Back to reports</button></router-link>
                            </div>
                        </div> -->

                    </div>
                </div>

                <div class="col-md-10">
                <p>Total cube: {{total}}</p>
                    <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Products</th>
                                        <th>Sales type</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Date void</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in cube.data" :key="index ">
                                        <td>{{item.reference_no}}</td>
                                        <td>
                                            <ul class="list-group"  style="list-style:none">
                                                <li v-for="(product_data, index) in item.salesproduct" :key="index" >
                                                <template v-if="index <= 2">
                                                    <p>
                                                    {{product_data.sku}} - {{product_data.product_name}}
                                                    </p>
                                                    </template>
                                                </li>
                                            </ul>
                                        </td>
                                        
                                        <td><p>{{item.sale_type == 'direct' ? item.sale_type : 'Customer' | capitalize}}</p></td>
                                        <td>
                                            <ul class="list-group"  style="list-style:none">
                                                <li v-for="(product_data, index) in item.salesproduct" :key="product_data.id" >
                                                    <template v-if="index <= 2">
                                                    <p>
                                                    {{product_data.quantity}}
                                                    </p>
                                                    </template>
                                                </li>
                                            </ul>
                                        </td>
                                        <td>{{item.total_items | toCurrency}}</td>
                                        <td>{{item.updated_at | myDate}}</td>
                                    </tr>
                                </tbody>
                            </table>
                         </div><!---- end car body ------->
                         <div class="card-footer">
                             <pagination :data="cube" @pagination-change-page="searchCube" :limit="1"></pagination>
                        </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
    </div> <!---- container------>
</template>

<script>
import downloadexcel from "vue-json-excel";
import moment from 'moment';
    export default {

     components: {
          downloadexcel,
      },
        data() {
            return {
            cube : {},
            total: "",
            void_fields: {
                'Invoice #': 'reference_no',
                'Products': 'product_name',
                'Sales type' : {
                    field: 'sale_type',
                        callback: (value) => {
                            if(value == 'direct'){
                                return 'Direct';
                            }else{
                                return 'Customer'
                            }
                        }
                },
                'Quantity': 'quantity',
                'Total': 'total_items',
                'Date void': {
                    field: 'updated_at',
                        callback: (value) => {
                            return moment(value).format('MMM. DD, YYYY ');
                        }
                },
            },
            searchForm: new Form({
                   searchForm:"",
                    sort: "",
                    from: '',
                    to: '',
                }),
        };
        },
        methods:{
          async exportData(page = 1){
             const response = await this.searchForm.post("api/voidsalesreport?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
         searchCube(page = 1){
              this.searchForm
                    .post("api/voidsalesreport?page=" + page)
                        .then((data) => {
                            this.cube = data.data;
                            // this.total = data.data.total;
                        })
                        .catch(() => {
                        });
          },
        },
        created() {
           this.searchCube();
         },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
