<template >
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link to="/dashboard"> <a class="navbar-brand" href="#"><img width="55" v-bind:src="getlogo(logo)"></a></router-link>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                 <li class="nav-item" v-if="$gate.branch_is_NOTnull()">
                    <router-link to="/branch"><a class="nav-link" href="#"> <i class="fa fa-home" aria-hidden="true"></i> Branch </a></router-link>
                  </li>

                  <li class="nav-item"  v-if="$gate.renter_is_NOTnull()">
                  <router-link to="/renters"> <a class="nav-link" href="#"> <i class="fa fa-users" aria-hidden="true"></i> Renters / sellers profiles </a></router-link>
                  </li>

                    <li class="nav-item dropdown"  v-if="$gate.cube_is_NOTnull()">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-th-large" aria-hidden="true"></i> Cube management
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link to="/assign"> <a class="dropdown-item" href="#">Assign</a></router-link>
                        <router-link to="/cubes"> <a class="dropdown-item" href="#">Cubes</a></router-link>
                        </div>
                      </li>

                     <li class="nav-item dropdown"  v-if="$gate.product_is_NOTnull()">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarproducts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        Product management
                        <span class="badge badge-pill badge-primary">{{totalproducts}}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarproducts">
                        <router-link to="/products">
                        <a class="dropdown-item" href="#">Add product</a>
                        </router-link>
                        <router-link to="/category">
                        <a class="dropdown-item" href="#">Add category</a>
                        </router-link>
                        </div>
                      </li>

                       <li class="nav-item dropdown" v-if="$gate.inventory_is_NOTnull()">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-shortkey="['f1']" @shortkey="productManagement()">
                          <i class="fa fa-plus" aria-hidden="true"></i> Inventory <span class="badge badge-dark">F1</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <router-link to="/inventory"> <a class="dropdown-item" href="#">All products</a></router-link>
                              <router-link to="/transactions"> <a class="dropdown-item" href="#">Stocks receiving</a></router-link>
                              <router-link to="/producttransmittal"> <a class="dropdown-item" href="#">Product transmittal</a></router-link>
                              <div class="dropdown-divider"></div>
                              <router-link to="/return">  <a class="dropdown-item" href="#">Returns</a></router-link>
                            </div>
                          </li>

                          <li class="nav-item dropdown" v-if="$gate.pos_is_NOTnull()">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-shortkey="['f2']" @shortkey="salesAction()">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> POS <span class="badge badge-dark">F2</span>
                          </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <router-link to="/sales"> <a class="dropdown-item" href="#">Add POS</a></router-link>
                              <router-link to="/directsales"> <a class="dropdown-item" href="#">Add direct sales</a></router-link>
                              <router-link to="/salehistory"><a class="dropdown-item" href="#">POS history</a></router-link>
                              <router-link to="/salehistorydirect"><a class="dropdown-item" href="#">Direct sales history</a></router-link>
                              <router-link to="/voidhistory"><a class="dropdown-item" href="#">Void history</a></router-link>
                            <div class="dropdown-divider"></div>
                            <router-link to="/returnsales">   <a class="dropdown-item" href="#">Returns</a></router-link>
                            </div>
                          </li>
                          <li class="nav-item" v-if="$gate.sale_coll_is_NOTnull()">
                            <router-link to="/salescollection"><a class="nav-link" href="#"> <i class="fa fa-calendar" aria-hidden="true"></i> Sales released </a></router-link>
                          </li>

                          <li class="nav-item" v-if="$gate.user_is_NOTnull()">
                            <router-link to="/usermanagement"><a class="nav-link" href="#"> <i class="fa fa-user" aria-hidden="true"></i> Users </a></router-link>
                          </li>
                            <li class="nav-item dropdown" v-if="$gate.rent_is_NOTnull()">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarproducts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                Rent management
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarproducts">
                                <router-link to="/all">
                                <a class="dropdown-item" href="#">All</a>
                                </router-link>
                                <router-link to="/duedate">
                                <a class="dropdown-item" href="#">Dues</a>
                                </router-link>
                                <router-link to="/collected">
                                <a class="dropdown-item" href="#">Collected</a>
                                </router-link>
                                </div>
                            <!-- <router-link to="/rentmanagement"><a class="nav-link" href="#"> <i class="fa fa-list-alt" aria-hidden="true"></i> Rent management </a></router-link> -->
                            </li>

                            <!-- <li class="nav-item" v-if="$gate.isAdmin()">
                               <router-link to="/voucher">  <a class="nav-link" href="#"> <i class="fa fa-money" aria-hidden="true"  v-shortkey="['f3']" @shortkey="reportAction()"></i> Voucher & coupons </a></router-link>
                            </li> -->
                            <li class="nav-item" v-if="$gate.report_is_NOTnull()">
                            <router-link to="/report"><a class="nav-link" href="#"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Report </a></router-link>
                            </li>
                          <!-- retner menu here  -->

                          <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/profile"><a class="nav-link" href="#" data-toggle="collapse"> <i class="fa fa-user" aria-hidden="true"></i> Profile </a></router-link>
                          </li>

                          <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/myproducts"><a class="nav-link" href="#"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> My products </a></router-link>
                          </li>

                          <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/myinventory"><a class="nav-link" href="#"> <i class="fa fa-list-alt" aria-hidden="true"></i> Inventory </a></router-link>
                          </li>

                          <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/myproductreturn"><a class="nav-link" href="#"> <i class="fa fa-undo" aria-hidden="true"></i> Product returns </a></router-link>
                          </li>

                          <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/mysaleshistory"><a class="nav-link" href="#"> <i class="fa fa-history" aria-hidden="true"></i> Sales history </a></router-link>
                          </li>

                          <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/myboxes"><a class="nav-link" href="#"> <i class="fa fa-archive" aria-hidden="true"></i> My cubes </a></router-link>
                          </li>

                           <li class="nav-item" v-if="$gate.isRenter()">
                            <router-link to="/myrentmanager"><a class="nav-link" href="#"> <i class="fa fa-home" aria-hidden="true"></i> Rent manager </a></router-link>
                          </li>

                           <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Hi {{Username}}!
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <router-link to="/settings">  <a class="dropdown-item" href="#" v-if="$gate.setting_is_NOTnull()" ><i class="fa fa-cog" aria-hidden="true"></i> Settings </a> </router-link>
                                 <router-link to="/systemlogs">  <a class="dropdown-item" href="#" v-if="$gate.setting_is_NOTnull()" ><i class="fa fa-clock-o" aria-hidden="true"></i> System logs </a> </router-link>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="#" @click.prevent="logout"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                                </div>
                              </li>
                          </ul>
                        </div>

          </nav>

</template>

<script>
    export default {
       data(){
         return {
           logo: "",
           userid: "",
            // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            Username:"",
            totalproducts: "",
         };
       },
      methods:{
            getlogo(){
               return "./public/skinheaderlogo.png";
            },
            username: function(){
                this.userid =  this.$gate.Userprofile();
                console.log(this.userid);
                this.Username = this.userid.username;
            },
           logout:function(){
               axios.post('logout').then(response => {
                  if (response.status === 302 || 401) {
                    window.location.href = './';
                  }
                  else {
                   console.log("tets");
                  }
                }).catch(error => {

              });
            },
        reportAction(){
          this.$router.push('/report').catch(err => {})
        },
        salesAction(){
         this.$router.push('/sales').catch(err => {})
        },
        productManagement(){
          this.$router.push('/inventory').catch(err => {})
        },
        loadproductcount: function(){
             axios.get("api/totalproducts").then(({ data }) => (this.totalproducts = data[0]['total']));
        }
      },
      created(){
        this.username();
        this.loadproductcount();
        this.getlogo();
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
