 <template>
    <div class="container-fluid">
     <section  v-if="$gate.product_null()">
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
        <section v-if="$gate.product_is_NOTnull()">
             <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> PRODUCTS</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Products</li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">

                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2" v-if="$gate.product_Add_() | $gate.product_Add_Edit() | $gate.product_Add_Delete() | $gate.product_Add_Edit_Delete()">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addProduct" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add product
                            </button>
                        </div>
                     <form @submit.prevent="deleteSelectProduct" style="width:100%">
                          <div class="col-md-12 pb-2" v-if="$gate.product_Delete_() | $gate.product_Add_Delete() | $gate.product_Edit_Delete() | $gate.product_Add_Edit_Delete()">
                            <button class="btn btn-danger btn-block" type="submit">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete products
                            </button>
                        </div>
                     </form>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>

                    <form @submit.prevent="searchProduct" style="width:100%">
                     <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search key:</label>
                                <input type="text" class="form-control" placeholder="Search" v-model="searchForm.searchForm" :class="{ 'is-invalid': searchForm.errors.has('searchForm') }" name="searchForm">
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Category:</label>
                                 <v-select :options="searchCategory" placeholder="Select category"  :reduce="item => item.id" label="item_category" v-model="searchForm.searchcategory" :class="{ 'is-invalid': searchForm.errors.has('searchcategory') }" name="searchcategory"  :on-search="loadsearchCategory" :value="form.searchcategory" ></v-select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select  id="role" class="form-control" v-model="searchForm.sort" :class="{ 'is-invalid': searchForm.errors.has('sort') }" name="sort">
                                <option value>Select</option>
                                <option value="p.product_name">Product name</option>
                                <option value="p.sku">SKU</option>
                                <option value="p.cost_price">Cost price</option>
                                <option value="p.sell_price">Retail price</option>
                                <option value="p.wholesale_price">Wholesale price</option>
                                <option value="p.wholesale_quantity">Wholesale min qty</option>
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
                              <router-link to="/category">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-shopping-bag" aria-hidden="true"></i> Category
                                  </button>
                                </router-link>
                                <router-link to="/inventory">
                                <button class="btn btn-info float-sm-right btn-block mt-2" style="color:white">
                                   <i class="fa fa-plus" aria-hidden="true"></i> Inventory
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
                     <p>Total products: {{total}}</p>
                  <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                     <div class="card-body">
                         <div id="accordion">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" :id="'selectProduct'" @click="selectAllProduct" v-model="checkAll">
                                            <label :for="'selectProduct'"></label>
                                        </div>
                                        Select all
                                        </th>
                                        <th>Product name</th>
                                        <th>Category</th>
                                        <th>SKU</th>
                                        <th>Cost price</th>
                                        <th>Retail price</th>
                                        <th>Wholesale price</th>
                                        <th>Wholesale min qty</th>
                                        <th>On hand</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i) in products.data" :key="item.id ">
                                        <th>
                                          <div class="icheck-primary d-inline">
                                            <input type="checkbox" :id="'select' + item.id" v-model="selectForm.productID" :value="item.id">
                                             <label :for="'select' + item.id"></label>
                                          </div>
                                        </th>
                                        <td>{{item.product_name}}</td>
                                        <td data-toggle="collapse" :data-target="'#collapseOne'+i" aria-expanded="true" aria-controls="collapseOne">
                                             <ul class="list-group"  style="list-style:none">
                                                <li v-for="(data, index) in item.category" :key="item.category.id">
                                                    <template v-if="index <= 0">
                                                    <p>
                                                    {{data.name}}
                                                    </p>
                                                    </template>
                                                </li>
                                                <li v-for="(data, index) in item.category" :key="item.category.id" :id="'collapseOne'+i" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <template  v-if="index > 0">
                                                    <p>
                                                    {{data.name}}
                                                    </p>
                                                </template>
                                                </li>
                                            </ul>
                                        </td>
                                        <td>{{item.sku}}</td>
                                        <td>{{item.cost_price | toCurrency}}</td>
                                        <td>{{item.sell_price | toCurrency}}</td>
                                        <td>{{item.wholesale_price | toCurrency}}</td>
                                        <td>{{item.wholesale_quantity}}</td>
                                        <td>{{item.qty}}</td>
                                        <td>
                                            <button v-if="$gate.product_Edit_() | $gate.product_Add_Edit() | $gate.product_Edit_Delete() | $gate.product_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                            <button v-if="$gate.product_Delete_() | $gate.product_Add_Delete() | $gate.product_Edit_Delete() | $gate.product_Add_Edit_Delete()" class="btn btn-danger"  @click="deleteProduct(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>

                                    </tr>
                                </tbody>

                            </table>
                            </div><!---- end accordion ------->
                        </div><!---- end card body ------->
                        <div class="card-footer">
                             <pagination :data="products" @pagination-change-page="searchProduct" :limit="1"></pagination>
                         </div>
                    </div><!---- end card ------->
                </div>

            </div> <!---- row ------->
        </section>

        <!-- =================================================================================================================================== -->
        <!-- ADD PRODUCT MODAL -->
        <section>
           <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="!editmode">Add product</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="editmode ? editProduct() : createProduct()">
                    <div class="modal-body">
                        <div class="row">
                           <div class="col-md-4">
                                <div class="form-group">
                                    <vue-upload-multiple-image
                                    @upload-success="uploadImageSuccess"
                                    @before-remove="beforeRemove"
                                    @edit-image="editImage"
                                    :data-images="form.gallery"
                                    dragText="Drag or upload image here"
                                    idUpload="myIdUpload"
                                    editUpload="myIdEdit"
                                    primaryText=" "
                                    browseText=" "
                                    markIsPrimaryText=" "
                                    dropText=" "
                                ></vue-upload-multiple-image>
                                </div>
                           </div>
                        </div><!---- end row ----->
                        <div class="row">
                           <div class="col-md-6">
                                <div class="form-group">
                                  <label>SKU</label>
                                  <input type="text" class="form-control" placeholder="SKU" v-model="form.sku" :class="{ 'is-invalid': form.errors.has('sku') }" name="sku">
                                  <has-error :form="form" field="sku"></has-error>
                                </div>
                           </div>
                           <div class="col-md-6">
                                <!-- <barcode v-bind:id="barcodeValue" v-bind:value="form.sku"></barcode> -->
                                <barcode v-bind:id="barcodeValue" v-bind:value="form.sku" style="display: none"></barcode>
                                <canvas id="canvas" v-show="showBarcode"></canvas>
                            </div>
                        </div><!---- end row ----->
                        <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                  <label>Product name</label>
                                  <input type="text" class="form-control" placeholder="Product name" v-model="form.product_name" :class="{ 'is-invalid': form.errors.has('product_name') }" name="product_name" >
                                  <has-error :form="form" field="product_name"></has-error>
                                </div>
                           </div>
                           <div class="col-md-6">
                             <div class="form-group clearfix">
                                <label> Category</label>
                                <multiselect v-model="form.value" :options="options" :multiple="true"  placeholder="Type to search" track-by="id"  :reduce="item => item.id" label="name" ><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
                             </div>
                           </div>
                       </div> <!---- end row ----->
                       
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                  <label>Wholesale price</label>
                                  <input type="number" class="form-control" placeholder="Wholesale price" v-model="form.wholesale_price" :class="{ 'is-invalid': form.errors.has('wholesale_price') }" name="wholesale_price" >
                                  <has-error :form="form"  field="wholesale_price"></has-error>
                                </div>
                           </div>
                           <div class="col-md-6">
                             <div class="form-group clearfix">
                                <label> Wholesale minimum quantity</label>
                                <input type="number" class="form-control" placeholder="Wholesale minimum quantity" v-model="form.wholesale_quantity" :class="{ 'is-invalid': form.errors.has('wholesale_quantity') }" name="wholesale_quantity" >
                                 <has-error :form="form"  field="wholesale_quantity"></has-error>
                             </div>
                           </div>

                       </div> <!---- end row ----->
                       
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                  <label>Cost price</label>
                                  <input type="number" class="form-control" placeholder="Cost price" v-model="form.cost_price" :class="{ 'is-invalid': form.errors.has('cost_price') }" name="cost_price" >
                                  <has-error :form="form"  field="cost_price"></has-error>
                                </div>
                           </div>
                           <div class="col-md-6">
                             <div class="form-group clearfix">
                                <label> Retail price</label>
                                <input type="number" class="form-control" placeholder="Retail price" v-model="form.sell_price" :class="{ 'is-invalid': form.errors.has('sell_price') }" name="sell_price" >
                                 <has-error :form="form"  field="sell_price"></has-error>
                             </div>
                           </div>

                       </div> <!---- end row ----->

                        <div class="row">
                         <div class="col-md-6">
                             <div class="form-group clearfix">
                                <label >Supplier</label>
                                 <v-select :options="renters" placeholder="Select renter"  :reduce="item => item.id" label="item_data" v-model="form.renter_id" :class="{ 'is-invalid': form.errors.has('renter_id') }" name="renter_id"  :on-search="loadRenters" :value="form.renter_id" ></v-select>
                                   <has-error :form="form"  field="renter_id"></has-error>
                             </div>
                           </div>
                           <div class="col-md-2">
                             <div class="form-group clearfix">
                                <label > On hand</label>
                                <input type="number" class="form-control" placeholder="Qty" v-model="form.qty" :class="{ 'is-invalid': form.errors.has('qty') }" name="qty" disabled>
                             </div>
                           </div>
                            <div class="col-md-4">
                             <div class="form-group clearfix">
                                <label> Stock level</label>
                               <select id="role" class="form-control" v-model="form.stock_level" :class="{ 'is-invalid': form.errors.has('stock_level') }" name="stock_level" disabled>
                                     <option value>Select level</option>
                                     <option value="instock">In stock</option>
                                     <option value="outstock">Out of stock</option>
                                </select>
                             </div>
                           </div>
                       </div> <!---- end row ----->

                        <div class="row">

                           <div class="col-md-6">
                             <div class="form-group clearfix">
                                <label > Brand </label>
                                <input type="text" class="form-control" placeholder="Brand" v-model="form.brand" :class="{ 'is-invalid': form.errors.has('brand') }" name="brand" >
                                <has-error :form="form"  field="brand"></has-error>
                             </div>
                           </div>
                            <div class="col-md-6">
                             <div class="form-group clearfix">
                                <label> Tags </label>
                              <input type="text" class="form-control" placeholder="Tags" v-model="form.tags" :class="{ 'is-invalid': form.errors.has('tags') }" name="tags" >
                               <has-error :form="form"  field="tags"></has-error>
                             </div>
                           </div>
                       </div> <!---- end row ----->

                       <div class="row">
                           <div class="col-md-12">
                               <label class="pr-2"> Description</label>
                               <textarea class="form-control" rows="3" placeholder="Description"  v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" name="description"></textarea>
                                <has-error :form="form"  field="description"></has-error>
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
 import VueBarcode from 'vue-barcode';

    export default {
     components: {
        Multiselect,
        VueUploadMultipleImage,
        'barcode': VueBarcode
      },
      data() {
            return {
                add_count: 0,
                total: "",
                barcodeValue: 'barcode',
                checkAll: false,
                showBarcode: false,
                searchCategory: [],
                renters: [],
                options: [],
                selectproduct:[],
                editmode:false,
                products: {},
                branches: {},
                searchForm: new Form({
                    searchForm: "",
                    sort: "",
                    searchcategory:"",
                    sortby: 'desc',
                }),
                selectForm: new Form({
                    productID: [],
                }),
                form: new Form({
                    id: '',
                    sku: '',
                    product_name: '',
                    cost_price: '',
                    sell_price: '',
                    wholesale_price: '',
                    wholesale_quantity: '',
                    branch_id: '',
                    qty: '',
                    stock_level: '',
                    renter_id: '',
                    brand: '',
                    tags: '',
                    description: '',
                    barcodeImg: '',
                    value: [],
                    gallery: [],

                }),
            };
        },
      methods:{
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
            return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
                this.form.photo = reader.result;
            };
            reader.readAsDataURL(file);
        },
        barcodeWhenEdit(){

        },
        barcodeCovertionToImage(){
            this.showBarcode = true;
            // JAVASCRIPT
            var canvas = document.getElementById('canvas');
            canvas.toDataURL('').replace('', '');

             let i=0;
            setInterval(function(){
            if(i <= 1){
                 var ctx = canvas.getContext('2d');
                var SVGDomElement = document.getElementById("serializebarcode");
                var string = jQuery('.vue-barcode-element').html();
                var data = '<svg xmlns="http://www.w3.org/2000/svg" class="vue-barcode-element" style="transform: translate(0,0)" id="serializebarcode" width="266px" height="142px" x="0px" y="0px" viewBox="0 0 266 142" version="1.1">'+string+'</svg>';

                var DOMURL = window.URL || window.webkitURL || window;

                var img = new Image();
                img.crossOrigin = 'anonymous'

                var svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
                var url = DOMURL.createObjectURL(svgBlob);
                var imgURI = canvas
                        .toDataURL('image/png')
                        .replace('image/png', 'image/png');

                img.onload = function () {
                    ctx.drawImage(img, 0, 0);
                    DOMURL.revokeObjectURL(url);
                };

                img.src = url;
                    i++;
            }

                },1000);
            // END JAVASCRIPT

        },
        selectAllProduct: function() {
            this.checkAll = !this.checkAll;
                this.selectForm.productID = [];
                if(this.checkAll){ // Check all
                  for (var i in this.products['data']) {
                        this.selectForm.productID.push(this.products['data'][i]['id']);
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
                            this.selectForm.post("api/selectDelete")
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
            this.showBarcode = false;
            jQuery('.vue-barcode-element').attr('id','serializebarcode');

            this.form.reset();
            this.form.clear();

             if(this.form.sku){
                this.barcodeCovertionToImage();
            }

          },
          editItem(item){
            jQuery('.vue-barcode-element').attr('id','serializebarcode');
            this.form.fill(item);
            this.editmode = true;
            this.showBarcode = false;
            this.form.branch_id = item.branch_id;
            this.form.renter_id = item.renter_id;
            this.form.value = item.category;
            $("#addProduct").modal("show");

            if(this.form.sku){
                this.barcodeCovertionToImage();
            }else{
                this.showBarcode = false;
            }
          },
          editProduct(){
              this.form
                .put("api/product/" + this.form.id)
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
                           axios.delete("api/product/" + id)
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
          searchProduct(page = 1){
              this.searchForm
                    .post("api/searchproduct?page=" + page)
                        .then((data) => {
                            this.products = data.data;
                            this.total = data.data.total;
                        })
                        .catch(() => {

                        });
          },
          createProduct(){
              if(this.add_count == 0){
                  this.add_count = 1;
                  this.form
                    .post("api/product")
                        .then(() => {
                            Fire.$emit("AfterCreate");
                            Swal.fire("Success!", "Boxes has been successfully saved", "success");
                            $("#addProduct").modal("hide");
                            var canvas = document.getElementById('canvas');
                            canvas.toDataURL('').replace('', '');
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
         loadBranches: function() {
            axios.get("api/branchlist").then(({ data }) => (this.branches = data));
          },
        loadCategory: function() {
            axios.get("api/categorylist").then(({ data }) => (this.options = data));
          },
        loadRenters: function() {
            axios.get("api/loadboxlist").then(({ data }) => (
                this.renters = data,
                this.renters.map(item =>{
                    return item.item_data = item.fullname + ' - ' + item.name + ' - ' + item.box_number;
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
      },
      created(){
        Fire.$on("AfterCreate", () => {
            this.searchProduct();
        });
        this.loadBranches();
        this.loadRenters();
        this.loadCategory();
        this.searchProduct();
        this.loadsearchCategory();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>