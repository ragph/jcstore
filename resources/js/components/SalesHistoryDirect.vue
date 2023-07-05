<template>
    <div class="container-fluid">
       <section  v-if="$gate.pos_null()">
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
        <section v-if="$gate.pos_is_NOTnull()">
             <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> DIRECT SALES HISTORY - Lyrra</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Direct sales history</li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <!-- <div class="col-md-12 pb-2">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addRetrunSale" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Return sale
                            </button>

                        </div> -->
                        <form @submit.prevent="deleteSelectProduct" style="width:100%">
                          <div class="col-md-12 pb-2" v-if="$gate.pos_Delete_() | $gate.pos_Add_Delete() | $gate.pos_Edit_Delete() | $gate.pos_Add_Edit_Delete()">
                            <button class="btn btn-danger btn-block" type="submit">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete history
                            </button>
                        </div>
                     </form>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchSaleHistory" style="width:100%">
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search key:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="text" class="form-control" placeholder="Search" v-model="searchForm.searchForm" :class="{ 'is-invalid': searchForm.errors.has('searchForm') }" name="searchForm">
                                  <!-- <has-error :form="searchForm" field="searchForm"></has-error> -->
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date from:</label>
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.dateFrom" name="renter">
                            </div>
                        
                        </div>
                           <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date to:</label>
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.dateTo" name="renter">
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="ss.reference_no">Invoice #</option>
                                <!-- <option value="asc">Product name</option> -->
                                <!-- <option value="asc">Quantity</option> -->
                                <option value="ss.total_items">Total</option>
                                <option value="ss.created_at">Date</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sortby" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="asc">A-Z</option>
                                <option value="desc">Z-A</option>
                                </select>
                            </div>
                        </div> -->

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
                              <router-link to="/usermanagement">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-users" aria-hidden="true"></i> User management
                                  </button>
                                </router-link>
                            </div>
                        </div>


                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <router-link to="/dashboard"><button class="btn btn-success float-sm-right btn-block">Back to dashboard</button></router-link>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-10">
                     <p>Total sales: {{total}}<br/>
                     Total amount: {{totalAmount}}</p>
                    <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                        <div class="card-body">
                           <div id="accordion">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" :id="'selectProduct'" @click="selectAllProduct" v-model="checkAll">
                                            <label :for="'selectProduct'"></label>
                                        </div>
                                        Select all
                                        </th>
                                        <th>Invoice #</th>
                                        <th>Product name</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="(item, i) in history.data" :key="item.id" data-toggle="collapse" :data-target="'#collapseOne'+i" aria-expanded="true" aria-controls="collapseOne">

                                     <th>
                                          <div class="icheck-primary d-inline">
                                            <input type="checkbox" :id="'select' + item.id" v-model="selectForm.productID" :value="item.id">
                                             <label :for="'select' + item.id"></label>
                                          </div>
                                        </th>
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
                                                  <li v-for="(product_data, index) in item.salesproduct" :key="product_data.id" :id="'collapseOne'+i" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" >
                                                      <template v-if="index > 2">
                                                  <p  >
                                                     {{product_data.sku}} - {{product_data.product_name}}
                                                  </p>
                                                  </template>
                                                </li>
                                              </ul>
                                            </td>
                                           <td>
                                              <ul class="list-group"  style="list-style:none">
                                                <li v-for="(product_data, index) in item.salesproduct" :key="product_data.id" >
                                                    <template v-if="index <= 2">
                                                  <p>
                                                   {{product_data.quantity}}
                                                  </p>
                                                  </template>
                                                </li>
                                                  <li v-for="(product_data, index) in item.salesproduct" :key="product_data.id" :id="'collapseOne'+i" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" >
                                                 <template v-if="index > 2">
                                                  <p >
                                                  {{product_data.quantity}}
                                                  </p>
                                                  </template>
                                                </li>
                                              </ul>
                                            </td>
                                            <td>{{item.total_items | toCurrency}}</td>
                                             <td>{{item.created_at | myDate}}</td>
                                        <td>
                                            <button v-if="$gate.pos_Edit_() | $gate.pos_Add_Edit() | $gate.pos_Edit_Delete() | $gate.pos_Add_Edit_Delete()" class="btn btn-success" @click="editItem(item)"><i class="fa fa-file" aria-hidden="true"></i> View invoice </button>
                                            <button v-if="$gate.pos_Delete_() | $gate.pos_Add_Delete() | $gate.pos_Edit_Delete() | $gate.pos_Add_Edit_Delete()" class="btn btn-danger" @click="deleteHistory(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                          </div> <!-- end accordion -->
                         </div><!-- end car body -->
                         <div class="card-footer">
                             <pagination :data="history" @pagination-change-page="searchSaleHistory" :limit="1"></pagination>
                        </div>
                    </div><!--- end card -->
                </div>
            </div> <!-- row -->
        </section>

        <section>
            <div class="modal fade" id="ViewInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl"  role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="printInvoice()">
                        <div class="modal-body" id="invoice" style=" font-family:  'Courier New', Courier, monospace;">
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <!-- <h5 style="color:#ff7979;font-weight:bold">JUZEL CONCEPT STORE</h5> -->
                                    <!-- <label>{{branch.branch_name}} {{branch.address}}</label><br> -->
                                    <!-- <label> {{form.}}</label> -->
                                    <!-- <label>09523285456 / 08469952322</label> -->
                                    <h5><strong>INVOICE</strong></h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-5">
                                   <table class="table table-borderless invoice-table">

                                           <tr>
                                               <td><label>Invoice no.</label></td>
                                                <td><label>{{form.reference_no}}</label></td>
                                           </tr>
                                           <tr>
                                               <td><label>Employee:</label></td>
                                                <td><label>{{form.username}}</label></td>
                                           </tr>
                                           <tr>
                                               <td><label>Date/Time:</label></td>
                                                <td><label>{{form.created_at | myDateTime}}</label></td>
                                           </tr>

                                   </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Items</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in form.salesproduct" :key="item.id ">
                                                <td>{{item.sku}} - {{item.product_name}}</td>
                                                <td>{{item.quantity}}</td>
                                                <td>{{item.price | toCurrency}}</td>
                                                <td>{{item.subtotal | toCurrency}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <label>Total:</label><br>
                                                    <!-- <label>Tax:</label><br> -->
                                                    <!-- <label>Total payment:</label><br>
                                                    <label>Change:</label> -->
                                                </td>
                                                <td>
                                                    <label>{{form.total_items | toCurrency }}</label><br>
                                                    <!-- <label>{{form.tax | toCurrency }}</label><br> -->
                                                    <!-- <label>{{form.payment | toCurrency }}</label><br>
                                                    <label>{{form.total_payment | toCurrency }}</label> -->
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="voidInvoice()">Void</button>
                        <button type="submit" class="btn btn-primary">Print invoice</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->


    </div> <!-- container -->
</template>

<script>
import VueUploadMultipleImage from 'vue-upload-multiple-image';
    export default {
     components: {
        VueUploadMultipleImage,
      },
        data() {
            return {
                total: "",
                totalAmount: 0,
                editmode:false,
                checkAll: false,
                branch: {},
                history: {},
                searchForm: new Form({
                    id: '',
                    searchForm: '',
                    sort: "",
                    sortby: 'desc',
                    dateFrom: '',
                    dateTo: '',
                }),
                 selectForm: new Form({
                    productID: [],
                }),
                form: new Form({
                    id: '',
                    reference_no: '',
                    payment: '',
                    total_items: '',
                    created_at: '' ,
                    salesproduct: '',
                    tax:'',
                    username:'',
                    total_payment:'',
                    name:'',
                }),
            };
        },
        methods:{
            voidInvoice(){
            Swal.fire({
                    // title: "Are you sure?",
                    text: "Are you sure you want to void?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm"
                }).then(result => {
                    // DELETE USER API
                    if (result.value) {
                       
                        this.form.post("api/voidsalehistory")
                            .then((data) => {
                                    Swal.fire("Void!", "Record has been successfully void", "success");
                                    $("#ViewInvoice").modal("hide");
                                    Fire.$emit("AfterCreate");
                            })
                            .catch(() => {
                                    Swal.fire("You cant delete this record", "This product is used on other transactions.", "error");
                            });
                    }
                });
        },  
             selectAllProduct: function() {
            this.checkAll = !this.checkAll;
                this.selectForm.productID = [];
                if(this.checkAll){ // Check all
                  for (var i in this.history['data']) {
                        this.selectForm.productID.push(this.history['data'][i]['id']);
                    }
                }
        },
        deleteSelectProduct:function(){
            if(this.selectForm.productID.length == 0){
                Swal.fire("Please select product", "", "error");
            }else{
                  Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    // DELETE USER API
                    if (result.value) {
                            this.selectForm.post("api/selectSaleHs")
                        .then((data) => {
                                Swal.fire("Deleted!", "Record has been successfully deleted", "success");
                                Fire.$emit("AfterCreate");
                    })
                        .catch(() => {
                                Swal.fire("You cant delete this record", "This product is used on other transactions.", "error");
                        });
                    }
                });
            }
        },
            printInvoice(){
                this.form
                    .post("http://localhost/printtest/api/printfile")
                        .then((data) => {
                            console.log(data);
                        })
                        .catch(() => {

                        });
                // var divContents = $("#invoice").html();//div which have to print6
                // var printWindow = window.open('', '', 'height=auto,width=auto');


                // printWindow.document.write('<html><head><title></title>');
                // printWindow.document.write('<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" >');//external styles
                // printWindow.document.write('<link rel="stylesheet" href="/css/custom.css" type="text/css"/>');
                // printWindow.document.write('</head><body>');
                // printWindow.document.write(divContents);
                // printWindow.document.write('</body></html>');
                // printWindow.document.close();

                // printWindow.onload=function(){
                //     printWindow.focus();
                //     printWindow.print();
                //     printWindow.close();
                // }
            },
            editItem(item){
               this.form.fill(item);
            //    this.editmode = true;
               $("#ViewInvoice").modal("show");
            },
            searchSaleHistory(page = 1){
                this.searchForm
                    .post("api/searchsalehistorydirect?page=" + page)
                        .then((data) => {
                            this.history = data.data;
                            this.total = data.data.total;
                            this.totalAmount = data.data.totalAmount;
                        })
                        .catch(() => {

                        });
            },
            deleteHistory(id){
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    // DELETE USER API
                    if (result.value) {
                           axios.delete("api/salehistory/" + id)
                            .then(() => {
                                Swal.fire("Deleted!", "Record has been successfully deleted", "success");
                                Fire.$emit("AfterCreate");
                            })
                            .catch(() => {
                                Swal.fire("You cant delete this record", "This record is used on other transactions.", "error");
                            });
                    }
                });
            },

        loadBranchAssign(){
            axios.get("api/branchassign").then(({ data }) => (
                this.branch = data
            ));
          },
        },
        created() {
            Fire.$on("AfterCreate", () => {
              this.searchSaleHistory();
            });
            this.searchSaleHistory();
            this.loadBranchAssign();
         },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
