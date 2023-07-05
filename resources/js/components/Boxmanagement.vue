<template>
    <div class="container-fluid">
 <section  v-if="$gate.cube_null()">
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
        <section v-if="$gate.cube_is_NOTnull()">
             <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> ASSIGN CUBE</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Assign cube</li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.cube_Add_() | $gate.cube_Add_Edit() | $gate.cube_Add_Delete() | $gate.cube_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addStore" @click="addBox">
                                <i class="fa fa-plus" aria-hidden="true"></i> Assign
                            </button>

                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchBox" style="width:100%">
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search key:</label>
                                <input type="text" class="form-control" placeholder="Search" v-model="searchBoxForm.box_number" :class="{ 'is-invalid': searchBoxForm.errors.has('box_number') }" name="box_number">
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2">Due date from:</label>
                                <input type="date" class="form-control" v-model="searchBoxForm.dateFrom">
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2">Due date to:</label>
                                <input type="date" class="form-control" v-model="searchBoxForm.dateTo">
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group clearfix"></div>
                                <label class="pr-2">Due date to:</label>
                                <input type="date" class="form-control" v-model="searchBoxForm.dateTo">
                            </div>
                        </div> -->

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchBoxForm.sort" :class="{ 'is-invalid': searchBoxForm.errors.has('sort') }" name="sort">
                                  <option value>Select</option>
                                  <option value="r.fullname">Renter / seller</option>
                                  <option value="br.name">Branch</option>
                                  <option value="bx.box_number">Cube number</option>
                                  <option value="b.date_of_contract">Date of contract</option>
                                  <option value="b.end_of_contract">End of contract</option>
                                  <option value="b.due_date">Due date</option>
                                  <option value="b.rental_cost">Rental cost</option>
                                </select>
                            </div>
                        </div>
 
                        <!-- <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchBoxForm.sortby" :class="{ 'is-invalid': searchBoxForm.errors.has('sortby') }" name="sortby">
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
                              <router-link to="/branch">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-home" aria-hidden="true"></i> Branch
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
                     <p>Total assigned cube: {{total}} <br />
                     Total amount: {{totalAmount}}
                     </p>
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
                                        <th>Renter / seller</th>
                                        <th>Branch</th>
                                        <th>Cube number</th>
                                        <th>Date of contract</th>
                                        <th>End of contract</th>
                                        <th>Due date</th>
                                        <th>Rental cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(box, index) in boxes.data" :key="index ">
                                        <!-- <td>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'selectbusiness'" true-value="yes" false-value="no">
                                                <label :for="'selectbusiness'"></label>
                                            </div>
                                        </td> -->
                                        <td>{{box.fullname}}</td>
                                        <td>{{box.name}}</td>
                                        <td>{{box.box_number}}</td>
                                        <td>{{box.date_of_contract | myDate}}</td>
                                        <td>{{box.end_of_contract | myDate}}</td>
                                        <td>{{box.due_date | myDate}}</td>
                                        <td>{{box.rental_cost | toCurrency}}</td>
                                        <td>
                                            <!-- <button class="btn btn-danger" @click="deleteBox(box.id)"><i class="fa fa-trash" aria-hidden="true"></i></button> -->
                                            <button v-if="$gate.cube_Edit_() | $gate.cube_Add_Edit() | $gate.cube_Edit_Delete() | $gate.cube_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(box)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </button>
                                            <button v-if="$gate.cube_Delete_() | $gate.cube_Add_Delete() | $gate.cube_Edit_Delete() | $gate.cube_Add_Edit_Delete()" class="btn btn-danger" @click="deleteBox(box.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!---- end body card ------->
                         <div class="card-footer">
                             <pagination :data="boxes" @pagination-change-page="searchBox" :limit="1"></pagination>
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
                            <h5 class="modal-title" id="exampleModalLabel"  v-show="!editmode">Add cube</h5>
                               <h5 class="modal-title" id="exampleModalLabel"  v-show="editmode">Edit cube</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <form @submit.prevent="editmode ? editBox() : createBox()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Renter / seller</label>
                                   <v-select :options="renters"  :reduce="item => item.id" label="item_data" placeholder="Select renter" v-model="form.renter_id" name="renter_id"  :on-search="loadRenters" :value="form.renter_id"  :class="{ 'is-invalid': form.errors.has('renter_id') }"></v-select>
                                   <has-error :form="form" field="renter_id"></has-error>
                                </div>
                           </div>
                           <div class="col-md-12">
                                <div class="form-group">
                                <label>Branch</label>
                                <select name="zone" v-model="form.branch" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('branch') }">
                                    <option value>Select branch</option>
                                  <option v-for="branch in branches.data" :value="branch.id" :key="branch.id">{{ branch.name }} </option>
                                  </select>
                                  <has-error :form="form" field="branch"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Cube number</label>
                                   <v-select :options="boxLists"  :reduce="item => item.id" label="item_data" placeholder="Select cube number" v-model="form.box_id" name="box_id"  :on-search="loadboxlist" :value="form.box_id"  :class="{ 'is-invalid': form.errors.has('box_id') }"></v-select>
                                   <has-error :form="form" field="box_id"></has-error>
                                </div>
                           </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                  <label>Rental cost</label>
                                    <input type="number" class="form-control" placeholder="Rental cost" v-model="form.rental_cost" :class="{ 'is-invalid': form.errors.has('rental_cost') }" name="rental_cost">
                                  <has-error :form="form" field="rental_cost"></has-error>
                                </div>
                           </div>
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Date of contract</label>
                                    <input type="date" class="form-control" placeholder="Date of contract" v-model="form.date_of_contract" :class="{ 'is-invalid': form.errors.has('date_of_contract') }" name="date_of_contract">
                                  <has-error :form="form" field="date_of_contract"></has-error>
                                </div>
                           </div>
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>End of contract</label>
                                    <input type="date" class="form-control" placeholder="End of contract" v-model="form.end_of_contract" :class="{ 'is-invalid': form.errors.has('end_of_contract') }" name="end_of_contract">
                                  <has-error :form="form" field="end_of_contract"></has-error>
                                </div>
                           </div>
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Due date</label>
                                     <input type="date" class="form-control" placeholder="Mobile number" v-model="form.due_date" :class="{ 'is-invalid': form.errors.has('due_date') }" name="due_date" >
                                     <has-error :form="form" field="due_date"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Description</label>
                                    <input type="text" class="form-control" placeholder="Description" v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" name="description">
                                  <has-error :form="form" field="description"></has-error>
                                </div>
                           </div>
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-primary">Update cube</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">Save cube</button>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </section>

    </div> <!---- container------>
