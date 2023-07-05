<template>
    <div class="container">
       <section  v-if="$gate.isCashier() | $gate.isStaff() | $gate.isManager() | $gate.isAdmin()">
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
      <section v-if="$gate.isRenter()">

        <div class="row justify-content-center">
            <div class="col-md-6">
                       <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist" style="border-bottom:0px">
                              <li class="nav-item">
                              <button class="nav-link active btn btn-sm btn-danger mr-4" id="custom-content-above-home-tab" data-toggle="pill" href="#dues" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Dues
                              </button>
                              </li>
                              <li class="nav-item">
                              <button class="nav-link  btn btn-sm btn-primary" id="custom-content-above-home-tab" data-toggle="pill" href="#collected" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Collected
                              </button>
                              </li>
                     </ul>
            <div class="tab-content" id="custom-content-above-tabContent">
                    <div class="tab-pane fade show active pt-3" id="dues" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                               <div class="row text-center p-2 pb-4">
                                        <div class="col-md-12 ">
                                                  <h4>DUES</h4>
                                        </div>
                              </div>
                                <div class="row justify-content-center" >
                                        <form @submit.prevent="searchDues" class="form-inline float-sm-right" style="width:100%">

                                        <div class="col-md-12">
                                                  <button type="submit" class="btn btn-primary float-sm-right">Search</button>
                                                  <input type="month" class="form-control float-sm-right mr-2" v-model="searchForm.date" name="searchForm.date" placeholder="Search..">
                                        </div>

                                        </form>
                               </div>
                                <div class="card mt-2" v-for="item in dues.data" :key="item.id ">
                                        <div class="card-body" style="padding:15px;border-left:4px solid #2c3e50">
                                                       <div class="row">
                                                            <div class="col-md-12">
                                                            <label>Month:</label> {{item.due_date | myDate}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Cube number:</label> {{item.box_number}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Branch:</label> {{item.name}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Amount:</label> {{item.rental_cost | toCurrency }}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Status:</label> {{item.status}}
                                                            </div>
                                                  </div>
                                        </div>
                              </div>
                              <div class="card-footer">
                                        <pagination :data="dues" @pagination-change-page="searchDues" :limit="1"></pagination>
                              </div>
                    </div> <!-- end tab for dues -->

                       <div class="tab-pane fade pt-3" id="collected" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                  <div class="row text-center p-2 pb-4">
                                        <div class="col-md-12 " >
                                                  <h4>COLLECTED</h4>
                                        </div>
                              </div>
                               <div class="row justify-content-center" >
                                        <form @submit.prevent="searchCollected" class="form-inline float-sm-right" style="width:100%">

                                        <div class="col-md-12">
                                                  <button type="submit" class="btn btn-primary float-sm-right">Search</button>
                                                  <input type="month" class="form-control float-sm-right mr-2" v-model="searchForm.date" name="searchForm.date" placeholder="Search..">
                                        </div>

                                        </form>
                               </div>
                                <div class="card mt-2" v-for="item in collected.data" :key="item.id ">
                                        <div class="card-body" style="padding:15px;border-left:4px solid #2c3e50">
                                                  <div class="row">
                                                            <div class="col-md-12">
                                                            <label>Month covered:</label> {{item.month_covered | myDate}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Cube number:</label> {{item.box_number}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Branch:</label> {{item.name}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Amount:</label> {{item.amount | toCurrency}}
                                                            </div>
                                                             <div class="col-md-12">
                                                            <label>Status:</label> {{item.status}}
                                                            </div>
                                                  </div>
                                        </div>
                              </div>
                              <div class="card-footer">
                                        <pagination :data="collected" @pagination-change-page="searchCollected" :limit="1"></pagination>
                              </div>
                    </div> <!-- end tab for collected -->


             </div> <!-- end tab content -->

            </div>
        </div> <!-- end row -->
        </section>
    </div><!-- end container -->
</template>

<script>
    export default {
       data() {
          return {
            userid: "",
            collected: {},
             dues: {},
            searchForm: new Form({
                    searchForm: "",
                    date: "",
                }),
          };
       },
      methods: {
        searchCollected: function(page = 1){
          this.userid = this.$gate.Userprofile();
            this.branchid = this.$gate.Userprofile();
            this.searchForm.post("api/renterrentmanager?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id + "&page=" + page ).then(({ data }) => {
              this.collected = data;
            });
        },
        searchDues: function(page = 1){
          this.userid = this.$gate.Userprofile();
            this.branchid = this.$gate.Userprofile();
            this.searchForm.post("api/renterrentmanagerduedate?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id + "&page=" + page ).then(({ data }) => {
              this.dues = data;
            });
        }
      },
      created() {
        this.searchCollected();
        this.searchDues();
      },
        mounted() {
           this.searchCollected();
            this.searchDues();
            console.log('Component mounted.')
        }
    }
</script>
