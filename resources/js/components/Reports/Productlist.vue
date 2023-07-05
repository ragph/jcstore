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
                      <h3 style="color:#34495e"> PRODUCT LIST</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> <router-link to="/report">Reports</router-link></li>
                        <li class="breadcrumb-item active"> Product list</li>
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

                    <form @submit.prevent="searchProducts" style="width:100%">
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search key:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="text" class="form-control" placeholder="Search ..." v-model="searchForm.renter" name="renter">
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="ps.sku">SKU</option>
                                 <option value="ps.product_name">Product name</option>
                                <option value="ps.cost_price">Cost price</option>
                                <option value="ps.sell_price">Sell price</option>
                                  <option value="r.fullname">Renter's name</option>
                                   <option value="b.name">Branch</option>
                                    <option value="bo.box_number">Cube #</option>
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

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                              <label class="pr-2 "> Utilities:</label>
                              <br>
                              <downloadexcel class="btn btn-info btn-block export mb-2" style="color:white" :fields = "products_fields" :fetch="exportData" name="Product list.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                            </div>
                        </div>


                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <router-link to="/report"><button class="btn btn-success float-sm-right btn-block">Back to reports</button></router-link>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-10">
                <p>Total products: {{total}}</p>
                    <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Product name</th>
                                         <th>Cost price</th>
                                         <th>Sell price</th>
                                        <th>Renter's name</th>
                                        <th>Branch</th>
                                         <th>Cube #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in products.data" :key="index ">
                                        <td>{{item.sku}}</td>
                                        <td>{{item.product_name}}</td>
                                        <td>{{item.cost_price}}</td>
                                        <td>{{item.sell_price}}</td>
                                        <td>{{item.fullname}}</td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.box_number}}</td>
                                    </tr>
                                </tbody>
                            </table>
                         </div><!---- end car body ------->
                         <div class="card-footer">
                             <pagination :data="products" @pagination-change-page="searchProducts" :limit="1"></pagination>
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
    export default {

     components: {
          downloadexcel,
      },
        data() {
            return {
            products : {},
            total: "",
             products_fields: {
                  'Product name': 'product_name',
                  'SKU': 'sku',
                  'Cost price' : 'cost_price',
                  'Sell price' : 'sell_price',
                  'Renters name' : 'fullname',
                  'Branch' : 'name',
                  'Cube #' : 'box_numner',
                  },
            searchForm: new Form({
                   renter:"",
                    sort: "",
                }),
        };
        },
        methods:{
          async exportData(page = 1){
             const response = await this.searchForm.post("api/reportproducts?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
         searchProducts(page = 1){
              this.searchForm
                    .post("api/reportproducts?page=" + page)
                        .then((data) => {
                            this.products = data.data;
                            this.total = data.data.total;
                        })
                        .catch(() => {
                        });
          },
        },
        created() {
           this.searchProducts();
         },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
