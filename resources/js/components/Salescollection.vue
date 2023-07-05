<template>
    <div class="container-fluid">
       <section v-if="$gate.sale_coll_null()">
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
        <section v-if="$gate.sale_coll_is_NOTnull()">
             <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> SALES RELEASED</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Sales released </li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.sale_coll_Add_() | $gate.sale_coll_Add_Edit() | $gate.sale_coll_Add_Delete() | $gate.sale_coll_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addRelease" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add release
                            </button>
                        </div>
                        <form @submit.prevent="deleteSelectProduct" style="width:100%">
                          <div class="col-md-12 pb-2"  v-if="$gate.sale_coll_Delete_() | $gate.sale_coll_Add_Delete() | $gate.sale_coll_Edit_Delete() | $gate.sale_coll_Add_Edit_Delete()">
                            <button class="btn btn-danger btn-block" type="submit">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete collections
                            </button>
                        </div>
                        </form>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchCollection" style="width:100%">
                     <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Search key:</label>
                                <input type="text" class="form-control" placeholder="Search" v-model="searchForm.searchForm" :class="{ 'is-invalid': searchForm.errors.has('searchForm') }" name="searchForm">
                            </div>
                        </div>

                          <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date released from:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.from" name="renter">
                            </div>
                        </div>
                           <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Date released to:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > --> 
                                <input type="date" class="form-control" placeholder="Search product" v-model="searchForm.to" name="renter">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                  <option value="r.fullname">Supplier/renter</option>
                                <option value="bs.name">Branch</option>
                                 <option value="bo.box_number">Cube #</option>
                                  <option value="sc.amount">Amount released</option>
                                    <option value="sc.date_released">Date released</option>
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
                              <label class="pr-2"> Utilities:</label>
                              <router-link to="/saleshistory">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-shopping-cart" aria-hidden="true"></i> Renters' sales
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
                     <p>Total sales released: {{total | toCurrency}}</p>
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

                                        <th>Supplier/renter</th>
                                         <th>Branch</th>
                                        <th>Cube #</th>
                                        <th>Sales from - to</th>
                                        <th>Amount released</th>
                                        <th>Date released</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i) in collection.data" :key="item.id ">
                                        <th >
                                          <div class="icheck-primary d-inline">
                                            <input type="checkbox" :id="'select' + item.id" v-model="selectForm.productID" :value="item.id">
                                             <label :for="'select' + item.id"></label>
                                          </div>
                                        </th>
                                         <td>{{item.fullname}}</td>
                                           <td>{{item.name}}</td>
                                            <td>{{item.box_number}}</td>
                                            <td>{{item.sales_from | myDate}} - {{item.sales_to | myDate}}</td>
                                         <td>{{item.amount |  toCurrency}}</td>
                                        <td>{{item.date_released | myDate}}</td>
                                        <td>
                                            <button  v-if="$gate.sale_coll_Edit_() | $gate.sale_coll_Add_Edit() | $gate.sale_coll_Edit_Delete() | $gate.sale_coll_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                            <button v-if="$gate.sale_coll_Delete_() | $gate.sale_coll_Add_Delete() | $gate.sale_coll_Edit_Delete() | $gate.sale_coll_Add_Edit_Delete()" class="btn btn-danger"  @click="deleteRelease(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div><!---- end accordion ------->
                        </div><!---- end card body ------->
                        <div class="card-footer">
                             <pagination :data="collection" @pagination-change-page="searchCollection" :limit="1"></pagination>
                         </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD PRODUCT MODAL -->
        <section>
           <div class="modal fade" id="addRelease" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="!editmode">Add release</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit release</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="editmode ? editRelease() : createRelease()">
                    <div class="modal-body">
                        <div class="row">
                           <div class="col-md-12">
                               <div class="form-group">
                                  <label>Supplier</label>
                                    <v-select :options="renters" placeholder="Select renter"  :reduce="item => item.id" label="item_data" v-model="form.location_id" :class="{ 'is-invalid': form.errors.has('location_id') }" name="location_id"  :on-search="loadRenters" :value="form.location_id" ></v-select>
                                </div>
                           </div>
                       </div> <!---- end row ----->
                       <div class="row"> <!---- start: row ----->
                           <div class="col-md-6">
                                   <div class="form-group">
                                    <label > Sales from</label>
                                     <input type="date" class="form-control"  v-model="form.sales_from" :class="{ 'is-invalid': form.errors.has('sales_from') }" name="sales_from">
                                     <has-error :form="form"  field="sales_from"></has-error>
                                </div>
                           </div>
                            <div class="col-md-6">
                                   <div class="form-group">
                                    <label > Sales to</label>
                                     <input type="date" class="form-control"  v-model="form.sales_to" :class="{ 'is-invalid': form.errors.has('sales_to') }" name="sales_to">
                                     <has-error :form="form"  field="sales_to"></has-error>
                                </div>
                           </div>
                       </div><!---- end row ----->
                        <div class="row">
                           <div class="col-md-12">
                               <div class="form-group">
                                    <label > Amount</label>
                                     <input type="number" class="form-control" placeholder="Amount" v-model="form.amount" :class="{ 'is-invalid': form.errors.has('amount') }" name="amount">
                                     <has-error :form="form"  field="amount"></has-error>
                                </div>
                           </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                                  <div class="form-group">
                                    <label > Date released</label>
                                     <input type="date" class="form-control"  v-model="form.date_released" :class="{ 'is-invalid': form.errors.has('date_released') }" name="date_released">
                                     <has-error :form="form"  field="date_released"></has-error>
                                </div>
                        </div>
                    </div>
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
                        <button type="submit" v-show="editmode" class="btn btn-primary">Update release</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">Save release</button>
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
                renters: [],
                collection:{},
                editmode:false,
                searchForm: new Form({
                    searchForm: "",
                    sort: "",
                    from:"",
                    to:"",
                }),
                selectForm: new Form({
                    productID: [],
                }),
                form: new Form({
                    id: '',
                    location_id: '',
                    amount: '',
                    note: '',
                    sales_from: '',
                    sales_to: '',
                    date_released: '',
                }),
            };
        },
      methods:{
           selectAllProduct: function() {
            this.checkAll = !this.checkAll;
                this.selectForm.productID = [];
                if(this.checkAll){ // Check all
                  for (var i in this.collection['data']) {
                        this.selectForm.productID.push(this.collection['data'][i]['id']);
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
                            this.selectForm.post("api/selectcoll")
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
          openModal(){
            this.editmode = false;
            this.form.reset();
            this.form.clear();
          },
          editItem(item){
            this.form.fill(item);
            this.editmode = true;
            this.form.location_id = item.renter_id;
            this.form.value = item.category;
            $("#addRelease").modal("show");
          },
          editRelease(){
              this.form
                .put("api/salescollection/" + this.form.id)
                    .then(() => {
                        $('#addRelease').modal('hide');
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
          deleteRelease(id){
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
                           axios.delete("api/salescollection/" + id)
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
          createRelease(){
            if(this.add_count == 0){
                this.add_count = 1;
                this.form
                    .post("api/salescollection")
                        .then(() => {
                            Fire.$emit("AfterCreate");
                            Swal.fire("Success!", "Record has been successfully saved", "success");
                            $("#addRelease").modal("hide");
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
          searchCollection: function(page = 1){
            this.searchForm
                .post("api/searchcollection?page=" + page)
                    .then((data) => {
                        this.collection = data.data[0]['data'];;
                       this.total = data.data[0]['total'];
                    })
                    .catch(() => {
                    });
          },
      },
      created(){
        Fire.$on("AfterCreate", () => {
            this.searchCollection();
        });
        this.loadRenters();
        this.searchCollection();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>