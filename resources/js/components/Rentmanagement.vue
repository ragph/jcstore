<template>
    <div class="container-fluid">
        <section  v-if="$gate.isCashier() | $gate.isStaff() | $gate.isRenter()">
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
        <section v-if="$gate.isAdmin() | $gate.isManager()">
            <div class="row">
                 <div class="col-sm-6">
                      <h3 style="color:#34495e"> RENT MANAGEMENT</h3>
                    </div>
                <div class="col-md-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Rent management </li>
                      </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                        <h5>Actions</h5>
                        </div>
                        <div class="col-md-12 pb-2">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addStore">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add renter
                            </button>
                        </div>
                        <div class="col-md-12 pb-2">
                            <hr>
                        </div>


                        <div class="col-md-12 ">
                            <div class="form-group clearfix">
                                <label class="pr-2 "> Search renter</label>
                                <input type="text" class="form-control" placeholder="Search renter" name="" >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <label class="pr-2"> Sort</label>
                                <select name="type_of_business"  id="role" class="form-control" >
                                <option value>Select</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                              <label class="pr-2 "> Utilities:</label>
                              <router-link to="/resellers">
                                <button class="btn btn-info float-sm-right btn-block" style="color:white">
                                   <i class="fa fa-users" aria-hidden="true"></i> Reseller
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" :id="'selectbusiness'" true-value="yes" false-value="no">
                                        <label :for="'selectbusiness'"></label>
                                    </div>
                                Select
                                </th>
                                <th>Renter name</th>
                                <th>Store</th>
                                <th>Date rent</th>
                                <th>Date due</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" :id="'selectbusiness'" true-value="yes" false-value="no">
                                        <label :for="'selectbusiness'"></label>
                                    </div>
                                </td>
                                <td>Jane kate</td>
                                <td>Store A</td>
                                <td>August 10, 2020</td>
                                <td>July 10, 2020</td>
                                <td>Payed</td>
                                <td>
                                    <button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                            <h5 class="modal-title" id="exampleModalLabel">Add renter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                  <label>Renter name</label>
                                  <input type="text" class="form-control" placeholder="Product number" name="" >
                                  <!-- <has-error field=""></has-error> -->
                                </div>
                           </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Store</label>
                                    <select name="type_of_business"  id="role" class="form-control" >
                                      <option value>Select</option>
                                    </select>
                                </div>
                           </div>
                             <div class="col-md-12">

                           </div>
                        </div><!---- end row ----->
                    </div> <!---- end modal contennt ----->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save product</button>
                    </div>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
