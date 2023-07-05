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
                <div class="card mt-2" v-for="item in boxes.data" :key="item.id ">
                    <div class="card-body" style="padding:15px;border-left:4px solid #2c3e50">
                        <div class="row">
                          <div class="col-md-12">
                            <label>Branch:</label> {{item.name}}
                          </div>
                           <div class="col-md-12">
                            <label>Cube number:</label> {{item.box_number}}
                          </div>
                            <div class="col-md-6">
                            <label>Date of contract:</label> {{item.date_of_contract | myDate}}
                          </div>
                          <div class="col-md-6">
                            <label>Rental cost:</label> {{item.rental_cost | toCurrency}}
                          </div>
                        </div>
                    </div>
                </div>
                  <div class="card-footer">
                    <pagination :data="boxes" @pagination-change-page="searchBoxes" :limit="1"></pagination>
                  </div>
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
            boxes: {},
            searchForm: new Form({
                    searchForm: "",

                }),
          };
       },
      methods: {
        searchBoxes: function(page = 1){
          this.userid = this.$gate.Userprofile();
            this.branchid = this.$gate.Userprofile();
            this.searchForm.post("api/renterboxes?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id + "&page=" + page ).then(({ data }) => {
              this.boxes = data;
            });
        }
      },
      created() {
        this.searchBoxes();
      },
        mounted() {
           this.searchBoxes();
            console.log('Component mounted.')
        }
    }
</script>
