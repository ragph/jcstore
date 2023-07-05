`<template>
    <div class="container-fluid sales-product-item">
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
        <section  v-if="$gate.pos_is_NOTnull()">
             <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e">Add POS</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Add POS </li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                  <!-- <div class="row">
                    <div class="col-md-12">
                       <p>Status: Barcode reader detected </p>
                    </div>
                  </div> -->
                  <div class="card">
                    <div class="card-body">
                       <div class="row ">
                        <div class="col-md-12 pb-2">
                           <div class="form-inline" autocomplete="off" style="align-items: unset;">
                                  <label style="padding-right: 10px;" v-shortkey="['ctrl', 'q']" @shortkey="resetTable()">Search product: </label>
                                  <input class="form-control flex-fill" id="myInput" type="text" ref="searchProduct" placeholder="Search.." v-on:keyup.enter="searchProducts" v-model="searchProductsForm.product" v-shortkey.focus="['ctrl', 'f']" autocomplete="off"/>
                                    <ul  class="list-group" style="padding-top:40px" id="myList" v-show="listProduct" v-shortkey="['ctrl','`']" @shortkey="fillSearchField">
                                      <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(product, index) in products" :key="index" v-on:click="selectProduct(product)" :id="'searchproduct'+index" v-shortkey="{up: ['arrowup'], down: ['arrowdown']}" @shortkey="selectSearchProduct">
                                          {{product.product_name}} ({{product.sku}}-{{product.fullname}}-{{product.box_number}})
                                          <span class="badge badge-primary badge-pill">{{product.quantity}}</span>
                                      </li>
                                  </ul>
                              </div>
                             
                        </div>

                        <div class="col-md-12 pb-2">
                         <table class="table product-table-item">
                           <thead>
                             <tr>
                               <th  colspan="2">
                                 Product name:
                                <label style="color:#3490dc" v-if="orderForm.id"> {{orderForm.product_name}} ({{orderForm.sku}}-{{orderForm.fullname}}-{{orderForm.box_number}})</label>
                              </th>
                             </tr>
                             <tr>
                              <th colspan="2">
                                  <div class="form-inline" autocomplete="off">
                                      <label style="padding-right:10px;">Quantity:</label>
                                      <input type="number" class="form-control flex-fill" ref="searchProduct" :autofocus="autofocus" name="quantityItem" v-model="orderForm.number" min="1" v-on:keyup="totalPayment()" v-on:change="totalPayment()"  v-shortkey.focus="['ctrl', 'q']">
                                  </div>
                                  <div class="mt-2">

                                    <label class="radio-inline mr-3">
                                      Product type: <input type="radio" v-model="saleForm.saleprice" value="retail" name="optradio" v-on:change="findSalePrice" class="ml-2"> Retail
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="optradio" v-model="saleForm.saleprice" value="wholesale" v-on:change="findSalePrice"> Wholesale
                                    </label>
                                  </div>
                                </th>
                              </tr>
                             <tr>
                                <th width="60%">
                                  
                                  <div class="form-inline" autocomplete="off">
                                    <label style="padding-right:10px;">Price:</label>
                                    <input type="number" class="form-control flex-fill" name="quantityItem" step="0.1" v-model="orderForm.price" min="1" >
                                  </div>
                                 
                                 <!-- {{orderForm.price | toCurrency}} -->
                                </th>
                                <th>
                                  <span class="pos-status">Status:{{orderForm.stock}}</span>
                                </th>
                             </tr>
                             <tr>
                                 <th colspan="2">
                                   On hand:
                                  {{orderForm.quantity}}
                                 </th>
                                <!-- <th>
                                  <div class="input-group">
                                    <input type="text" class="form-control" id="coupon" placeholder="Coupon" aria-describedby="coupon" v-shortkey.focus="['ctrl', 'c']">
                                    <span class="input-group-btn">
                                      <button class="btn btn-primary" type="submit">
                                          <i class="fa fa-tag"></i>
                                      </button>
                                    </span>
                                    </input>
                                  </div>
                                </th> -->
                             </tr>
                           </thead>
                         </table>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#returnProduct" v-on:click="addToOrder(orderForm.id)" v-shortkey="['ctrl', 'space']" @shortkey="addToOrder(orderForm.id)" :disabled="disabledSearch">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to order
                              </button>
                            </div>
                        </div>
                         <div class="col-md-12 ">
                            <div class="form-group clearfix">
                              <button class="btn btn-danger btn-block" v-shortkey="['ctrl', 'x']" @shortkey="clearItem" v-on:click="clearItem">
                                <i class="fa fa-undo" aria-hidden="true"></i> Clear product
                              </button>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 ">
                            <div class="form-inline clearfix">
                              <label style="padding-right: 10px;">Customer Name: </label>
                                <input class="form-control flex-fill" id="cust_name" type="text" ref="cust_name"  placeholder="Enter Customer Name" v-shortkey.focus="['ctrl', 'n']" v-on:keyup="productPayment" v-model="form.cust_name" :class="{ 'is-invalid': form.errors.has('cust_name') }">
                                <has-error :form="form" field="cust_name"></has-error>
                            </div>
                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="form-inline clearfix">
                              <label style="padding-right: 10px;">Payment:</label>
                                <input class="form-control flex-fill" id="payment" type="number" step=".01" ref="payment"  placeholder="0.00" v-shortkey.focus="['ctrl', 'p']" v-on:keyup="productPayment" min="0" v-model="form.payment" :class="{ 'is-invalid': form.errors.has('payment') }">
                                <has-error :form="form" field="payment"></has-error>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 mt-2">
                            <div class="form-group row total-results">
                              <div  class="col-sm-8 float-sm-right">
                                 <label class="float-sm-right">Amount due:</label>
                               </div>
                                <div class="col-sm-4 float-sm-right">
                                  <p style="color:red;font-weight:bold">{{form.totalProduct | toCurrency}}</p>
                                </div>
                            </div>
                             <div class="form-group row total-results">
                               <div  class="col-sm-8 float-sm-right">
                                 <label class="float-sm-right"> VAT:</label>
                               </div>
                                <div class="col-sm-4 float-sm-right">
                                  <p>{{form.tax | toCurrency}}</p>
                                </div>
                            </div>
                             <div class="form-group row total-results">
                              <div  class="col-sm-8 float-sm-right">
                                 <label class="float-sm-right"> Change:</label>
                               </div>
                                <div class="col-sm-4 float-sm-right">
                                  <p>{{form.payment != 0 ? form.totalPayment : 0.00 | toCurrency}}</p>
                                </div>
                            </div>
                        </div>
