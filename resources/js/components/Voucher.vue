<template>
    <div class="container-fluid">
        <section>
            <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> VOUCHER & COUPONS</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Voucher & coupons </li>
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
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addVoucher" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add voucher
                            </button>

                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>
                  <form @submit.prevent="searchVoucher" style="width:100%">
                       <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search: </label>
                                <input type="text" class="form-control" placeholder="Search ..."  v-model="searchForm.searchForm" name="searchForm.searchForm" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="asc">A-Z</option>
                                <option value="desc">Z-A</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-search" aria-hidden="true"></i> Search
                                  </button>
                            </div>
                        </div>
                    </form>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                              <label class="pr-2"> Utilities:</label>
                              <router-link to="/products">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-shopping-bag" aria-hidden="true"></i> Products
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
                     <p>Total voucher & coupons: {{total}}</p>
                   <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Voucher code</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in voucher.data" :key="index ">
                                        <td>{{item.voucher_name}}</td>
                                        <td>{{item.type}}</td>
                                        <td>{{item.stat}}</td>
                                        <td >
                                            <button class="btn btn-primary" @click="editItem(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                            <button class="btn btn-danger"  @click="deleteVoucher(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div><!---- end car body ------->
                          <div class="card-footer">
                             <pagination :data="voucher" @pagination-change-page="searchVoucher" :limit="1"></pagination>
                         </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
         <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->
        <section>
           <div class="modal fade" id="addVoucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add voucher</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
              <form @submit.prevent="editmode ? editVoucher() : createVoucher()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Voucher code </label>
                                  <input type="text" class="form-control" placeholder="Voucher code" v-model="form.voucher_name" :class="{ 'is-invalid': form.errors.has('voucher_name') }" name="voucher_name" >
                                  <has-error :form="form" field="voucher_name"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Type</label>
                                     <select name="type" v-model="form.type" id="role" class="form-control"  :class="{ 'is-invalid': form.errors.has('type') }" >
                                        <option value>Select category</option>
                                        <option value="order">Order</option>
                                        <option value="product">Product</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                           </div>
                           <div class="col-md-12">
                                <div class="form-group clearfix" v-if="form.type == 'product' ">
                                  <label>Location</label>
                                    <!-- <v-select :options="renters" placeholder="Select renter"   :reduce="item => item.id" label="item_data" v-model="form.location_id" :class="{ 'is-invalid': form.errors.has('location_id') }" name="location_id"  :on-search="loadRenters" :value="form.location_id"></v-select>
                                    <has-error :form="form" field="type"></has-error> -->
                                    <multiselect v-model="form.value" :options="options" :multiple="true"  placeholder="Type to search" track-by="id"  :reduce="item => item.id" label="item_data" ><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
                                </div>
                           </div>
                         <div class="col-md-12">
                              <div class="form-group">
                                  <label>Price type</label>
                                     <select name="type" v-model="form.price_type" id="role" class="form-control"  :class="{ 'is-invalid': form.errors.has('price_type') }" >
                                        <option value>Select price type</option>
                                        <option value="percent">Percent</option>
                                        <option value="fixed price">Fixed price</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                           </div>
                             <div class="col-md-12">
                                <div class="form-group clearfix" v-if="form.price_type == 'fixed price' ">
                                  <label>Fix price</label>
                                    <input type="text" class="form-control" placeholder="Fix price" v-model="form.fix_price" :class="{ 'is-invalid': form.errors.has('fix_price') }" name="fix_price" >
                                  <has-error :form="form" field="fix_price"></has-error>
                                </div>
                           </div>
                             <div class="col-md-12">
                                <div class="form-group clearfix" v-if="form.price_type == 'percent' ">
                                  <label>Percent</label>
                                    <input type="text" class="form-control" placeholder="Percent" v-model="form.percentage" :class="{ 'is-invalid': form.errors.has('percentage') }" name="percentage" >
                                  <has-error :form="form" field="percentage"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label>Status</label>
                                <div class="custom-control custom-switch">
                                  <input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="form.status" :class="{ 'is-invalid': form.errors.has('status') }" name="status" >
                                  <label class="custom-control-label" for="customSwitch1"></label>
                                </div>
                                </div>
                           </div>
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                         <button type="submit" v-show="editmode" class="btn btn-primary">Update voucher</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">Save voucher</button>
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
    export default {
     components: {
        Multiselect,
      },
      data() {
            return {
                total: "",
                editmode:false,
                voucher: {},
                options:[],
                searchForm: new Form({
                    searchForm: '',
                    sort:'asc'
                }),
                form: new Form({
                    id: '',
                    voucher_name: '',
                    type: '',
                    status:'',
                    value:[],
                    price_type:'',
                    percentage:'',
                    fix_price:'',
                }),
            };
        },
      methods:{
        searchVoucher(page = 1){
            this.loading = true;
            this.searchForm
              .post("api/searchvoucher?page=" + page).
              then(({ data }) => {
                  this.voucher = data;
                  this.total = data.total;
              });
          },
           openModal(){
            this.editmode = false;
            this.form.reset();
            this.form.clear();
          },
          editItem(item){
            $("#addVoucher").modal("show");
            console.log(item);
            this.form.fill(item);
            this.editmode = true;
            this.form.value = item.location_id;
            this.form.value.map(item =>{
                    return item.item_data = item.fullname + ' - ' + item.name + ' - ' + item.box_number;
                })
          },
          editVoucher(){
              this.form
                .put("api/voucher/" + this.form.id)
                    .then(() => {
                        $('#addVoucher').modal('hide');
                        Swal.fire("Updated!", "Boxes has been successfully updated", "success");
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
          deleteVoucher(id){
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
                           axios.delete("api/voucher/" + id)
                            .then(() => {
                                Swal.fire("Deleted!", "Boxes has been successfully deleted", "success");
                                Fire.$emit("AfterCreate");
                            })
                            .catch(() => {
                                Swal.fire("You cant delete this boxes", "This boxes is used on other transactions.", "error");
                            });
                    }
                });
          },
          createVoucher(){
            this.form
            .post("api/voucher")
                .then(() => {
                    Fire.$emit("AfterCreate");
                    Swal.fire("Success!", "Record has been successfully saved", "success");
                    $("#addVoucher").modal("hide");
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: 'Kindly check and complete required fields.'
                    })
                });
          },
           loadproducts: function() {
            axios.get("api/loadboxlist").then(({ data }) => {this.options = data ;
                this.options.map(item =>{
                    return item.item_data = item.fullname + ' - ' + item.name + ' - ' + item.box_number;
                });
            });
          },
      },
      created(){
          Fire.$on("AfterCreate", () => {
            this.searchVoucher();
        });
        this.searchVoucher();
        this.loadproducts();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
