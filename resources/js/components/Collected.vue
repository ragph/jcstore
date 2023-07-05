<template>
    <div class="container-fluid">
                   <section    v-if="$gate.rent_null()">
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
                      <h3 style="color:#34495e"> RENT MANAGEMENT - COLLECTED</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Collected </li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2"  v-if="$gate.rent_Add_() | $gate.rent_Add_Edit() | $gate.rent_Add_Delete() | $gate.rent_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addPayment" @click="addPayment">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add payment
                            </button>
                        </div>
                        <div class="col-md-12 pb-2"  v-if="$gate.rent_Add_() | $gate.rent_Add_Edit() | $gate.rent_Add_Delete() | $gate.rent_Add_Edit_Delete()">
                            <button class="btn btn-success btn-block" data-toggle="modal" data-target="#addPayment" @click="advancePayment">
                                <i class="fa fa-plus" aria-hidden="true"></i> Advance payment
                            </button>
                        </div>
                        <div class="col-md-12"  v-if="$gate.rent_Add_() | $gate.rent_Add_Edit() | $gate.rent_Add_Delete() | $gate.rent_Add_Edit_Delete()">
                            <div class="form-group clearfix">
                                 <button class="btn btn-info btn-block" style="color: #fff" @click="openGenerateBill">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Generate billing statement
                            </button>
                            </div>
                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                     <form @submit.prevent="searchDueDate" style="width:100%">
                        <div class="col-md-12 ">
                          <div class="form-group clearfix">
                              <label class="pr-2 "> Search key:</label>
                              <input type="text" class="form-control" placeholder="Search" v-model="searchDueDateForm.searchinpt" :class="{ 'is-invalid': searchDueDateForm.errors.has('searchinpt') }" name="searchinpt">
                          </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-row">
                                <div class="col">
                                    <label class="pr-2 "> Date from:</label>
                                    <div class="form-group clearfix">
                                        <input type="date" class="form-control"  v-model="searchDueDateForm.dateFrom" :class="{ 'is-invalid': searchDueDateForm.errors.has('dateFrom') }" name="dateFrom">
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="pr-2 "> Date to:</label>
                                    <div class="form-group clearfix">
                                        <input type="date" class="form-control"  v-model="searchDueDateForm.dateTo" :class="{ 'is-invalid': searchDueDateForm.errors.has('dateTo') }" name="dateTo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select name="sort"  id="role" class="form-control" v-model="searchDueDateForm.sort">
                                    <option value>Select</option>
                                    <option value="rnt.fullname">Renter / seller</option>
                                    <option value="br.name">Branch</option>
                                    <option value="b.box_number">Cube #</option>
                                    <option value="bill.month_covered">Payment due date</option>
                                    <option value="bm.rental_cost">Rent cost</option>
                                </select>
                            </div>
                            <!-- <div class="form-group clearfix">
                                <label class="pr-2"> Sort by</label>
                                <select name="sortBy"  id="role" class="form-control" v-model="searchDueDateForm.sortBy">
                                    <option value>Select</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div> -->
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
                              <label class="pr-2 "> Utilities:</label>
                              <router-link to="/collected">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-list-alt" aria-hidden="true"></i> Collected
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
                  <p>Total records: {{total}}<br/>
                    Total amount: {{totalAmount}}</p>
                    <div class="card card-primary card-outline">
                        <!-- /.card-header -->
                         <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Renter / seller</th>
                                            <th>Branch</th>
                                            <th>Cube #</th>
                                            <th>Payment due date</th>
                                            <th>Rent cost</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <tr v-for="(rent, index) in rents.data" :key="index"  v-bind:class="{ '' : rent.status == 'Due date' , '' : rent.status == 'Over due' }">
                                            <td>{{rent.fullname}}</td>
                                            <td>{{rent.branch}}</td>
                                            <td>{{rent.box_number}}</td>
                                            <td>{{rent.monthcovered | myDate}}</td>
                                            <td>{{rent.rental_cost | toCurrency}}</td>
                                            <td>{{rent.status}}</td>
                                            <td>
                                                <button  v-if="$gate.rent_Add_() | $gate.rent_Add_Edit() | $gate.rent_Add_Delete() | $gate.rent_Add_Edit_Delete()" class="btn btn-success" @click="editItem(rent)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </button>
                                                <button v-if="$gate.rent_Delete_() | $gate.rent_Add_Delete() | $gate.rent_Edit_Delete() | $gate.rent_Add_Edit_Delete()" class="btn btn-danger" @click="deletePayment(rent.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                             <pagination :data="rents" @pagination-change-page="searchDueDate" :limit="1"></pagination>
                            </div>
                        </div>
                </div>
            </div> <!---- row ------->
        </section>
        <!-- =================================================================================================================================== -->
        <!-- GENERATE BILL -->
        <!-- Modal -->
        <div class="modal fade" id="generateBill" tabindex="-1" role="dialog" aria-labelledby="generateBill" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateBillTitle">Generate billing statement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="generateBill">
                <div class="modal-body">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Month covered</label>
                                <input type="month" class="form-control" v-model="genereBillForm.date" :class="{ 'is-invalid': genereBillForm.errors.has('date') }" name="date">
                                </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- END GENERATE BILL -->
        <!-- ADD CATEGORY MODAL -->
        <section>
           <div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-show="paymentAdd" v-if="!editmode">Add payment</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-show="!paymentAdd" v-if="!editmode">Advance payment</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="editmode ? editPayment() : createPayment()">
                    <div class="modal-body">
                       <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Location</label>
                                   <v-select :options="renters"  :reduce="item => item.id" label="item_data" placeholder="Select renter" v-model="form.box_id" name="box_id" :on-search="loadRenters" :value="item => item.boxid" v-on:input="clickSearchResult"  :class="{ 'is-invalid': form.errors.has('box_id') }"></v-select>
                                   <has-error :form="form" field="box_id"></has-error>

                                </div>
                           </div>

                           <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="form.is_cheque">
                                    <label class="form-check-label" for="exampleCheck1">Cheque</label>
                                </div>
                            </div>
                            
                           <div class="col-md-12" v-if="!form.is_cheque">
                                <div class="form-group">
                                    <label>Cash</label>
                                    <input type="number" step="0.1" class="form-control" placeholder="0.00"
                                        v-model.number="form.cash" :class="{ 'is-invalid': form.errors.has('cash') }"
                                        name="cash">
                                        <has-error :form="form" field="cash"></has-error>
                                </div>
                            </div>

                            <div class="col-md-12" v-if="form.is_cheque">
                                <div class="form-group">
                                    <label>Cheque number</label>
                                    <input type="text" class="form-control" placeholder="Cheque number" v-model="form.cheque_number" :class="{ 'is-invalid': form.errors.has('cheque_number') }" name="box_number">
                                </div>
                            </div>                                    

                            <div class="col-md-12" v-if="form.is_cheque">
                                <div class="form-group">
                                    <label>Bank</label>
                                    <input type="text" class="form-control" placeholder="Bank"
                                        v-model="form.bank" :class="{ 'is-invalid': form.errors.has('bank') }"
                                        name="bank">
                                </div>
                            </div>

                             <div class="col-md-12" v-if="!paymentAdd">
                                <div class="form-group">
                                  <label>Month covered</label>
                                    <input type="date" class="form-control" v-model="form.monthcovered" :class="{ 'is-invalid': form.errors.has('monthcovered') }" name="monthcovered">
                                 </div>
                              </div>
                             <div class="col-md-12" v-if="paymentAdd">
                                <div class="form-group">
                                  <label>Month covered</label>
                                  <select name="monthcovered" v-model="form.monthcovered" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('monthcovered') }">
                                    <option value>Select</option>
                                    <option v-for="item in monthlist" :value="item.due_date" :key="item.id">{{ item.due_date | billingDate}}</option>
                                    </select>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Amount</label>
                                    <!-- <input type="number" class="form-control" placeholder="Amount" name="" > -->
                                    <input type="text" class="form-control" placeholder="Amount" v-model="form.amount" :class="{ 'is-invalid': form.errors.has('amount') }" name="amount" :disabled="true">
                                </div>
                           </div>
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Pay</button>
                        <button v-show="editmode" type="submit" class="btn btn-primary">Edit</button>
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
              total: 0,
              totalAmount: 0,
                renters: [],
                editmode: false,
                paymentAdd: false,
                searchSeller: false,
                rents: {},
                renterData: {},
                monthlist: {},
                renterSearch: new Form({
                    id: '',
                    name: ''
                }),
                genereBillForm: new Form({
                    id: '',
                    date: ''
                }),
                searchDueDateForm: new Form({
                    id: '',
                    dateFrom: '',
                    dateTo: '',
                    sort: '',
                    sortBy: '',
                    searchinpt: '',
                }),
                form: new Form({
                    id: '',
                    box_id: '',
                    cheque_number: '',
                    monthcovered: '',
                    bank: '',
                    amount: '',
                    renter_id: '',
                    is_cheque: false,
                    cash: null,
                    boxid: '',
                }),
            };
        },
      methods:{
          generateBill(){
            //   console.log("Hello world");
            this.genereBillForm
                    .post("api/createduedate")
                        .then((data) => {
                            Fire.$emit("AfterCreate");
                            $("#generateBill").modal("hide");
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong!',
                                text: 'Kindly check and complete required fields.'
                            })
                        });
          },
          openGenerateBill(){
            $("#generateBill").modal("show");
            this.genereBillForm.reset();
            this.genereBillForm.clear();
          },
          deletePayment(id){
               Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.value) {
                           axios.delete("api/rent/" + id)
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
              $("#addPayment").modal("show");

              
              this.loadRenters();
              this.editmode= true;
              this.paymentAdd = true;
              this.form.fill(item);

              if(this.form.is_cheque == 1){
                  this.form.is_cheque = true;
              }else{
                  this.form.is_cheque = false;
              }
             
             this.bid = item.boxid;
             this.form.box_id = item.fullname+'-'+item.branch+'-'+item.box_number;

             this.form.post("api/monthcollectedlist?id="+item.boxid).then(({ data }) => (this.monthlist = data));
          },
          editPayment(){
              this.form.box_id =  this.bid;
               this.form
                .put("api/rent/" + this.form.id)
                    .then((data) => {
                        $("#addPayment").modal("hide");
                        Swal.fire( data.data.status, data.data.message,  data.data.icon);
                        Fire.$emit("AfterCreate");
                        console.log("Hello world");
                    })
                    .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: 'Kindly check and complete required fields.'
                    })
                });
          },
          createPayment(){
              if(this.add_count == 0){
                  this.add_count = 1;
                  this.form
                    .post("api/rent")
                        .then((data) => {
                            console.log(data.data);
                            Fire.$emit("AfterCreate");
                            Swal.fire( data.data.status, data.data.message,  data.data.icon);
                            $("#addPayment").modal("hide");
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
          clickSearchResult(){
            let box_id =  this.renters.find(x => x.id === this.form.box_id);
            this.form.renter_id =  this.renters.find(x => x.id === this.form.box_id)['renter_id'];
            this.searchSeller = false;
            this.form.id =  box_id['boxid'];
            this.form.post("api/monthcoveredlist?id="+box_id['boxid']).then(({ data }) => (this.monthlist = data));
            this.loadPaymentAmount(box_id['boxid']);
          },
          searchDueDate(){
            this.searchDueDateForm
                .post("api/searchpaiddate")
                    .then((data) => {
                        this.rents = data.data;
                        this.total = data.data.total;
                        this.totalAmount = data.data.totalAmount;
                        if(this.rents.status == "Due date"){

                        };
                    })
                    .catch(() => {

                    });
          },
          addPayment(){
              this.paymentAdd = true;
              this.form.clear();
              this.editmode = false;
              this.renterSearch.reset();
              this.form.reset();
          },
          advancePayment(){
              this.paymentAdd = false;
              this.form.clear();
              this.editmode = false;
              this.renterSearch.reset();
              this.form.reset();
          },
        loadPaymentAmount(id){
            axios.post("api/paymentrentamount?id="+id).then(({ data }) => {
                this.form.amount = data;
            });
        },
        loadRenters: function() {
            axios.get("api/boxlistlocation").then(({ data }) => (
                this.renters = data,
                this.renters.map(item =>{
                    return item.item_data = item.fullname+'-'+item.branch+'-'+item.box_number;
                })
            ));
          },
      },
      created(){

        Fire.$on("AfterCreate", () => {
            this.searchDueDate();
        });

        this.searchDueDate();
        this.loadRenters();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
