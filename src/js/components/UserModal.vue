<template>
  <div class="container">
    <!-- Modal -->
    <div class="modal fade"  id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update {{row.name}}</h5>

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
</template>

<script>
  import Form from 'vform';

    export default {
        props:{
          row:{
            type: Object,
            default: ()=>({}),
          }
        },
        data(){
          return{
            editmode: true,
            form: new Form({
              id: '',
              name: '',
              email: '',
              password: '',
              type: '',
              bio: '',
              photo: ''
            })

          }
        },
        methods:{
          updateUser(id=this.row.id){
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
          editModal(user=this.row){
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show')
          },
          createUser(){
            this.$Progress.start();
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

              swal.fire("Failed!", "Something went wrong", "Warning");

              this.$Progress.fail();

            });
          },
          formFiller(){
            this.form.fill(this.row);
          }
        },
        created(){
          //console.log(this.row);
          //this.form.fill(this.row);
        },
        updated(){
          //this.form.fill(this.row);
        },
        mounted() {
        }
    }
</script>
