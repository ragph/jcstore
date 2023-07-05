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
                      <h3 style="color:#34495e"> CATEGORY</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active"> Category</li>
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
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addCategory" @click="openModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add category
                            </button>

                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>
                  <form @submit.prevent="searchCategory" style="width:100%">
                       <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search key: </label>
                                <input type="text" class="form-control" placeholder="Search"  v-model="searchForm.searchForm" name="searchForm.searchForm" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort by:</label>
                                <select name="type_of_business"  id="role" class="form-control" v-model="searchForm.sort">
                                  <option value>Select</option>
                                  <option value="c.category_name">Category name</option>
                                  <option value="cs.category_name">Sub category</option>
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
                     <p>Total category: {{total}}</p>
                   <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Category name</th>
                                        <th>Sub category</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in category.data" :key="index ">
                                        <td>{{item.category_name}}</td>
                                        <td>{{item.subcategory}}</td>
                                        <td >
                                            <button v-if="$gate.product_Edit_() | $gate.product_Add_Edit() | $gate.product_Edit_Delete() | $gate.product_Add_Edit_Delete()" class="btn btn-primary" @click="editItem(item)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                                            <button v-if="$gate.product_Delete_() | $gate.product_Add_Delete() | $gate.product_Edit_Delete() | $gate.product_Add_Edit_Delete()" class="btn btn-danger"  @click="deleteCategory(item.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div><!---- end car body ------->
                          <div class="card-footer">
                             <pagination :data="category" @pagination-change-page="searchCategory" :limit="1"></pagination>
                         </div>
                    </div><!---- end card ------->
                </div>
            </div> <!---- row ------->
        </section>
         <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->
        <section>
           <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                             <h5 class="modal-title" id="exampleModalLabel" v-if="!editmode">Add category</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editmode">Edit category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
              <form @submit.prevent="editmode ? editCategory() : createCategory()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Category </label>
                                  <input type="text" class="form-control" placeholder="Category name" v-model="form.category_name" :class="{ 'is-invalid': form.errors.has('category_name') }" name="category_name" >
                                  <has-error :form="form" field="category_name"></has-error>
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Sub category</label>
                                     <select name="subcategory_id" v-model="form.subcategory_id" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('subcategory_id') }">
                                        <option value>Select category</option>
                                        <option v-for="item in subcategory" :value="item.id" :key="item.id">{{ item.name}}</option>
                                    </select>
                                    <has-error :form="form" field="subcategory_id"></has-error>
                                </div>
                           </div>
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                         <button type="submit" v-show="editmode" class="btn btn-primary">Update category</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">Save category</button>
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
                total:"",
                editmode:false,
                category: {},
                subcategory: {},
                searchForm: new Form({
                    searchForm: '',
                    sort: '',
                }),
                form: new Form({
                    id: '',
                    category_name: '',
                    subcategory_id: '',
                }),
            };
        },
      methods:{
        searchCategory(page = 1){
            this.loading = true;
            this.searchForm
              .post("api/searchcategory?page=" + page).
              then(({ data }) => {this.category = data; this.total =data.total; this.loading = false});
          },
           openModal(){
            this.loadCategory();
            this.editmode = false;
            this.form.reset();
            this.form.clear();
          },
          editItem(item){
            $("#addCategory").modal("show");
            console.log(item);
            this.form.fill(item);
            this.editmode = true;
            this.form.subcategory_id = item.category_id;
          },
          editCategory(){
              this.form
                .put("api/category/" + this.form.id)
                    .then(() => {
                        $('#addCategory').modal('hide');
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
          deleteCategory(id){
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
                           axios.delete("api/category/" + id)
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
          createCategory(){
            if(this.add_count == 0){
                this.add_count = 1;
                this.form
                .post("api/category")
                    .then(() => {
                        Fire.$emit("AfterCreate");
                        Swal.fire("Success!", "Record has been successfully saved", "success");
                        $("#addCategory").modal("hide");
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
          loadCategory(){
             axios.get("api/categorylist").then(({ data }) => (this.subcategory = data));
          }

      },
      created(){
          Fire.$on("AfterCreate", () => {
            this.searchCategory();
        });
        this.searchCategory();
        this.loadCategory();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