<!--
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Comments:</label>
                               <textarea class="form-control" rows="2" placeholder="Comments"></textarea>
                            </div>
                        </div> -->

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#returnProduct" v-on:click="saveOrder" v-shortkey="['ctrl', 'enter']" @shortkey="saveOrder()">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Save & continue
                              </button>
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                              <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#returnProduct" v-on:click="cancelOrder" v-shortkey="['ctrl', 'shift', 'x']" @shortkey="cancelOrder()">
                                <i class="fa fa-trash" aria-hidden="true"></i> Cancel items
                              </button>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                              <div class="form-group clearfix">

                              </div>
                            </div>
                        </div>
                         <div class="col-md-12 mt-2" >
                            <div class="form-group clearfix">
                                <router-link to="/dashboard"><button class="btn btn-success float-sm-right btn-block">Back to dashboard</button></router-link>
                            </div>
                        </div>
                    </div>
                    </div>
                  </div>

                </div>

                <div class="col-md-8">
                  <div class="card">
                      <div class="card-body">
                          <div class="row">
                    <div class="col-md-12">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Product name</th>
                            <th>Quantity </th>
                            <th>Price </th>
                            <th>Total </th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(productItem, index) in form.products" :key="index" v-shortkey="{tab: ['tab'], shifttab: ['shift','tab']}" @shortkey="deleteFromTable" :id="'productTableItem'+index">
                            <template v-if="index != 0">
                              <td>{{form.products[index].product_name}}</td>
                              <td>
                                {{form.products[index].quantity}}
                              </td>
                              <td>
                                {{form.products[index].price | toCurrency}}
                              </td>
                              <td>{{form.products[index].total | toCurrency}}</td>
                              <td> <button class="btn btn-danger" v-on:click="deleteFromOrder(index, productItem)"><i class="fa fa-trash" aria-hidden="true" v-shortkey="['del']" @shortkey="deleteItem()"></i> DELETE </button></td>
                            </template>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                      </div>
                  </div>
                </div>
            </div> <!---- row ------->
        </section>


          <!-- INVOICE -->
          <div class="modal fade" id="ViewInvoice" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl"  role="document" style=" font-family:  'Courier New', Courier, monospace;">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="resetForm">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="printInvoice()">
                        <div class="modal-body" id="invoice">
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <!-- <h5 style="color:#ff7979;font-weight:bold">JUZEL CONCEPT STORE</h5>
                                    <label>{{branch.branch_name}} {{branch.address}}</label><br>
                                    <label>09523285456 / 08469952322</label> -->
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
                                                <td><label>{{form.name}}</label></td>
                                           </tr>
                                           <tr>
                                               <td><label>Date/Time:</label></td>
                                                <td><label>{{form.created_at}}</label></td>
                                           </tr>
                                           <tr>
                                               <td><label>Customer Name:</label></td>
                                                <td><label>{{form.cust_name}}</label></td>
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
                                            <tr v-for="(item, index) in form.products" :key="item.id ">
                                              <template v-if="index != 0">
                                                <td>{{item.sku}} - {{item.product_name}}</td>
                                                <td>{{item.quantity}}</td>
                                                <td>{{item.price | toCurrency}}</td>
                                                <td>{{item.total | toCurrency}}</td>
                                              </template>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <label>Total:</label><br>
                                                    <label>Tax:</label><br>
                                                    <label>Total payment:</label><br>
                                                    <label>Change:</label>
                                                </td>
                                                <td>
                                                    <label>{{form.totalProduct | toCurrency }}</label><br>
                                                    <label>{{form.tax | toCurrency }}</label><br>
                                                    <label>{{form.payment | toCurrency }}</label><br>
                                                    <label>{{form.totalPayment | toCurrency }}</label>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" v-on:click="resetForm">Close</button>
                        <button type="submit" class="btn btn-primary">Print invoice</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->

    </div> <!---- container------>
