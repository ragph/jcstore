<template>
    <div class="container">
      <section  v-if="$gate.setting_null()">
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
        <section v-if="$gate.setting_is_NOTnull()">
            <div class="row ml-3">
                <div class="col-sm-6">
                    <h3 style="color:#34495e"> SETTINGS</h3>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right mr-3">
                        <li class="breadcrumb-item">
                            <router-link to="/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active"> Settings</li>
                    </ol>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">

                               <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist" style="border-bottom:0px">
                                    <li class="nav-item">
                                       <button class="nav-link active btn btn-sm btn-primary mr-4" id="custom-content-above-home-tab" data-toggle="pill" href="#general" role="tab" aria-controls="custom-content-above-home" aria-selected="true">General settings
                                       </button>
                                    </li>
                                    <li class="nav-item">
                                      <button class="nav-link  btn btn-sm btn-primary" id="custom-content-above-home-tab" data-toggle="pill" href="#backup" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Backup settings
                                       </button>
                                    </li>
                                  </ul>

                                   <div class="tab-content" id="custom-content-above-tabContent">
                                        <!-- GENERAL SETTINGS -->

                                      <div class="tab-pane fade show active pt-3" id="general" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                         <div class="row text-center p-2 pb-4">
                                              <div class="col-md-12 ">
                                                  <h4>General settings</h4>
                                              </div>
                                            </div>
                                    <form @submit.prevent="editmode ? editSettings() : createSettings()">
                                            <div class="row">
                                                    <div class="col-md-4">
                                                            <div class="form-group">
                                                            <label>Tax</label>
                                                            <input type="text" class="form-control" placeholder="Tax" v-model="form.tax" :class="{ 'is-invalid': form.errors.has('tax') }" name="tax">
                                                            <has-error :form="form" field="tax"></has-error>
                                                            </div>
                                                     </div>

                                                     <div class="col-md-4" v-if="$gate.setting_Edit_() | $gate.setting_Add_Edit() | $gate.setting_Edit_Delete() | $gate.setting_Add_Edit_Delete()">
                                                        <button type="submit" class="btn btn-primary" style="margin-top:30px;">Update product</button>
                                                     </div>
                                             </div>
                                        </form>
                                         </div>

                                         <div class="tab-pane fade pt-3" id="backup" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                         <div class="row text-center p-2 pb-4">
                                              <div class="col-md-12 ">
                                                  <h4>Backup settings</h4>
                                              </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <button v-if="$gate.setting_Add_() | $gate.setting_Add_Edit() | $gate.setting_Add_Delete() | $gate.setting_Add_Edit_Delete()"  class="btn btn-primary float-sm-right mb-2" @click="createBackup" ><i class="fa fa-sticky-note"></i> Create backup</button>
                                                </div>
                                                  <div class="col-md-12">
                                                  <table class="table table-striped">
                                                  <thead>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                  </thead>
                                                  <tbody>
                                                    <tr v-for="(item, index) in backupLoad.data " :key="index">
                                                      <td>{{item.backup_name}}</td>
                                                      <td>{{item.date | myDate}} {{item.time | timeFilter}}</td>
                                                      <td><button v-if="$gate.setting_Edit_() | $gate.setting_Add_Edit() | $gate.setting_Edit_Delete() | $gate.setting_Add_Edit_Delete()"  class="btn btn-success btn-sm float-sm-right" @click="downloadBackup(item.id, item.backup_name)" ><i class="fa fa-download"></i> Download</button></td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                                </div>
                                            </div>

                                         </div>


                                    </div>

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
    export default {
        data() {
            return {
                backupLoad: {},
                editmode: false,
                form: new Form({
                    id: '',
                    tax: '',
                }),
            };
        },
        methods: {
        createSettings(){
            this.form
                .post("api/settings")
                .then((data) => {
                  if(this.editmode == true){
                    Swal.fire("Updated!", "Record has been successfully updated" , "success");
                  }else{
                    Swal.fire("Updated!", "Record has been successfully updated" , "success");
                  }
                  this.loadSetting();
                })
                .catch(() => {
                  console.log("Error!", "Barangay settings not created", "error");
                });
          },
           editSettings(){
            this.form
              .put("api/settings/" + this.form.id)
              .then(() => {
                  this.loadSetting();
                   Swal.fire("Updated!", "Record has been successfully updated" , "success");
              })
              .catch(() => {});
          },
        loadSetting: function() {
            axios.get("api/getsettings").then(({ data }) => {
             if(data.length > 0){
                this.form.fill(data[0]);
                this.editmode = true;
              }else{
                this.editmode = false;
              }
            });
          },
          loadBackup(){
            axios.get("api/loadbackup").then(({ data }) => {
              this.backupLoad = data;
            })
          },
        createBackup(){
            axios.get("api/backup").then(({ data }) => {
              Swal.fire("Updated!", "Successfully backup" , "success");
              this.loadBackup();
            })
          },
           downloadBackup(id, name){
              axios.post("api/downloadsql?filename="+name+"&id="+id)
              .then((response) => {
                     var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                     var fileLink = document.createElement('a');

                     fileLink.href = fileURL;
                    //  let filename = this.form.type+'('+this.form.date_issued+')';
                     let filename = name;
                     fileLink.setAttribute('download', ''+filename+'.sql');
                     document.body.appendChild(fileLink);

                     fileLink.click();
                });
          },

        },
        created() {
            this.loadBackup();
            this.loadSetting();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>