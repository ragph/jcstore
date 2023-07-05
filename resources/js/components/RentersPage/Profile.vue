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
        <div class="col-md-5 justify-content-center">
           <center><img v-bind:src="getProfilePhoto(picture)" width="150" style="text-align:center;margin-bottom:10px;"></center>
        </div>
      </div> <!-- end row -->
        <div class="row justify-content-center">

             <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                      <div class="row">
                         <div class="col-md-12 ">
                           <label>Username:</label> {{username}}
                         </div>
                       </div>

                        <div class="row">
                         <div class="col-md-12">
                           <label>Fullname:</label> {{fullname}}
                         </div>
                       </div>
                        <div class="row">
                         <div class="col-md-12">
                           <label>Branch:</label> {{branch}}
                         </div>
                       </div>
                          <div class="row">
                         <div class="col-md-12">
                           <label>Cube number:</label> {{cube}}
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                           <label>Contact number:</label> {{contact_number}}
                         </div>
                       </div>

                       <div class="row">
                         <div class="col-md-12">
                           <label>Email:</label>  {{email}}
                         </div>
                       </div>

                       <div class="row">
                         <div class="col-md-12">
                           <label>Date registered:</label>  {{date_registered}}
                         </div>
                       </div>

                        <div class="row">
                         <div class="col-md-12">
                           <label>Address:</label>  {{address}}
                         </div>
                       </div>

                        <div class="row">
                         <div class="col-md-12">
                           <label>Role:</label> {{role}}
                         </div>
                       </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
</section>

    </div> <!-- end container -->
</template>

<script>
    export default {
       data() {
          return {
            userid: "",
            picture: "",
            username: "",
            fullname: "",
            address: "",
            contact_number: "",
            email: "",
            date_registered: "",
            username: "",
            role: "",
            branch:"",
            cube:"",
          };
       },
      methods: {
        getProfilePhoto(photo){
              return "./user.png";
          },
        loadProfile: function(){
          this.userid = this.$gate.Userprofile();
           axios.post("api/renterprofile?userid=" + this.userid.renter_id  ).then(({ data }) => {
             this.username = data[0]['username'];
             this.fullname = data[0]['fullname'];
             this.address = data[0]['address'];
             this.contact_number = data[0]['contact_number'];
             this.email = data[0]['email'];
             this.date_registered = data[0]['date_registered'];
             this.role = data[0]['role'];
             this.branch = data[0]['name'];
             this.cube = data[0]['box_number'];
             });
        }
      },
      created() {
        this.loadProfile();
      },
        mounted() {
            this.loadProfile();
            console.log('Component mounted.')
        }
    }
</script>
