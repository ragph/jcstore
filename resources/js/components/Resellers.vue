<template>
    <div class="container-fluid">
 <section  v-if="$gate.renter_null()">
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
        <section v-if="$gate.renter_is_NOTnull() ">
              <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> RENTERS</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Renters</li>
                      </ol>
                </div> 
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.renter_Add_() | $gate.renter_Add_Edit() | $gate.renter_Add_Delete() | $gate.renter_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addRenter" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add renter / seller
                            </button>

                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchRenter" style="width:100%">
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2">Search key:</label>
                                <input type="text" class="form-control" placeholder="Search" v-model="searchForm.name">
                            </div>
                        </div>
                        
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2">Date from:</label>
                                <input type="date" class="form-control" v-model="searchForm.dateFrom">
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2">Date to:</label>
                                <input type="date" class="form-control" v-model="searchForm.dateTo">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2">Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="fullname">Fullname</option>
                                <option value="address">Address</option>
                                <option value="email">Email</option>
                                <option value="contact_number">Contact number</option>
                                <option value="date_registered">Date registered</option>
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
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-search" aria-hidden="true"></i> Search
                                  </button>
                            </div>
                        </div>
                    </form>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                              <label class="pr-2 "> Utilities:</label>
                              <router-link to="/all">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-list-alt" aria-hidden="true"></i> Rent management
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
                    <p>Total renter / seller: {{renter.total}}</p>
                    <div class="card card-primary card-outline">
                        <!-- /.card-header -->
                        <div class="card-body">
                                <div id="accordion">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Full name</th>
                                                <th>Email</th>
                                                <th>Contact number</th>
                                                <th>Address</th>
                                                <th>Date registered</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr  v-for="(item,i) in renter.data " :key="item.id" >
                                            <td>{{item.fullname}}</td>
                                            <td>{{item.email}}</td>
                                            <td>{{item.contact_number}}</td>
                                            <td>{{item.address}}</td>
                                            <td>{{item.date_registered | myDate}}</td>
                                                <td>
                                                    <button v-if="$gate.renter_Edit_() | $gate.renter_Add_Edit() | $gate.renter_Edit_Delete() | $gate.renter_Add_Edit_Delete()" class="btn btn-primary" @click="editModal(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button v-if="$gate.renter_Delete_() | $gate.renter_Add_Delete() | $gate.renter_Edit_Delete() | $gate.renter_Add_Edit_Delete()"  class="btn btn-danger" @click="deleteRenter(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                             </div><!---- end accordion ------->
                        </div><!---- end card body ------->
                         <div class="card-footer">
                             <pagination :data="renter" @pagination-change-page="searchRenter" :limit="1"></pagination>
                        </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->
        <section>
           <div class="modal fade" id="addRenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-show="!editmode">Add renter / seller</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-show="editmode">Edit renter / seller</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                     <form @submit.prevent="editmode ? editRenter() : createRenter()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Full name</label>
                                  <input type="text" class="form-control" placeholder="Full name" v-model="form.fullname" :class="{ 'is-invalid': form.errors.has('fullname') }" name="fullname">
                                  <has-error :form="form" field="fullname"></has-error>
                                </div>
                           </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                  <label>Branch(es)</label>
                                  <multiselect v-model="form.value" :options="options" :multiple="true"  placeholder="Type to search" track-by="id"  :reduce="item => item.id" label="name" ><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
                                </div>
                           </div> -->
                             <div class="col-md-12">
                                <div class="form-group">
                                  <label>Address</label>
                                    <input type="text" class="form-control" placeholder="Address" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" name="address" >
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Contact number</label>
                                    <input type="text" class="form-control" placeholder="Contact number" v-model="form.contact_number" :class="{ 'is-invalid': form.errors.has('contact_number') }" name="contact_number" >
                                    <has-error :form="form" field="contact_number"></has-error>
                                </div>
                           </div>
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Email"  v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" name="email">
                                     <has-error :form="form" field="email"></has-error>
                                </div>
                           </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                  <label>Box number</label>
                                    <select name="box_id" v-model="form.box_id" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('box_id') }">
                                        <option value>Select box number</option>
                                        <option v-for="item in box" :value="item.id" :key="item.id">{{ item.box_number}}</option>
                                    </select>
                                    <has-error :form="form" field="box_id"></has-error>

                                </div>
                           </div> -->
                             <div class="col-md-12">
                                <div class="form-group">
                                  <label>Date registered</label>
                                     <input type="date" class="form-control"  v-model="form.date_registered" :class="{ 'is-invalid': form.errors.has('date_registered') }" name="date_registered">
                                     <has-error :form="form" field="date_registered"></has-error>
                                </div>
                           </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                  <label>Due date</label>
                                     <input type="date" class="form-control" placeholder="Mobile number" v-model="form.due_date" :class="{ 'is-invalid': form.errors.has('due_date') }" name="due_date" >
                                     <has-error :form="form" field="due_date"></has-error>
                                </div>
                           </div> -->
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                         <button v-show="editmode" type="submit" class="btn btn-primary">Update renter / seller</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Save renter / seller</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>

    </div> <!---- container------>
