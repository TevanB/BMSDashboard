<template>
    <div class="container">

      <a href="#" @click="click(data)">
        <i class="fa fa-trash red"></i>
      </a>
    </div>
</template>

<script>
    import Form from 'vform';

    export default {
        data(){
          return{
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
        props:{
          row:{
            type: Object,
            default: ()=>({}),
          },
          data: {},
          name: {},
          click: {},
          meta: {},
          classes: {}
        },
        mounted() {

        },
        updated(){
          //console.log(this.row);
        },
        methods:{
        deleteUser(id=this.row.id){
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
        }
    }
</script>
