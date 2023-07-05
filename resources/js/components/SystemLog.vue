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
                    <h3 style="color:#34495e"> System log</h3>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right mr-3">
                        <li class="breadcrumb-item">
                            <router-link to="/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active"> System log</li>
                    </ol>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped datatable_main" id="users-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Activity</th>
                                            <th>Activity ID</th>
                                            <th>Date committed</th>
                                            <th class="nosort">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                        
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- =================================================================================================================================== -->
        <!-- ADD CATEGORY MODAL -->

        <section>
            <div class="modal fade" id="viewDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <p style="margin-left: 1em">{{modal_title}}</p>
                        <ul class="object-details">
                        {<li v-for="(item, index) in item_details[0]" :key="index">
                            <span class="object-index">{{ index }}</span> : <span class="object-item">{{ item }}</span>
                        </li>}
                        </ul>
                    </div>
                    </div>

                </div>
                </div>
            </div>
            </section>


    </div>
    <!---- container------>
</template>

<script>
// import downloadexcel from "vue-json-excel";
import moment from 'moment';
    export default {
        components: {
        // downloadexcel,
        },
        data() {
            return {
            item_details: {},
            modal_title: '',
             searchForm: new Form({
                   renter:"",
                    sort: "",
                }),
           
            };
        },
        methods: {
            viewSystemLog(data){
                $('#viewDetails').modal('show');
                 this.modal_title = data.activity;
                this.item_details = eval('[' + data.details + ']');
            },
            searchSystemLog(){
            let formSearch = this.searchForm;
            $(function() {
                $('#users-table').DataTable( {
                    processing: true,
                    serverSide: true,
                    pageLength: 50,
                    lengthMenu: [[10, 25, 50], [10, 25, 50]],
                    bDestroy: true,
                    ajax : {
                        url: "api/systemlogs",
                        type: 'POST',
                        data: formSearch,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    },

                    columns: [
                        { data: 'username', name: 'username' },
                        { data: 'activity', name: 'activity' },
                        { data: 'activity_id', name: 'activity_id' },
                        { data: 'created_at', name: 'created_at' },
                        // { data: 'respondent_data', name: 'respondent_data' },
                        { data: 'action', name: 'action'}
                        
                        // { data: 'name', name: 'draws.name' },
                        // { data: 'drawdate', name: 'drawdate' },
                        // { data: 'boothnumber', name: 'booths.boothnumber' },
                        // { data: 'status', name: 'status' }
                    ],
                    order: [[ 3, "desc" ]],
                    columnDefs:[
                      
                        { targets:3, render:function(data){ return moment(data).format('MMM. DD, YYYY h:mm:ss a'); } },
                        // { targets:3, render:function(data){ return moment(data,'h:mm a').format('h:mm a'); } },
                    ],
                    drawCallback: function() {
                        $("#users-table td").on("click", "button.action_btn_view", function(){
                            let datas = $(this).data('info');
                            Fire.$emit('viewSystemLog', datas);
                        });
                    }
                });
            });
            }

        },
        created() {
            this.searchSystemLog();

            Fire.$on("viewSystemLog", (data) => {
                this.viewSystemLog(data);
            });
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>