<template>
    <div class="container-fluid">
    <section   v-if="$gate.user_null()">
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
        <section  v-if="$gate.user_is_NOTnull()">
            <div class="row">
                <div class="col-sm-6">
                    <h3 style="color:#34495e"> USERS</h3>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active">Users </li>
                    </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                            <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.user_Add_() | $gate.user_Add_Edit() | $gate.user_Add_Delete() | $gate.user_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addUser"
                                @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add user
                            </button>
                        </div>
                        <form @submit.prevent="deleteSelectProduct" style="width:100%">
                            <div class="col-md-12 pb-2" v-if="$gate.user_Delete_() | $gate.user_Add_Delete() | $gate.user_Edit_Delete() | $gate.user_Add_Edit_Delete()">
                                <button class="btn btn-danger btn-block" type="submit">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete users
                                </button>
                            </div>
                        </form>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                        <form @submit.prevent="searchUser" style="width:100%">
                            <div class="col-md-12 ">
                                <div class="form-group clearfix">
                                    <label class="pr-2 "> Search key:</label>
                                    <input type="text" class="form-control" placeholder="Search"
                                        v-model="searchForm.name"
                                        :class="{ 'is-invalid': searchForm.errors.has('name') }" name="name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group clearfix">
                                    <label class="pr-2"> Sort by:</label>
                                    <select id="role" class="form-control" v-model="searchForm.sort"
                                        :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                        <option value>Select</option>
                                        <option value="u.username">Username</option>
                                        <option value="u.name">Name</option>
                                        <option value="u.mobileno">Contact number</option>
                                        <option value="u.role">Role</option>
                                        <option value="bs.name">Branch</option>
                                        <option value="bs.address">Address</option>
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
                                    <button class="btn btn-info float-sm-right btn-block" style="color:white"
                                        type="submit">
                                        <i class="fa fa-search" aria-hidden="true"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Utilities:</label>
                                <router-link to="/branch">
                                    <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                        <i class="fa fa-home " aria-hidden="true"></i> Branch management
                                    </button>
                                </router-link>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <router-link to="/dashboard"><button
                                        class="btn btn-success float-sm-right btn-block">Back to dashboard</button>
                                </router-link>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-10">
                    <p>Total users: {{total}}</p>
                    <div class="card card-primary card-outline">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'selectProduct'" @click="selectAllProduct"
                                                    v-model="checkAll">
                                                <label :for="'selectProduct'"></label>
                                            </div>
                                            Select all
                                        </th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Contact number</th>
                                        <th>Role</th>
                                        <th>Branch</th>
                                        <th>Address</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i) in users.data" :key="item.id ">
                                        <td>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'select' + item.id"
                                                    v-model="selectForm.productID" :value="item.id">
                                                <label :for="'select' + item.id"></label>
                                            </div>
                                        </td>
                                        <td>{{item.username}}</td>
                                        <td>{{item.nameuser}}</td>
                                        <td>{{item.mobileno}}</td>
                                        <td>{{item.role}}</td>
                                         <td>{{item.name}}</td>
                                        <td>{{item.address}}</td>
                                        <td>
                                            <button v-if="$gate.user_Edit_() | $gate.user_Add_Edit() | $gate.user_Edit_Delete() | $gate.user_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(item)"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                            <button v-if="$gate.user_Delete_() | $gate.user_Add_Delete() | $gate.user_Edit_Delete() | $gate.user_Add_Edit_Delete()" class="btn btn-danger" @click="deleteUser(item.id)"><i
                                                    class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <pagination :data="users" @pagination-change-page="searchUser" :limit="1"></pagination>
                        </div>
                    </div>
                </div>
            </div>
            <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->
        <section>
            <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="!editmode">Add user</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit user</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? editUser() : createUser()">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" placeholder="Username"
                                                v-model="form.username"
                                                :class="{ 'is-invalid': form.errors.has('username') }" name="username">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Name"
                                                v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }"
                                                name="name">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Renter</label>
                                            <v-select :options="renters" placeholder="Select renter"
                                                :reduce="item => item.id" label="item_data" v-model="form.renter_id"
                                                :class="{ 'is-invalid': form.errors.has('renter_id') }" name="renter_id"
                                                :on-search="loadRenters" :value="form.renter_id"></v-select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Branch</label>
                                            <select name="zone" v-model="form.branch_id" id="role" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('branch_id') }">
                                                <option value>Select branch</option>
                                                <option v-for="branch in branches.data" :value="branch.id"
                                                    :key="branch.id">{{ branch.name }} </option>
                                            </select>
                                            <has-error :form="form" field="branch"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" placeholder="Email"
                                                v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }"
                                                name="email">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Mobile number</label>
                                            <input type="text" class="form-control" placeholder="Mobile number"
                                                v-model="form.mobileno"
                                                :class="{ 'is-invalid': form.errors.has('mobileno') }" name="mobileno">
                                            <has-error :form="form" field="mobileno"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" placeholder="Address"
                                                v-model="form.address"
                                                :class="{ 'is-invalid': form.errors.has('address') }" name="address">
                                            <has-error :form="form" field="address"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" id="role" class="form-control" v-model="form.role"
                                                :class="{ 'is-invalid': form.errors.has('role') }">
                                                <option value>Select</option>
                                                 <option value="cashier">Cashier</option>
                                                <option value="renter">Renter</option>
                                                 <option value="staff">Staff</option>
                                                <option value="manager">Manager</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                            <has-error :form="form" field="role"></has-error>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2">Menu </label>
                                      <hr>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2">Branch </label>
                                      <br>
                                            <select name="branch" v-model="form.branch" id="role" class="form-control" >
                                                <option value>Select</option>
                                                <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2">Renters profile </label>
                                      <br>
                                            <select name="renters_profile" v-model="form.renters_profile" id="role" class="form-control" >
                                                <option value>Select</option>
                                                <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> Cube management </label>
                                      <br>
                                            <select name="cube_management" v-model="form.cube_management" id="role" class="form-control" >
                                                <option value>Select</option>
                                                <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>


                                     <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> Product management </label>
                                      <br>
                                            <select name="product_management" v-model="form.product_management" id="role" class="form-control" >
                                                <option value>Select</option>
                                                <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> Inventory </label>
                                      <br>
                                            <select name="inventory" v-model="form.inventory" id="role" class="form-control" >
                                                <option value>Select</option>
                                                <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> POS </label>
                                      <br>
                                            <select name="pos" v-model="form.pos" id="role" class="form-control" >
                                                <option value>Select</option>
                                               <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> Users </label>
                                      <br>
                                            <select name="users" v-model="form.users" id="role" class="form-control" >
                                                <option value>Select</option>
                                                <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> Rent management </label>
                                      <br>
                                            <select name="rent_management" v-model="form.rent_management" id="role" class="form-control" >
                                                <option value>Select</option>
                                               <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                         <div class="form-group clearfix">
                                      <label class="pr-2 pb-2"> Report </label>
                                      <br>
                                            <select name="report" v-model="form.report" id="report" class="form-control" >
                                                <option value>Select</option>
                                               <option value="1">View</option>
                                            </select>
                                        </div>
                                    </div>
                                       <div  class="col-md-4">
                                         <div class="form-group clearfix">
                                            <label class="pr-2 pb-2"> Settings </label>
                                            <br>
                                            <select name="settings" v-model="form.settings" id="settings" class="form-control" >
                                                <option value>Select</option>
                                               <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div  class="col-md-4">
                                         <div class="form-group clearfix">
                                            <label class="pr-2 pb-2"> Sales collection </label>
                                            <br>
                                            <select name="sale_collections" v-model="form.sale_collections" id="sale_collections" class="form-control" >
                                                <option value>Select</option>
                                               <option value="1">View</option>
                                                <option value="2">Add</option>
                                                <option value="3">Edit</option>
                                                <option value="4">Delete</option>
                                                <option value="5">Add / edit</option>
                                                <option value="6">Add / delete</option>
                                                <option value="7">Edit / delete</option>
                                                <option value="8">Add / edit / delete</option>
                                            </select>
                                        </div>
                                    </div>
                                  <div class="col-md-12">
                                      <hr>
                                  </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" placeholder="Password"
                                                v-model="form.password"
                                                :class="{ 'is-invalid': form.errors.has('password') }" name="password">
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <!---- end row ----->
                            </div>
                            <!---- end modal contennt ----->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" v-show="editmode" class="btn btn-primary">Update user</button>
                                <button type="submit" v-show="!editmode" class="btn btn-primary">Save user</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!---- container------>
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
                branches: {},
                total: "",
                checkAll: false,
                renters: [],
                editmode: false,
                users: {},
                searchForm: new Form({
                    name: "",
                    sort: "",
                    sortby: 'desc',
                }),
                selectForm: new Form({
                    productID: [],
                }),

                form: new Form({
                    id: '',
                    username: '',
                    name: '',
                    email: '',
                    renter_id: '',
                    branch_id: '',
                    address: '',
                    mobileno: '',
                    role: '',
                    password: '',
                    branch:'',
                    renters_profile:'',
                    cube_management:'',
                    product_management:'',
                    inventory:'',
                    pos:'',
                    users:'',
                    rent_management:'',
                    report:'',
                    settings:'',
                    sale_collections:''
                }),
            };
        },
        methods: {
            selectAllProduct: function () {
                this.checkAll = !this.checkAll;
                this.selectForm.productID = [];
                if (this.checkAll) { // Check all
                    //   axios.get("api/searchproduct")
                    //     .then((data) => {
                    //          this.productID = (data.id);
                    //     })
                    //     .catch(() => {
                    //     });
                    for (var i in this.users['data']) {
                        this.selectForm.productID.push(this.users['data'][i]['id']);
                    }
                }
            },

            deleteSelectProduct: function () {
                if (this.selectForm.productID.length == 0) {
                    Swal.fire("Please select users", "", "error");
                } else {
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
                            this.selectForm.post("api/selectUser")
                                .then((data) => {
                                    Swal.fire("Deleted!", "Record has been successfully deleted",
                                        "success");
                                    Fire.$emit("AfterCreate");
                                })
                                .catch(() => {
                                    Swal.fire("You cant delete this record",
                                        "This record is used on other transactions.", "error");
                                });
                        }
                    });
                }
            },
            createUser() {
                if(this.add_count == 0){
                    this.add_count = 1;
                    this.form
                    .post("api/user")
                    .then(() => {
                        Fire.$emit("AfterCreate");
                        Swal.fire("Success!", "Record has been successfully saved", "success");
                        $("#addUser").modal("hide");
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
            editItem(item) {
                this.form.fill(item);
                this.form.clear();
                this.editmode = true;
                this.form.branch_id = item.branch_id;
                this.form.renter_id = item.renter_id;
                this.form.value = item.category;
                this.form.name =item.nameuser;
                $("#addUser").modal("show");
            },
            editUser() {
                this.form
                    .put("api/user/" + this.form.id)
                    .then(() => {
                        $('#addUser').modal('hide');
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
            deleteUser(id) {
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
                        axios.delete("api/user/" + id)
                            .then(() => {
                                Swal.fire("Deleted!", "Record has been successfully deleted", "success");
                                Fire.$emit("AfterCreate");
                            })
                            .catch(() => {
                                Swal.fire("You cant delete this record",
                                    "This record is used on other transactions.", "error");
                            });
                    }
                });
            },
            searchUser() {
                this.searchForm
                    .post("api/searchuser")
                    .then((data) => {
                        this.users = data.data;
                        this.total = data.data.total;
                    })
                    .catch(() => {});
            },
            openModal() {
                this.editmode = false;
                this.form.reset();
                this.form.clear();
            },
            loadRenters: function () {
                axios.get("api/renterlist").then(({
                    data
                }) => (
                    this.renters = data,
                    this.renters.map(item => {
                        return item.item_data = item.fullname;
                    })
                ));
            },
            brachList() {
                axios.get("api/branchlist")
                    .then((data) => {
                        this.branches = data;
                    })
                    .catch(() => {

                    });
            },
        },
        created() {
            Fire.$on("AfterCreate", () => {
                this.searchUser();
            });
            this.brachList();
            this.loadRenters();
            this.searchUser();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>