</template>

<script>
 import Multiselect from 'vue-multiselect'
//  import Skeleton from 'vue-loading-skeleton';
    export default {
        data(){
            return {
                add_count: 0,
                editmode: false,
                 editedIndex: -1,
                 renter:{},
                 searchForm: new Form({
                  name: '',
                  dateFrom: '',
                  dateTo: '',
                  sort: "",
                  sortby: 'desc',
                }),
                  form: new Form({
                    id: "",
                    fullname: "",
                    address: "",
                    contact_number:"",
                    email:"",
                    date_registered: "",
                }),
            };
        },
     components: {
         Multiselect,
      },
       computed: {
          formTitle() {
                return this.editedIndex === -1 ? 'Add new renter' : 'Edit renter'
              }
        },
      methods: {
          openModal(){
               this.editmode = false;
                this.form.reset();
                this.form.clear();
          },
          searchRenter(page = 1){
            this.loading = true;
            this.searchForm
              .post("api/searchrenter?page=" + page).
              then(({ data }) => {this.renter = data; this.total =data.total; this.loading = false});
          },
           editModal: function(item) {
            this.editedIndex = 1 ;
              this.editmode = true;
              this.form.reset();
              // user.phone_serial.serialnumber;
              $("#addRenter").modal("show");
              this.form.fill(item);
              this.form.value = item.branch;
              this.form.box_id = item.box_id;
            },
           createRenter: function() {
               if(this.add_count == 0){

                   this.add_count = 1;
                   this.editedIndex = -1 ;
                    this.form
                        this.form.post("api/renter").then(() => {
                        $("#addRenter").modal("hide");
                            this.searchRenter();
                            Swal.fire("Success!", "Record has been successfully saved", "success");
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
           editRenter: function() {
            this.form
              .put("api/renter/" + this.form.id)
              .then(() => {
                $("#addRenter").modal("hide");
                 this.searchRenter();
                Swal.fire("Updated!", "Record has been successfully updated", "success");

              })
              .catch(() => {
                 Swal.fire({
                          icon: 'error',
                          title: 'Something went wrong!',
                          text: 'Kindly check and complete required fields.'
                        })
              });
          },
           deleteRenter(id){
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
                           axios.delete("api/renter/" + id)
                            .then(() => {
                                Swal.fire("Deleted!", "Record has been successfully deleted", "success");
                               this.searchRenter();
                            })
                            .catch(() => {
                                Swal.fire("You cant delete this record", "This record is used on other transactions.", "error");
                            });
                    }
                });
            },
        //    load branches
          loadBranches: function() {
            axios.get("api/branchlist").then(({ data }) => (this.options = data));
          },
        //   loadBoxes: function() {
        //     axios.get("api/boxlist").then(({ data }) => (this.box = data));
        //   },
      },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
          this.searchRenter();
          this.loadBranches();
        //   this.loadBoxes();
         },
    }
</script>
