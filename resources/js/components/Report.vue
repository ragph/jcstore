<template>
    <div class="container">
      <section  v-if="$gate.report_null()">
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
        <section  v-if="$gate.report_is_NOTnull()">
            <div class="row ml-3">
                <div class="col-sm-6">
                    <h3 style="color:#34495e"> REPORTS</h3>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right mr-3">
                        <li class="breadcrumb-item">
                            <router-link to="/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active"> Reports</li>
                    </ol>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Renter list
                                            </td>
                                            <td>
                                                 <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "renter_fields" :fetch="exportDataRenter" name="Renters list.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                <router-link to="/renterslist">
                                                 <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Product list by renter
                                            </td>
                                            <td>
                                                     <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "products_fields" :fetch="exportDataProduct" name="Product list.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/productlist">
                                                 <button class="btn btn-sm btn-primary "><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td>
                                                Inventory summary
                                            </td>
                                            <td>
                                                  <downloadexcel class="btn btn-info btn-sm export " style="color:white" :fields = "inventory_fields" :fetch="exportDataInventory" name="Inventory summary.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                <router-link to="/inventorylist">
                                                 <button class="btn btn-sm btn-primary "><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                             <tr>
                                             <td>
                                                Inventory history
                                            </td>
                                            <td>
                                                  <downloadexcel class="btn btn-info btn-sm export " style="color:white" :fields = "inventoryHis_fields" :fetch="exportDataInventoryHis" name="Inventory history.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                <router-link to="/inventoryhistory">
                                                 <button class="btn btn-sm btn-primary "><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Sales history
                                            </td>
                                            <td>
                                                <downloadexcel class="btn btn-info btn-sm export " style="color:white" :fields = "sales_fields" :fetch="exportDataSales" name="Sales history.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/saleshistory">
                                                 <button class="btn btn-sm btn-primary "><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                              Direct sales history
                                            </td>
                                            <td>
                                                 <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "direct_fields" :fetch="exportDataDirect" name="Direct sales history.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/directsalesreport">
                                                 <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                          <tr>
                                            <td>
                                         Sales released
                                            </td>
                                            <td>
                                                 <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "collections_fields" :fetch="exportDataCollection" name="Sales released history.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/salescollectionreport">
                                                 <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Cube summary
                                            </td>
                                            <td>
                                                 <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "cube_fields" :fetch="exportDataCube" name="Cube summary.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/cubesummary">
                                                 <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Void sale
                                            </td>
                                            <td>
                                                 <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "void_fields" :fetch="exportVoidData" name="Void sales.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/voidsalessummary">
                                                 <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Returns
                                            </td>
                                            <td>
                                                 <downloadexcel class="btn btn-info btn-sm export" style="color:white" :fields = "return_fields" :fetch="exportReturnData" name="Return sales.xls" type = "csv"><i class="fa fa-download"></i> Download Excel</downloadexcel>
                                                 <router-link to="/returnreports">
                                                 <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</button></router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->


    </div>
    <!---- container------>
</template>