</template>

<script>
    export default {
     components: {

      },
      data() {
            return {
                add_count: 0,
                total: "",
                totalAmount: 0,
                renters: [],
                boxLists: [],
                editmode:false,
                branches: {},
                boxes: {},
                searchBoxForm: new Form({
                    id: '',
                    box_number: '',
                    sort:"",
                    sortby: 'desc',
                    dateFrom: '',
                    dateTo: '',
                }),
                form: new Form({
                    id: '',
                    branch: '',
                    renter_id: '',
                    box_id: '',
                    rental_cost: '',
                    date_of_contract: '',
                    end_of_contract: '',
                    due_date: '',
                    description: ''
                }),
            };
        },
      methods:{
          addBox(){
            this.editmode = false;
            this.form.reset();
            this.form.clear();
          },
          editItem(item){
            this.form.fill(item);
            this.editmode = true;
            $("#addStore").modal("show");
          },
          editBox(){
              this.form
                .put("api/boxes/" + this.form.id)
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
          deleteBox(id){
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
                           axios.delete("api/boxes/" + id)
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
          searchBox(page = 1){
              this.searchBoxForm
                    .post("api/searchbox?page=" + page)
                        .then((data) => {
                            this.boxes = data.data;
                            this.total = data.data.total;
                            this.totalAmount = data.data.totalAmount;
                        })
                        .catch(() => {

                        });
          },
          createBox(){
              if(this.add_count == 0){
                  this.add_count = 1;
                  this.form
                    .post("api/boxes")
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
              
          },
          loadRenters: function() {
            axios.get("api/renterlist").then(({ data }) => (
                this.renters = data,
                this.renters.map(item =>{
                    return item.item_data = item.fullname;
                })
            ));
          },

          loadboxlist: function() {
            axios.get("api/loadboxlistselect").then(({ data }) => (
                this.boxLists = data,
                this.boxLists.map(item =>{
                    return item.item_data = item.box_number;
                })
            ));
          },

          brachList(){
                axios.get("api/branchlist")
                    .then((data) => {
                        this.branches = data;
                    })
                    .catch(() => {

                    });
            },
      },
      created(){
        Fire.$on("AfterCreate", () => {
            this.searchBox();
            this.loadboxlist();
        });
        this.brachList();
        this.searchBox();
        this.loadRenters();
        this.loadboxlist();
      },
        mounted() {

        }
    }
</script>
