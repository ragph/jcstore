<template>
    <div class="container">
       <section  v-if="$gate.isCashier() | $gate.isStaff() | $gate.isManager() | $gate.isAdmin()">
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
      <section v-if="$gate.isRenter()">
          <div class="row justify-content-center" >
             <form @submit.prevent="searchProduct" class="form-inline float-sm-right" style="width:100%">
               <div class="col-md-2"></div>
                <div class="col-md-8 ">
                    <button type="submit" class="btn btn-primary float-sm-right mb-2">Search</button>
                    <input type="text" class="form-control float-sm-right mr-2" v-model="searchForm.searchForm" name="searchForm.searchForm" placeholder="Search..">
                </div>
              <div class="col-md-2"></div>
            </form>
          </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-2" v-for="item in products.data" :key="item.id ">
                    <div class="card-body" style="padding:15px;border-left:4px solid #2c3e50">
                      <div class="row">
                        <div class="col-md-12">
                          <label>SKU:</label> {{item.sku}}
                        </div>
                        <div class="col-md-12">
                          <label>Product name:</label> {{item.product_name}}
                        </div>
                      </div>
                      <div class="row">
                         <div class="col-md-5">
                          <label style="color:#3498db">Cost price:</label> {{item.cost_price | toCurrency}}
                        </div>
                        <div class="col-md-4">
                          <label>Sell price:</label> {{item.sell_price | toCurrency}}
                        </div>
                        <div class="col-md-3">
                          <label style="color:#34495e">On hand:</label> {{item.final_onhand}}
                        </div>

                      </div>
                    </div>
                </div>
                  <div class="card-footer">
                    <pagination :data="products" @pagination-change-page="searchProduct" :limit="1"></pagination>
                  </div>
            </div>
        </div> <!-- end row -->
        </section>
    </div><!-- end container -->
</template>

<script>
    export default {
       data() {
          return {
            userid: "",
             branchid: "",
            products: {},
            searchForm: new Form({
                    searchForm: "",
                }),
          };
       },
      methods: {
        searchProduct: function(page = 1){
          this.userid = this.$gate.Userprofile();
            this.branchid = this.$gate.Userprofile();
            console.log(this.branchid.branch_id);
            this.searchForm.post("api/renterproducts?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id  + "&page=" + page ).then(({ data }) => {
              this.products = data;
            });
        }
      },
      created() {
        this.searchProduct();
      },
        mounted() {
           this.searchProduct();
            console.log('Component mounted.')
        }
    }
</script>
