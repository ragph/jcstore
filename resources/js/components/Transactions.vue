<template>
    <div class="container-fluid">
       <section v-if="$gate.inventory_null()">
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
        <section v-if="$gate.inventory_is_NOTnull()">
             <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> STOCKS RECEIVING</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Stocks receiving </li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.inventory_Add_() | $gate.inventory_Add_Edit() | $gate.inventory_Add_Delete() | $gate.inventory_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addProduct" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add inventory
                            </button>
                        </div>
                        <form @submit.prevent="deleteSelectProduct" style="width:100%">
                          <div class="col-md-12 pb-2"  v-if="$gate.inventory_Delete_() | $gate.inventory_Add_Delete() | $gate.inventory_Edit_Delete() | $gate.inventory_Add_Edit_Delete()">
                            <button class="btn btn-danger btn-block" type="submit">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete products
                            </button>
                        </div>
                        </form>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchInventory" style="width:100%">
                     <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Search key:</label>
                                <input type="text" class="form-control" placeholder="Search" v-model="searchForm.searchForm" :class="{ 'is-invalid': searchForm.errors.has('searchForm') }" name="searchForm">
                            </div>
                        </div>

                          <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date from:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.from" name="renter">
                            </div>
                        </div>
                           <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date to:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.to" name="renter">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="ps.sku">SKU</option>
                                <option value="ps.product_name">Product name</option>
                                <option value="r.fullname">Renter</option>
                                <option value="bs.name">Branch</option>
                                <option value="bo.box_number">Cube #</option>
                                <option value="i.date">Date received</option>
                                <option value="i.quantity">Quantity</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sortby" :class="{ 'is-invalid': searchForm.errors.has('sortby') }" name="sortby">
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
                              <label class="pr-2"> Utilities:</label>
                              <router-link to="/inventory">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-shopping-bag" aria-hidden="true"></i> Inventory
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
                     <p>Total stocks: {{total}}</p>
                  <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                     <div class="card-body">
                         <div id="accordion">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th  v-if="$gate.isAdmin() | $gate.isManager() | $gate.isStaff()">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'selectProduct'" @click="selectAllProduct" v-model="checkAll">
                                                <label :for="'selectProduct'"></label>
                                            </div>
                                        Select all
                                        </th>

                                        <th>SKU</th>
                                        <th>Product name</th>
                                        <th>Renter</th>
                                        <th>Branch</th>
                                        <th>Cube #</th>
                                        <th>Date received</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i) in inventory.data" :key="item.id ">
                                        <th >
                                          <div class="icheck-primary d-inline">
                                            <input type="checkbox" :id="'select' + item.id" v-model="selectForm.productID" :value="item.id">
                                             <label :for="'select' + item.id"></label>
                                          </div>
                                        </th>
                                        <td>{{item.sku}}</td>
                                         <td>{{item.product_name}}</td>
                                         <td>{{item.fullname}}</td>
                                         <td>{{item.name}}</td>
                                         <td>{{item.box_number}}</td>
                                         <td>{{item.date | myDate}}</td>
                                         <td>{{item.quantity}}</td>
                                        <td>
                                            <button  v-if="$gate.inventory_Edit_() | $gate.inventory_Add_Edit() | $gate.inventory_Edit_Delete() | $gate.inventory_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                            <button v-if="$gate.inventory_Delete_() | $gate.inventory_Add_Delete() | $gate.inventory_Edit_Delete() | $gate.inventory_Add_Edit_Delete()" class="btn btn-danger"  @click="deleteProduct(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div><!---- end accordion ------->
                        </div><!---- end card body ------->
                        <div class="card-footer">
                             <pagination :data="inventory" @pagination-change-page="searchInventory" :limit="1"></pagination>
                         </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD PRODUCT MODAL -->
        <section>
           <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="!editmode">Add inventory</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit inventory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="editmode ? editProduct() : createProduct()">
                    <div class="modal-body">
                        <div class="row">
                           <div class="col-md-12">
                               <div class="form-group">
                                  <label>Location</label>
                                    <v-select :options="renters" placeholder="Select renter"  :reduce="item => item.id" label="item_data" v-model="form.location_id" :class="{ 'is-invalid': form.errors.has('location_id') }" name="location_id"  :on-search="loadRenters" :value="form.location_id" ></v-select>
                                </div>
                           </div>
                       </div> <!---- end row ----->

                       <div class="row">
                           <div class="col-md-12">
                               <div class="form-group">
                                  <label>Product</label>
                                    <v-select :options="products" placeholder="Select product"  :reduce="item => item.id" label="item_data" v-model="form.product_id" :class="{ 'is-invalid': form.errors.has('product_id') }" name="product_id"  :on-search="loadProduct" :value="form.product_id" ></v-select>
                                </div>
                           </div>
                       </div> <!---- end row ----->

                        <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                    <label > Quantity</label>
                                     <input type="number" class="form-control" placeholder="Qty" v-model="form.quantity" :class="{ 'is-invalid': form.errors.has('quantity') }" name="quantity">
                                     <has-error :form="form"  field="quantity"></has-error>
                                </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                    <label > Date received</label>
                                     <input type="date" class="form-control"  v-model="form.date" :class="{ 'is-invalid': form.errors.has('date') }" name="date">
                                     <has-error :form="form"  field="date"></has-error>
                                </div>
                           </div>
                       </div> <!---- end row ----->

                       <div class="row">
                           <div class="col-md-12">
                               <div class="form-group">
                                    <label > Note</label>
                                    <textarea class="form-control" rows="3" placeholder="Note"  v-model="form.note" :class="{ 'is-invalid': form.errors.has('note') }" name="note"></textarea>

                                </div>
                           </div>

                       </div> <!---- end row ----->




                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-primary">Update product</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">Save product</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>
    </div> <!---- container------>
</template>

<script>
 import Multiselect from 'vue-multiselect';
 import VueUploadMultipleImage from 'vue-upload-multiple-image';
    export default {
     components: {
        Multiselect,
        VueUploadMultipleImage
      },
      data() {
            return {
                add_count: 0,
                total: "",
                checkAll: false,
                searchCategory: [],
                renters: [],
                products: [],
                inventory:{},
                editmode:false,
                searchForm: new Form({
                    searchForm: "",
                    sort: "",
                    sortby: 'desc',
                    from:"",
                    to:"",
                }),
                selectForm: new Form({
                    productID: [],
                }),
                form: new Form({
                    id: '',
                    location_id: '',
                    product_id: '',
                    quantity: '',
                    date:'',
                    note: '',
                }),
            };
        },
      methods:{
           selectAllProduct: function() {
            this.checkAll = !this.checkAll;
                this.selectForm.productID = [];
                if(this.checkAll){ // Check all
                    //   axios.get("api/searchproduct")
                    //     .then((data) => {
                    //          this.productID = (data.id);
                    //     })
                    //     .catch(() => {
                    //     });
                  for (var i in this.inventory['data']) {
                        this.selectForm.productID.push(this.inventory['data'][i]['id']);
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
                            this.selectForm.post("api/selectIvtry")
                        .then((data) => {
                                Swal.fire("Deleted!", "Record has been successfully deleted", "success");
                                Fire.$emit("AfterCreate");
                    })
                        .catch(() => {
                                Swal.fire("You cant delete this record", "This record is used on other transactions.", "error");
                        });
                    }
                });
            }
        },
        beforeRemove (index, done, fileList) {
                // var r = confirm("remove image")
                // if (r == true) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                        if (result.value) {
                            done();
                        }
                    });
                // }else{
                // }
            },
          editImage (formData, index, fileList) {
          },
          uploadImageSuccess(formData, index, fileList) {
                this.form.gallery = fileList;
            },
          openModal(){
            this.editmode = false;
            this.form.reset();
            this.form.clear();
          },
          editItem(item){
            this.form.fill(item);
            this.editmode = true;
            this.form.branch_id = item.branch_id;
            this.form.renter_id = item.renter_id;
            this.form.value = item.category;
            $("#addProduct").modal("show");
          },
          editProduct(){
              this.form
                .put("api/inventory/" + this.form.id)
                    .then(() => {
                        $('#addProduct').modal('hide');
                        Swal.fire("Updated!", "Record has been successfully updated", "success");
                        Fire.$emit("AfterCreate");
                    })
                    .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: 'Kindly check and complete required fields.'
                    })
                });
          },
          deleteProduct(id){
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
                           axios.delete("api/inventory/" + id)
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
        //   searchProduct(){
        //       this.searchForm
        //             .post("api/searchproduct")
        //                 .then((data) => {
        //                     this.products = data.data;
        //                 })
        //                 .catch(() => {

        //                 });
        //   },
          createProduct(){
              if(this.add_count == 0){
                  this.add_count = 1;

                  this.form
                    .post("api/inventory")
                        .then(() => {
                            Fire.$emit("AfterCreate");
                            Swal.fire("Success!", "Boxes has been successfully saved", "success");
                            $("#addProduct").modal("hide");
                            this.add_count = 0;
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong!',
                                text: 'Kindly check and complete required fields.'
                            })
                            this.add_count = 0;
                        });
              }
            
          },

        loadRenters: function() {
            axios.get("api/loadboxlist").then(({ data }) => (
                this.renters = data,
                this.renters.map(item =>{
                    return item.item_data = item.fullname + ' - ' + item.name + ' - ' + item.box_number;
                })
            ));
          },
           loadProduct: function() {
            axios.get("api/productlist").then(({ data }) => (
                this.products = data,
                this.products.map(item =>{
                    return item.item_data = item.sku + ' - ' + item.product_name ;
                })
            ));
          },
          loadsearchCategory: function() {
            axios.get("api/categorylist").then(({ data }) => (
                this.searchCategory = data,
                this.searchCategory.map(item =>{
                    return item.item_category = item.name;
                })
            ));
          },
          searchInventory: function(page = 1){
            this.searchForm
                .post("api/searchtransaction?page=" + page)
                    .then((data) => {
                        this.inventory = data.data;
                        this.total = data.data.total;
                    })
                    .catch(() => {
                    });
          },
      },
      created(){
        Fire.$on("AfterCreate", () => {
            this.searchInventory();
        });

        this.loadRenters();
        this.loadProduct();
        this.loadsearchCategory();
        this.searchInventory();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>