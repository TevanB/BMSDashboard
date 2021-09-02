<template>
  <img :src="getProfilePhoto()" alt="User Image" class="brand-image img-circle elevation-3"
style="opacity: .8">
</template>

<script>
    import Form from 'vform';
    export default {
        mounted() {
            //console.log('Component mounted.')
        },
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
        methods:{

          getProfilePhoto(){
            //console.log(this.form.photo);
            let photo = (this.form.photo.length > 100) ? this.form.photo: "img/profile/"+this.form.photo;
            //return "img/profile/"+this.form.photo;
            if(this.form.photo==''){
              return "https://app.bmsboosting.com/img/profile/profile.png"
            }
            return 'https://app.bmsboosting.com/'+photo;
          },


        },
        created(){
          axios.get("https://app.bmsboosting.com/api/me").then((data)=>{

            this.form.fill(data.data);


          });
        }
    }
</script>
