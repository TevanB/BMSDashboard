<template>
    <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">

      <div class="col">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">Add New
                <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <data-table
                :data="data"
                :columns="columns"
                @onTablePropsChanged="reloadTable">
            </data-table>
          </div>
        </div>
        <modal
          :row="selectedRow"
          ref="uModal">
        </modal>

      </div>
      <!-- Modal -->
          <div class="modal fade" id="addNew1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                  <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form @submit.prevent="editmode ? updateUser() : createUser()">
                <div class="modal-body">

                <div class="form-group">
                      <input v-model="form.name" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Username">
                      <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                      <input v-model="form.email" type="text" name="email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email Address">
                      <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                      <textarea v-model="form.bio" name="bio" id="bio"  placeholder="Short bio for user (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                      <has-error :form="form" field="bio"></has-error>
                </div>

                <div class="form-group">
                      <select name="type" v-model="form.type" id="type" class="form-control" :class="{
                      'is-invalid': form.errors.has('type')
                      }">
                      <option value="">Select User Role</option>
                      <option value="admin">Admin</option>
                      <option value="booster">Booster</option>
                      <option value="coach">Coach</option>
                      <option value="client">Client</option>

                      </select>
                      <has-error :form="form" field="type"></has-error>
                </div>


                <div class="form-group">
                      <input v-model="form.password" type="password" name="password" id="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                      <has-error :form="form" field="password"></has-error>
                </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                  <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>

                </div>
                </form>
              </div>
            </div>
          </div>
    </div>
    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>


    </div>
</template>

<script>
  import moment from 'moment';

    import Form from 'vform';
    import UserEdit1 from './UserEdit1';
    import UserEdit2 from './UserEdit2';
    import UserModal from './UserModal';
    export default {
    components:{
      UserEdit1,
      UserEdit2,
      UserModal,
    },
    data(){
     return{
       url: "https://app.bmsboosting.com/api/users",
       data: {},
       tableProps: {
           search: '',
           length: 10,
           column: 'id',
           dir: 'asc'
       },
       columns: [
           {
               label: 'ID',
               name: 'id',
               orderable: true,
           },
           {
               label: 'Name',
               name: 'name',
               orderable: true,
           },
           {
               label: 'Type',
               name: 'type',
               orderable: true,
           },
           {
               label: 'Email',
               name: 'email',
               orderable: true,
           },
           {
               label: 'Registered At',
               name: 'created_at',
               orderable: true,
           },
           {
               label: 'Edit',
               component: UserEdit1,
               orderable: false,
               event: 'click',
               handler: this.updateTableRow,
           },
           {
               label: 'Delete',
               component: UserEdit2,
               orderable: false,
               event: 'click',
               handler: this.deleteTableRow,
           },
       ],
       selectedRow:{},
       editmode: true,
       users: {},
       form: new Form({
         id: '',
         name: '',
         email: '',
         password: '',
         type: '',
         bio: '',
         photo: '',
         payout: '0.00',
         ongoing_orders: 0,
         completed_orders: 0,
         ongoing_orders_arr: [],
         current_orders_arr: [],
       })
       }
     },
     updated(){
      this.$refs.uModal.formFiller();
      $('.laravel-vue-datatable-td').each(function(i, obj) {
          let a = $(this).text();
          let regex = new RegExp(/\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d(?:\.\d+)?Z?/);
          if(a.match(regex)){
            $(this).text(moment(a).format('MMMM Do YYYY, h:mm:ss a'));
            ////console.log(moment(a).format('MMMM Do YYYY, h:mm:ss a'));
          }
      });
     },
        methods: {
        updateTableRow(data){

          this.selectedRow = data;

        },
        deleteTableRow(data){
          this.deleteUser(data.id);
        },
        getData(url = this.url, options = this.tableProps) {
            axios.get(url, {
                params: options
            })
            .then(response => {
                this.data = response.data;
            })
            // eslint-disable-next-line
            .catch(errors => {
                //Handle Errors
            })
        },
        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },
        getResults(page = 1) {
        			axios.get('api/user?page=' + page)
        				.then(response => {
        					this.users = response.data;
        				});
        		},

        updateUser(id){
          this.$Progress.start();
          this.form.put('api/user/'+this.form.id)
          .then(()=>{
            //successful
            $('#addNew').modal('hide');
            swal.fire(
              'Updated!',
              'Your user has been updated.',
              'success'
            )
            this.$Progress.finish();
            Fire.$emit('AfterCreate');
          })
          .catch(()=>{
            this.$Progress.fail();
          });
        },
        editModal(user){
          this.editmode = true;
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(user);
        },
        newModal(){
          this.editmode = false;
          this.form.reset();
          $('#addNew1').modal('show')
        },
        deleteUser(id){
          swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {

            //send req to server
            if(result.value){
            this.form.delete('api/user/'+id).then(()=>{
            Fire.$emit('AfterCreate');

                swal.fire(
                  'Deleted!',
                  'Your user has been deleted.',
                  'success'
                )

            }).catch(()=>{
            swal.fire(
              'Failed!',
              'Something went wrong.',
              'error'
            )
            });
            }
          })
        },
        loadUsers(){
          if(this.$gate.isAdmin){


          axios.get("api/user").then((data)=>(this.users=data.data));
          }
        },
          createUser(){
            this.$Progress.start();
            this.form.id = Date.now();
            this.form.photo = "profile.png";
            this.form.post('api/user')
            .then(()=>{
              Fire.$emit('AfterCreate');

              $('#addNew').modal('hide')

              toast.fire({
                icon: 'success',
                title: 'User Created Successfully'
              });
              this.$Progress.finish();

            })
            .catch(()=>{

              $('#addNew').modal('hide')

              swal.fire("Failed!", "Something went wrong", "error");

              this.$Progress.fail();

            });
          },
        },
        mounted() {
            //console.log('Component mounted.')
        },
        created(){
          this.loadUsers();
          this.getData(this.url);

          Fire.$on('AfterCreate', ()=>{
            this.loadUsers();
          });


          //setInterval(()=>this.loadUsers(), 3000);
        }
    }
</script>
