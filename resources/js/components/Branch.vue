<template>
    <div class="container-fluid">
    <section  v-if="$gate.branch_null()">
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
        <section v-if="$gate.branch_is_NOTnull()">
            <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> BRANCH</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Branch</li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.branch_Add_() | $gate.branch_Add_Edit() | $gate.branch_Add_Delete() | $gate.branch_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addStore" @click="clearAddBranch">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add branch
                            </button>

                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchBranch" style="width:100%">
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 ">Search key:</label>
                                <!-- <input type="text" class="form-control" placeholder="Branch" name="" > -->
                                <input type="text" class="form-control" placeholder="Search" v-model="searchBranchForm.branch" :class="{ 'is-invalid': form.errors.has('branch') }" name="branch">
                                  <has-error :form="searchBranchForm" field="branch"></has-error>
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchBranchForm.sort" :class="{ 'is-invalid': searchBranchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="contact_person">Contact person</option>
                                <option value="name">Branch</option>
                                <option value="address">Address</option>
                                <option value="contact_number">Contact number</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchBranchForm.sortby" :class="{ 'is-invalid': searchBranchForm.errors.has('sortby') }" name="sortby">
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
                <p>Total branch: {{total}}</p>
                    <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'selectbusiness'" true-value="yes" false-value="no">
                                                <label :for="'selectbusiness'"></label>
                                            </div>
                                        Select
                                        </th> -->
                                        <th>Contact person</th>
                                        <th>Branch</th>
                                        <th>Address</th>
                                        <th>Contact number</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(branch, index) in branches.data" :key="index ">

                                        <!-- <td>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'selectbusiness'" true-value="yes" false-value="no">
                                                <label :for="'selectbusiness'"></label>
                                            </div>
                                        </td> -->
                                        <td>{{branch.contact_person}}</td>
                                        <td>{{branch.name}}</td>
                                        <td>{{branch.address}}</td>
                                        <td>{{branch.contact_number}}</td>
                                        <td>
                                            <button  v-if="$gate.branch_Edit_() | $gate.branch_Add_Edit() | $gate.branch_Edit_Delete() | $gate.branch_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(branch)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </button>
                                            <button v-if="$gate.branch_Delete_() | $gate.branch_Add_Delete() | $gate.branch_Edit_Delete() | $gate.branch_Add_Edit_Delete()" class="btn btn-danger" @click="deleteBranch(branch.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div><!---- end car body ------->
                         <div class="card-footer">
                             <pagination :data="branches" @pagination-change-page="searchBranch" :limit="1"></pagination>
                        </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->
        <section>
           <div class="modal fade" id="addStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="!editmode">Add branch</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit branch</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      <form @submit.prevent="editmode ? editBranch() : createBranch()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Branch name</label>
                                  <input type="text" class="form-control" placeholder="Branch name" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" name="name">
                                  <has-error :form="form" field="name"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" class="form-control" placeholder="Address" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" name="address">
                                  <has-error :form="form" field="address"></has-error>
                                </div>
                           </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                  <label>Contact person</label>
                                    <input type="text" class="form-control" placeholder="Contact person" v-model="form.contact_person" :class="{ 'is-invalid': form.errors.has('contact_person') }" name="contact_person">
                                  <has-error :form="form" field="contact_person"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Contact number</label>
                                    <input type="text" class="form-control" placeholder="Contact number" v-model="form.contact_number" :class="{ 'is-invalid': form.errors.has('contact_number') }" name="contact_number">
                                  <has-error :form="form" field="contact_number"></has-error>
                                </div>
                           </div>
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Save branch</button>
                        <button v-show="editmode" type="submit" class="btn btn-primary">Update branch</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>

    </div> <!---- container------>
</template>

<script>
import VueUploadMultipleImage from 'vue-upload-multiple-image';
    export default {
     components: {
        VueUploadMultipleImage,
      },
        data() {
            return {
                add_count: 0,
                editmode:false,
                branches: {},
                total: "",
                searchBranchForm: new Form({
                    id: '',
                    branch: '',
                    sort: "",
                    sortby: 'desc',
                }),
                form: new Form({
                    id: '',
                    name: '',
                    address: '',
                    contact_person: '',
                    contact_number: ''
                }),
            };
        },
        methods:{
            clearAddBranch(){
                this.editmode = false;
                this.form.reset();
                this.form.clear();
            },
            searchBranch(page = 1){
                this.searchBranchForm
                    .post("api/searchbranch?page=" + page)
                        .then((data) => {
                            this.branches = data.data;
                            this.total = data.data.total;
                        })
                        .catch(() => {

                        });
            },
            deleteBranch(id){
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
                           axios.delete("api/branch/" + id)
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
            editItem(branch){
                this.editmode = true;
                this.form.fill(branch);
                $("#addStore").modal("show");
            },
            editBranch(){
                this.form
                .put("api/branch/" + this.form.id)
                    .then(() => {
                        $('#addStore').modal('hide');
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
            createBranch(){
                if(this.add_count == 0){

                    this.add_count = 1;

                    this.form
                    .post("api/branch")
                        .then(() => {
                            Fire.$emit("AfterCreate");
                            Swal.fire("Success!", "Record has been successfully saved", "success");
                            $("#addStore").modal("hide");
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
                
            }
        },
        created() {
            Fire.$on("AfterCreate", () => {
              this.searchBranch();
            });

            this.searchBranch();
         },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
