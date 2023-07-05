<template>
    <div class="container-fluid container-dashboard">
      <section class="content-dash"  v-if="$gate.isAdmin() | $gate.isCashier() | $gate.isStaff() | $gate.isManager()">
        <div class="row justify-content-center">
           <div class="col-md-3 col-sm-4 col-xm-12">
                <div class="card card-dashboard">
                    <div class="card-body ">
                      <div class="row">
                        <div class="col-md-2">
                          <i class="fa fa-shopping-bag" aria-hidden="true" style="font-size:40px;color:#6c757d"></i>
                        </div>
                        <div class="col-md-5">
                          <h5>Products</h5>
                          <font>Total</font>
                        </div>
                        <div class="col-md-5">
                          <h5>{{totalProducts}}</h5>
                        </div>
                      </div>
                    </div>
                </div>
            </div><!---- end col ----->
              <div class="col-md-3 col-sm-4 col-xm-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                      <div class="row">
                         <div class="col-md-2">
                          <i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:40px;color:#6c757d"></i>
                        </div>
                        <div class="col-md-4">
                          <h5>Monthly summary</h5>
                          <!-- <font>Total</font> -->
                        </div>
                        <div class="col-md-6">
                          <h5>{{totalSales | toCurrency}}</h5>
                        </div>
                      </div>
                    </div>
                </div>
            </div><!---- end col ----->
              <div class="col-md-3 col-sm-4 col-xm-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                      <div class="row">
                         <div class="col-md-2">
                          <i class="fa fa-users" aria-hidden="true" style="font-size:40px;color:#6c757d"></i>
                        </div>
                        <div class="col-md-5">
                          <h5>Renters</h5>
                          <font>Total</font>
                        </div>
                        <div class="col-md-5">
                          <h5>{{totalRenters}}</h5>
                        </div>
                      </div>
                    </div>
                </div>
            </div><!---- end col ----->
              <div class="col-md-3 col-sm-4 col-xm-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                      <div class="row">
                          <div class="col-md-2">
                          <i class="fa fa-home" aria-hidden="true" style="font-size:40px;color:#6c757d"></i>
                        </div>
                        <div class="col-md-5">
                          <h5>Rent collected</h5>
                          <font>Total</font>
                        </div>
                        <div class="col-md-5">
                          <h5>{{totalCollected | toCurrency}}</h5>
                        </div>
                      </div>
                    </div>
                </div>
            </div><!---- end col ----->
        </div><!---- end row ----->
        <div class="row pt-2">
          <div class="col-md-8">
              <div class="card card-dashboard">
                  <div class="card-body ">
                        <bar-example
                        :chart-data="data"
                        :height="180"
                        :options="options"
                      ></bar-example>
                  </div>
              </div>
          </div>

          <div class="col-md-4">
             <div class="card card-dashboard" style="height:500px">
                  <div class="card-body ">
                    <h5 class="card-title">Top selling items</h5>
                    <table class="table table-stripe">
                      <thead>
                        <tr>
                          <th>Products</th>
                          <th>Total product</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in topsellingitems.data" :key="index">
                          <td>{{item.product_name}}</td>
                          <td>{{item.total_product}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
          </div>
        </div>

        <!-- 3rd -->
         <div class="row pt-2">
          <div class="col-md-6">
              <div class="card card-dashboard">
                  <div class="card-body ">
                    <h5 class="card-title">Top seller / renters</h5>
                    <table class="table table-stripe">
                      <thead>
                        <tr>
                          <th>Renter / seller</th>
                          <th>Products</th>
                          <th>Branch </th>
                          <th>Cube #</th>
                          <th>Date registered</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(item, index) in toprenters.data" :key="index">
                          <td>{{item.fullname}}</td>
                          <td>{{item.product_name}}</td>
                           <td>{{item.name}}</td>
                          <td>{{item.box_number}}</td>
                           <td>{{item.date_of_contract | myDate}}</td>
                           <td>{{item.quantity}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
           <div class="col-md-6">
              <div class="card card-dashboard">
                  <div class="card-body ">
                    <h5 class="card-title">Dues / collectibles</h5>
                    <table class="table table-stripe">
                      <thead>
                        <tr>
                          <th>Renter / seller</th>
                          <th>Cube #</th>
                          <th>Branch</th>
                          <!-- <th>Date registered</th> -->
                          <th>Due date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in collectibles.data" :key="index">
                          <td>{{item.fullname}}</td>
                          <td>{{item.box_number}}</td>
                          <td>{{item.branch}}</td>
                          <td>{{item.due_date}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
        </div>
      </section>

    <section  v-if="$gate.isRenter()">
          <div class="row justify-content-center ">
            <div class="col-md-6">
                <div class="card card-dashboard mt-3">
                    <div class="card-body">
                       <div class="row" style="text-align:center">
                        <table class="table table-borderless">
                         <thead>
                           <tr>
                             <td>Your Sales</td>
                             <td class="float-sm-right mr-5"><label>Date: {{date | myDate}}</label> </td>
                           </tr>
                         </thead>
                       </table>
                      </div>
                      <div class="row">
                        <div class="col-md-12" style="text-align:center">
                          <h3 style="color:#2980b9">{{daily | toCurrency}}<label style="font-size:12px;"> &nbsp;For this day</label></h3>
                        </div>
                      </div>
                      <div class="row mt-2" style="text-align:center">
                       <table class="table table-borderless">
                         <thead>
                           <tr>
                             <td>With in this week</td>
                             <td>With in this month</td>
                           </tr>
                         </thead>
                         <tbody>
                            <tr>
                              <td> {{week | toCurrency}}</td>
                              <td> {{month | toCurrency}}</td>
                            </tr>
                         </tbody>
                       </table>
                      </div>
                    </div>
                </div>
            </div>
        </div><!-- end row -->


        <div class="row justify-content-center mt-5">
          <div class="col-md-6">
              <div class="card mt-2" v-for="item in lastransac" :key="item.id ">
                    <div class="card-body" style="padding:15px;border-left:4px solid #2c3e50">
                      <div class="row">
                        <div class="col-md-12 ">
                          <label>Product:</label> {{item.product_name}}
                        </div>
                        <div class="col-md-4 ">
                          <label>SKU:</label> {{item.sku}}
                        </div>
                        <div class="col-md-4 ">
                          <label style="color:#2980b9">Amount:</label> {{item.totalcollect}}
                        </div>
                        <div class="col-md-12">
                           <label style="color:#2980b9">Date:</label> {{item.created_at | myDateTime}}
                        </div>
                      </div>
                    </div>
              </div>
          </div>
        </div>
    </section>
    </div> <!---- end container ----->
</template>

<script>
import BarExample from "./Barchart.js";
import numeral from 'numeral';
const CancelToken = axios.CancelToken;
let cancel;

    export default {
        components: {
          BarExample,
        },
        data(){
          return{
             options: {
                legend:{
                  display: false,
                },
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true,
                      callback: value => numeral(value).format('0,0.00')
                    }
                  }]
                },
                tooltips: {
                callbacks: {
                  label(tooltipItem, data) {
                    const label = data.datasets[tooltipItem.datasetIndex].label;
                    const value = numeral(tooltipItem.yLabel).format('0,0.00');

                    return `${label}: ${value}`;
                  }
                }
              },
                responsive: true,
                maintainAspecRation: true,
            },

             data: [],
             topsellingitems: {},
             toprenters: {},
             collections: {},
             collectibles:{},
             totalProducts: "",
             totalSales: "",
             totalRenters: "",
             totalCollected: "",
            daily: "",
              month: "",
              week: "",
              date:"",
              lastransac: {},
          };
        },
        methods: {
            loaddaily: function(){
          this.userid = this.$gate.Userprofile();
          this.branchid = this.$gate.Userprofile();
           axios.post("api/renterdashboarddaily?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id  ).then(({ data }) => {
            //  console.log();
             this.daily = data[0].price;
             this.date = data[0].datetoday
             });
        },

        loadmonth: function(){
        this.userid = this.$gate.Userprofile();
          this.branchid = this.$gate.Userprofile();
          axios.post("api/renterdashboardmonth?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id   ).then(({ data }) => {
          //  console.log();
            this.month = data[0].price;
            });
        },

        loadweek: function(){
        this.userid = this.$gate.Userprofile();
        this.branchid = this.$gate.Userprofile();
          axios.post("api/renterdashboardweek?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id    ).then(({ data }) => {
          //  console.log();
            this.week = data[0].price;
            });
        },

        lasttransaction: function(){
        this.userid = this.$gate.Userprofile();
         this.branchid = this.$gate.Userprofile();
          axios.post("api/lasttransaction?userid=" + this.userid.renter_id + "&branchid=" + this.branchid.branch_id).then(({ data }) => {
          //  console.log();
            this.lastransac = data;
            });
        },
          filldata: function(){
              axios.get("./api/dashboard", {
              }).then(response => {
                this.data = response.data;
              });
            },

            dashboardCollection(){
              axios.get("./api/dashboardcollection", {
              }).then(response => {
                this.collections = response.data;
                this.totalProducts = response.data['totalproducts'][0]['total_products'];
                 this.totalSales = response.data['totalsales'][0]['total'];
                 this.totalRenters = response.data['totalrenters'][0]['total_renters'];
                  this.totalCollected = response.data['totalcollections'];
                  // top selling item
                  this.topsellingitems = response.data['topsellingItems'];
                    // top sellers and renters
                  this.toprenters = response.data['toprenters'];
                  // collectibles
                  this.collectibles = response.data['duescollectibles'];
              });
            }

        },
        created(){
        this.loaddaily();
        this.loadmonth();
        this.loadweek();
        this.lasttransaction();
        this.dashboardCollection();
        },
        mounted() {
          this.filldata();
            console.log('Component mounted.')
        }
    }
</script>