</template>

<script>
import moment from 'moment';
import VueUploadMultipleImage from 'vue-upload-multiple-image';
    export default {
       beforeRouteLeave (to, from, next) {
        if(this.form.totalProduct > 0){
          let r = confirm("Do you want to proceed?");
          if (r == true) {
            next();
          } else {
            next(false);
          }
        
        }else{
          next();
        }  
      },
     components: {
        VueUploadMultipleImage,
      },
      data() {
            return {
                settingsTax:{},
                isActive: true,
                autofocus: false,
                renters: [],
                products: {},
                branch: {},
                delayHotkey: 0,
                searchTotal: -1,
                total: 0,
                salePrice: '',
                productTotal: 0,
                tableRow: 0,
                disabledSearch: false,
                listProduct: false,
                orderForm: new Form({
                  id: '',
                  product_name: '',
                  sku: '',
                  box_number: '',
                  price: '',
                  stock: '',
                  number: '1',
                  quantity: '',
                  coupon: '',
                  location_id: '',
                  fullname: ''
                }),
                saleForm: new Form({
                  id: '',
                  saleprice: 'retail',
                  qty: ''
                }),
                barcodeSearch: new Form({
                  barcode: ''
                }),
                searchProductsForm: new Form({
                  id: '',
                  product: ''
                }),
                form: new Form({
                  id: '',
                  products: [{
                    id: '',
                    location_id: '',
                    product_name: '',
                    remaining: '',
                    quantity: 0,
                    price: '',
                    total: 0,
                    saleprice: '',
                    sku: ''
                  }],
                  reference_no: '',
                  name: '',
                  created_at: moment().format('MMM. DD, YYYY h:mm:ss a'),
                  cust_name: '',
                  sale_type: 'nondirect',
                  payment: '',
                  totalProduct: 0,
                  tax: 0,
                  totalPayment: 0
                }),
            };
        },
        methods:{
          findSalePrice(){
            if(this.orderForm.product_name != ''){
              this.saleForm
                .post("api/saleprice")
                  .then((data) => {
                    if(this.saleForm.saleprice == 'wholesale'){
                      this.orderForm.price = data.data.wholesale;
                    }else{
                      this.orderForm.price = data.data.sell_price;
                    }
                  }).catch(() => {
                    Swal.fire({
                          icon: 'error',
                          title: 'Something went wrong!',
                          text: 'Select product'
                      })
                      this.saleForm.saleprice = 'retail';
                  });
            }


          },
          // BARCODE
            onBarcodeScanned (barcode) {
              this.barcodeSearch.barcode = barcode;

            this.barcodeSearch
              .post("api/barcodesearch")
                  .then((data) => {
                    this.selectProduct(data.data[0]);
                  })
                  .catch(() => {

                  });

            },
            resetBarcode () {
              let barcode = this.$barcodeScanner.getPreviousCode()
            },
          // END BARCODE
          resetTable(){
            jQuery('#productTableItem'+this.tableRow).removeClass('table-info');
            this.tableRow = 0;
          },
          deleteItem(){
            if(this.tableRow > 0){
              var idx = this.form.products.indexOf(this.form.products[this.tableRow]);
              if (idx > -1) {
                  this.form.products.splice(idx, 1);
                  this.totalPayment();
              }
            }
          },
          deleteFromTable(event){
            jQuery('#productTableItem'+this.tableRow).removeClass('table-info');
            if(this.form.products.length > 1){
              switch (event.srcKey) {
              case 'tab':
                this.tableRow = this.tableRow + 1;
                 if(this.tableRow >= this.form.products.length){
                   this.tableRow = this.form.products.length - 1;
                 }
                break
              case 'shifttab':
                this.tableRow = this.tableRow - 1;
                if(this.tableRow < 1){
                  this.tableRow = 1
                }
                break
              }
              setTimeout(() => {
                jQuery('#quantityItem'+this.tableRow).focus();
              })
              jQuery('#productTableItem'+this.tableRow).addClass('table-info');
            }

          },
          fillSearchField(){
            if(this.products.length){
              this.searchProductsForm.product = this.orderForm.product_name;
            }else{
              this.searchProductsForm.product = "";
            }
            this.listProduct = false;
            this.searchTotal = -1;
          },
          focusSearchProduct(){
            this.$refs.searchProduct.focus();
          },
          selectSearchProduct(event){

            jQuery('#searchproduct'+this.searchTotal).removeClass('active');
            if(this.products.length){
              switch (event.srcKey) {
              case 'up':
                this.searchTotal = this.searchTotal - 1;
                if(this.searchTotal < 0){
                  this.searchTotal = 0;
                }
                break

              case 'down':
                 this.searchTotal = this.searchTotal + 1;

                 if(this.searchTotal >= this.products.length){
                   this.searchTotal = this.products.length - 1;
                 }
                break
              }
          this.orderForm.fill(this.products[this.searchTotal]);
          this.searchProductsForm.product = this.products[this.searchTotal].product_name;
          jQuery('#searchproduct'+this.searchTotal).addClass('active');

          if(this.orderForm.quantity <= 0){
            this.disabledSearch = true;
          }else{
            this.disabledSearch = false;
          }
            }
          },
          // END SHORTCUT KEYS
          productPayment(){
            this.form.totalPayment = this.form.payment - this.form.totalProduct;
          },
          loadTax(){
             axios.get("api/getsettings").then(({ data }) => {
                this.settingsTax = data[0]['tax'] / 100 ;

            });
          },
          totalPayment(id = null){
            if(id){
              let remaining = this.orderForm.quantity - this.orderForm.quantity;
              if(remaining < 0){
                Swal.fire("Error", "Remaining must not negative value", "error");
                this.form.products.quantity = 1;
              }
            }

            let sub_total = 0;

            for(let i = 0; i < this.form.products.length; i++){
                sub_total = this.form.products[i].total + sub_total;
            }

            let total = this.total + sub_total;

            this.form.totalProduct = total;
            this.form.tax = total *  this.settingsTax;
            this.form.totalPayment = this.form.payment - this.form.payment;
          },

          cancelOrder(){
            this.form.reset();
            this.totalPayment();
            localStorage.removeItem("product");
          },
          printInvoice(){
            this.form
                    .post("http://localhost/printtest/api/printpos")
                        .then((data) => {
                            $("#ViewInvoice").modal("hide");
                            // this.history = data.data;
                            // this.total = data.data.total;
                            // this.totalAmount = data.data.totalAmount;
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
          resetForm(){
            this.form.reset();
          },
          saveOrder(){
            if(this.delayHotkey == 0){
              this.delayHotkey = 1;
              Swal.fire({
                text: "Press enter to continue",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continue'
              }).then((result) => {
                if (result.value) {


                 this.form
                  .post("api/pointofsale")
                      .then((data) => {
                        this.branch = data.data;
                        Swal.fire({
                            title: 'Success!',
                            text: 'Reference no. '+data.data.reference_number,
                            icon: 'success',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if (result.value) {
                              $("#ViewInvoice").modal("show");
                              this.form.name = this.$gate.user.username;
                              this.form.reference_no = data.data.reference_number;
                              localStorage.removeItem("product");
                            }
                          })

                        // Swal.fire("Success!", "Items has been successfully saved <br>Reference no. "+data.data+"", "success");
                        // $("#ViewInvoice").modal("show");

                      })
                      .catch((data) => {
                      Swal.fire({
                          icon: 'error',
                          title: 'Something went wrong!',
                          text: 'Kindly check and complete required fields.'
                      })
              });
            this.delayHotkey = 0;
                }
              })
            }else{
              this.delayHotkey = 0;
            }
          },
          deleteFromOrder(index, productItem){
            var idx = this.form.products.indexOf(productItem);
            if (idx > -1) {
                this.form.products.splice(idx, 1);
            }
            Fire.$emit("loadProducts");
          },
          clearItem(){
            this.orderForm.reset();
            this.totalPayment();
            localStorage.removeItem("product");
          },
          addToOrder(id){
            let product = this.orderForm;

            let quantity = this.orderForm.quantity - this.orderForm.number ;

            this.saleForm.qty = product.number;

             if(this.saleForm.saleprice == 'wholesale'){ // Wholesale
              this.saleForm
                .post("api/saleprice")
                  .then((data) => {

                    this.salePrice = 'wholesale';
                    // this.productTotal = data.data.wholesale;
                    this.productTotal = this.orderForm.price;

                     if(quantity >= 0){
                        if(product.id){
                          let order_id = this.form.products.find(x => x.id === id && x.saleprice === 'wholesale');
                          // let order_id = this.form.products.find(x => x.id === id);
                          let datasalesprice = this.salePrice;
                          if(!order_id){
                            this.form.products.push({
                              id: product.id,
                              location_id: product.location_id,
                              product_name: product.product_name,
                              remaining: product.quantity,
                              quantity: product.number,
                              price: data.data.wholesale,
                              total: this.productTotal * parseInt(product.number),
                              saleprice: this.salePrice,
                              sku:product.sku
                            });
                            Fire.$emit("loadProducts");
                          }else{
                            let objIndex = this.form.products.findIndex((obj => obj.id == id && obj.saleprice === 'wholesale'));

                            let last_quantity = this.form.products[objIndex].quantity;
                            this.form.products[objIndex].quantity = parseInt(last_quantity) + parseInt(product.number);


                            let total = this.form.products[objIndex].total + (this.productTotal * parseInt(product.number));


                            this.form.products[objIndex].total = total;
                            // this.form.products[objIndex].price = this.productTotal;


                            // this.form.products[objIndex].total = this.form.products[objIndex].total + (this.productTotal * parseInt(product.number));

                            this.form.products[objIndex].price = data.data.wholesale;

                            if(this.form.products[objIndex].quantity >= data.data.quantity){
                              this.form.products[objIndex].price = data.data.wholesale;
                              this.form.products[objIndex].total = total;
                            }
                            Fire.$emit("loadProducts");
                          }
                          localStorage.setItem('product', JSON.stringify(this.form.products));     
                        }else{
                          Swal.fire("Error", "You must select an item", "error");
                        }
                        this.disabledSearch = true;
                        this.listProduct = false;
                        this.products = {},
                        this.searchProductsForm.reset();
                        this.orderForm.reset();
                        this.saleForm.saleprice = 'retail';
                        localStorage.setItem('product', JSON.stringify(this.form.products));     
                    }else{
                      Swal.fire("Info!", "Quantity must less than or equal to on hand.", "info");
                    }
                  });

            }else if(this.saleForm.saleprice == 'retail'){ // Retail data
              this.saleForm
                .post("api/saleprice")
                  .then((data) => {

                    if(parseInt(this.saleForm.qty) >= data.data.quantity){
                        this.salePrice = 'wholesale';
                        // this.productTotal = data.data.wholesale;
                        this.productTotal = this.orderForm.price;
                    }else{
                        this.salePrice = 'retail';
                        // this.productTotal = data.data.sell_price;
                        this.productTotal = this.orderForm.price;
                    }
                    if(!data.data.quantity){
                        this.salePrice = 'retail';
                    }

                     if(quantity >= 0){
                        if(product.id){
                          let order_id = this.form.products.find(x => x.id === id && x.saleprice === 'retail');

                          let datasalesprice = this.salePrice;
                          if(!order_id){
                            this.form.products.push({
                              id: product.id,
                              location_id: product.location_id,
                              product_name: product.product_name,
                              remaining: product.quantity,
                              quantity: product.number,
                              price: this.productTotal,
                              total: this.productTotal * parseInt(product.number),
                              saleprice: this.salePrice,
                              sku: product.sku
                            });
                            Fire.$emit("loadProducts");
                          }else{
                            let objIndex = this.form.products.findIndex((obj => obj.id == id && obj.saleprice === 'retail'));
                            let last_quantity = this.form.products[objIndex].quantity;
                            this.form.products[objIndex].quantity = parseInt(last_quantity) + parseInt(product.number);

                            let total = this.form.products[objIndex].total + this.productTotal * parseInt(product.number);


                            this.form.products[objIndex].total = total;
                            this.form.products[objIndex].price = this.productTotal;


                            if(this.form.products[objIndex].quantity >= data.data.quantity){

                              this.form.products[objIndex].price = this.productTotal;
                              this.form.products[objIndex].total = total;

                            }
                            Fire.$emit("loadProducts");
                          }
                          localStorage.setItem('product', JSON.stringify(this.form.products));     
                        }else{
                          Swal.fire("Error", "You must select an item", "error");
                        }
                        this.disabledSearch = true;
                        this.listProduct = false;
                        this.products = {},
                        this.searchProductsForm.reset();
                        this.orderForm.reset();
                        this.saleForm.saleprice = 'retail';
                        localStorage.setItem('product', JSON.stringify(this.form.products));     

                    }else{
                      Swal.fire("Info!", "Quantity must less than or equal to on hand.", "info");
                    }
                  });
            }

          },
          selectProduct(product){
            this.saleForm.id = product.id;
            this.autofocus = true;
            this.orderForm.fill(product);
            this.listProduct = false;
            if(product.quantity <= 0){
              this.disabledSearch = true;
            }else{
              this.disabledSearch = false;
            }
          },
          searchProducts(){
            this.searchProductsForm
              .post("api/searchproducts")
                  .then((data) => {
                      this.products = data.data;

                      if(this.products.length > 0){
                        this.listProduct = true;
                      }else{
                        this.listProduct = false;
                      }

                  })
                  .catch(() => {

                  });
          },
           loadRenters: function() {
            axios.get("api/searchproducts").then(({ data }) => (
                this.renters = data,
                this.renters.map(item =>{
                    return item.item_data = item.fullname;
                })
            ));
          },
          
        },
        created(){
          this.loadTax();
           Fire.$on("loadProducts", () => {
            this.totalPayment();
        });
         this.$barcodeScanner.init(this.onBarcodeScanned);

        this.form.products = eval(localStorage.getItem('product')) || this.form.products;
        },
        destroyed () {
          this.$barcodeScanner.destroy()
        },
        mounted() {

        },
        watch: {
           form: {
                handler: function(newValue) {
                  let product = this.form.totalProduct;
                      window.addEventListener("beforeunload", function(e){

                      let confirmationMessage = "\o/";

                      console.log(confirmationMessage);

                      if( product > 0){
                          (e || window.event).returnValue = confirmationMessage;
                          return confirmationMessage;
                      }
                    })
                },
                deep: true
            },
        },
    }
</script>