<script>
import downloadexcel from "vue-json-excel";
import moment from 'moment';
    export default {
        components: {
        downloadexcel,
        },
        data() {
            return {
             searchForm: new Form({
                   renter:"",
                    sort: "",
                }),
             renter_fields: {
                  'Name': 'fullname',
                  'Branch': 'name',
                  'Cube number' : 'box_number',
                  'Date registered' : 'date_registered',
                  'Address' : 'address',
                  'Contact number' : 'contact_number',
                  },
                 products_fields: {
                  'Product name': 'product_name',
                  'SKU': 'sku',
                  'Cost price' : 'cost_price',
                  'Sell price' : 'sell_price',
                  'Renters name' : 'fullname',
                        'Branch' : 'name',
                  'Cube #' : 'box_numner',
                  },
                inventory_fields: {
                   'SKU': 'sku',
                  'Product name': 'product_name',
                  'Receiving total' : 'quantity',
                  'Return total' : 'Return_quantity',
                  'Sales total' : 'Sales_quantity',
                   'On hand' : 'Onhand',
                  },
             sales_fields: {
                  'Invoice number' : 'reference_no',
                  'SKU': 'sku',
                  'Product name': 'product_name',
                  'Renter' : 'fullname',
                  'Branch' : 'name',
                  'Cube #' : 'box_number',
                  'Customer' : 'customer_name',
                  'Date' : 'created_at',
                  'Total sales' : 'totalsales'
                  },
                 collections_fields: {
                  'Supplier/renter' : 'fullname',
                  'Branch': 'name',
                  'Cube #': 'box_number',
                  'Sales from' : 'sales_from',
                  'Sales to' : 'sales_to',
                  'Amount released' : 'amount',
                   'Date released' : 'date_released'
                  },
                direct_fields: {
                  'Invoice number' : 'reference_no',
                  'SKU': 'sku',
                  'Product name': 'product_name',
                  'Renter' : 'fullname',
                  'Branch' : 'name',
                  'Cube #' : 'box_number',
                  'Date' : 'created_at',
                    'Customer' : 'customer_name',
                  'Total sales' : 'totalsales'
                  },
            cube_fields: {
                  'Cube #': 'box_number',
                  'Renter': 'fullname',
                  'Branch' : 'name',
                  },
                  inventoryHis_fields: {
                    'SKU': 'sku',
                    'Product name': 'product_name',
                    'Renter' : 'fullname',
                    'Branch' : 'name',
                    'Cube #' : 'box_number',
                    'Date received' : 'date',
                    'Quantity' : 'quantity'
                  },
            void_fields: {
                    'Invoice #': 'reference_no',
                    'Products': 'product_name',
                    'Sales type' : {
                        field: 'sale_type',
                            callback: (value) => {
                                if(value == 'direct'){
                                    return 'Direct';
                                }else{
                                    return 'Customer'
                                }
                            }
                    },
                    'Quantity': 'quantity',
                    'Total': 'total_items',
                    'Date void': {
                        field: 'updated_at',
                            callback: (value) => {
                                return moment(value).format('MMM. DD, YYYY ');
                            }
                        },
                    },
            return_fields: {
                    'Invoice #': 'reference_no',
                    'Product name': 'product_name',
                    'Quantity': 'quantity',
                    'Date void': {
                        field: 'date_return',
                            callback: (value) => {
                                return moment(value).format('MMM. DD, YYYY ');
                            }
                        },
                    },
            };
        },
        methods: {
        async exportDataRenter(page = 1){
             const response = await this.searchForm.post("api/reportrenters?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
          async exportDataProduct(page = 1){
             const response = await this.searchForm.post("api/reportproducts?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
           async exportDataInventory(page = 1){
             const response = await this.searchForm.post("api/reportinventory?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
             async exportDataInventoryHis(page = 1){
             const response = await this.searchForm.post("api/reportinventoryhistory?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
           async exportDataSales(page = 1){
             const response = await this.searchForm.post("api/reportsaleshistory?page=" + page);
            console.log(response.data[0]['data']['data']);
            return response.data[0]['data']['data'];
          },
           async exportDataDirect(page = 1){
             const response = await this.searchForm.post("api/reportdirectsales?page=" + page);
            console.log(response.data[0]['data']['data']);
            return response.data[0]['data']['data'];
          },
        async exportDataCollection(page = 1){
             const response = await this.searchForm.post("api/reportsalesreleased?page=" + page);
            console.log(response.data[0]['data']['data']);
            return response.data[0]['data']['data'];
          },
          async exportDataCube(page = 1){
             const response = await this.searchForm.post("api/cubesummary?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
          async exportVoidData(page = 1){
             const response = await this.searchForm.post("api/voidsalesreport?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },
          async exportReturnData(page = 1){
             const response = await this.searchForm.post("api/returnsalesreport?page=" + page);
            console.log(response.data.data);
            return response.data.data;
          },

        },
        created() {

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>