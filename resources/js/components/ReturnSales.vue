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
                      <h3 style="color:#34495e"> RETURN SALES</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Return sales </li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.pos_Add_() | $gate.pos_Add_Edit() | $gate.pos_Add_Delete() | $gate.pos_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addRetrunSale" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Return sale
                            </button>

                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchReturnSales" style="width:100%">
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
                                <label class="pr-2">Due date from:</label>
                                <input type="date" class="form-control" v-model="searchForm.dateFrom">
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2">Due date to:</label>
                                <input type="date" class="form-control" v-model="searchForm.dateTo">
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="asc">Invoice #</option>
                                <option value="asc">Product name</option>
                                <option value="asc">Quantity</option>
                                <option value="asc">Date</option>
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
                     <p>Total records: {{total}}</p>
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
                                        <th>Invoice #</th>
                                        <th>Product name</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in rsales.data" :key="index ">

                                        <!-- <td>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" :id="'selectbusiness'" true-value="yes" false-value="no">
                                                <label :for="'selectbusiness'"></label>
                                            </div>
                                        </td> -->
                                        <td>{{item.reference_no}}</td>
                                        <td>{{item.sku}} - {{item.product_name}}</td>
                                        <td>{{item.quantity}}</td>
                                        <td>{{item.date_return | myDate}}</td>
                                        <td>
                                            <button v-if="$gate.pos_Edit_() | $gate.pos_Add_Edit() | $gate.pos_Edit_Delete() | $gate.pos_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </button>
                                            <button v-if="$gate.pos_Delete_() | $gate.pos_Add_Delete() | $gate.pos_Edit_Delete() | $gate.pos_Add_Edit_Delete()" class="btn btn-danger" @click="deleteReturn(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div><!-- end car body -->
                         <div class="card-footer">
                             <pagination :data="rsales" @pagination-change-page="searchReturnSales" :limit="1"></pagination>
                        </div>
                    </div><!--- end card -->
                </div>
            </div> <!-- row -->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->
        <section>
           <div class="modal fade" id="addRetrunSale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Return sale</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      <form @submit.prevent="editmode ? editreturnSale() : createreturnSale()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Invoice no.</label>
                                   <v-select :options="salesreturn" placeholder="Select invoice no."  :reduce="item => item.id" label="item_data" v-model="form.sale_id" :class="{ 'is-invalid': form.errors.has('sale_id') }" name="sale_id"  :on-search="laodSales" :value="form.sale_id" v-on:input="loadProducts" ></v-select>
                                    <has-error :form="form"  field="sale_id"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>location</label>
                                    <v-select :options="products" placeholder="Select location"  :reduce="item => item.id" label="item_data" v-model="form.saleprod_id" :class="{ 'is-invalid': form.errors.has('saleprod_id') }" name="saleprod_id"  :on-search="loadProducts" :value="form.saleprod_id" ></v-select>
                                     <has-error :form="form"  field="saleprod_id"></has-error>
                                </div>
                           </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                  <label>Quantity</label>
                                     <input type="number" class="form-control" placeholder="Qty" v-model="form.quantity" :class="{ 'is-invalid': form.errors.has('quantity') }" name="quantity">
                                     <has-error :form="form"  field="quantity"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Date</label>
                                     <input type="date" class="form-control"  v-model="form.date_return" :class="{ 'is-invalid': form.errors.has('date_return') }" name="date_return">
                                     <has-error :form="form"  field="date_return"></has-error>
                                </div>
                           </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Remarks</label>
                                    <textarea class="form-control" rows="3" placeholder="Remarks"  v-model="form.notes" :class="{ 'is-invalid': form.errors.has('notes') }" name="notes"></textarea>

                                </div>
                           </div>
                        </div><!-- end row -->
                    </div> <!-- end modal contennt -->
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
                editmode:false,
                rsales: {},
                products: [],
                salesreturn: [],
                searchForm: new Form({
                    id: '',
                    searchForm: '',
                    sort: "",
                    dateFrom: '',
                    dateTo: '',
                }),
                form: new Form({
                    id: '',
                    sale_id: '',
                    saleprod_id: '',
                    quantity: '',
                    date_return: '',
                    notes: '',
                }),
            };
        },
        methods:{
            openModal(){
                this.editmode = false;
                this.form.reset();
                this.form.clear();
            },
            searchReturnSales(page = 1){
                this.searchForm
                    .post("api/searchreturn?page=" + page)
                        .then((data) => {
                            this.rsales = data.data;
                            this.total = data.data.total;
                        })
                        .catch(() => {
                        });
            },
            deleteReturn(id){
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
                           axios.delete("api/returnsale/" + id)
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
            editItem(item){
                this.editmode = true;
                this.form.fill(item);
                this.loadProducts();
                this.form.saleprod_id = item.saleprod_id;
                $("#addRetrunSale").modal("show");
            },
            editreturnSale(){
                this.form
                .put("api/returnsale/" + this.form.id)
                    .then(() => {
                        $('#addRetrunSale').modal('hide');
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
            createreturnSale(){
                this.form
                    .post("api/returnsale")
                        .then(() => {
                            Fire.$emit("AfterCreate");
                            Swal.fire("Success!", "Record has been successfully saved", "success");
                            $("#addRetrunSale").modal("hide");
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong!',
                                text: 'Kindly check and complete required fields.'
                            })
                        });
            },
            laodSales: function() {
            axios.get("api/saleslist").then(({ data }) => (
                this.salesreturn = data,
                this.salesreturn.map(item =>{
                    return item.item_data = item.reference_no;
                })
            ));
          },
          loadProducts: function() {
            this.form.saleprod_id = "";
            this.form
            .post("api/productlist").then(({ data }) => (
                console.log(data),
                this.products = data,
                this.products.map(item =>{
                    return item.item_data =  item.sku + '-' + item.product_name + ' (' +item.fullname + ' - ' + item.name + ' - ' + item.box_number + ')';
                })
            ));
          },
        },
        created() {
            Fire.$on("AfterCreate", () => {
              this.searchReturnSales();
            });
            this.laodSales();
            this.loadProducts();
            this.searchReturnSales();
         },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>