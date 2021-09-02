

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">

                      <div class="card card-widget widget-user bg-secondary">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                          <div class="widget-user-header text-grey" style="background:url('./img/blackfrost-reksai.jpeg')">
                            <h3 class="widget-user-desc text-right">{{this.user.name | upText}}</h3>
                            <h5 class="widget-user-username text-right">{{this.user.type | upText}}</h5>
                          </div>
                          <div class="widget-user-image ">
                            <img class="img-circle bg-light" :src="getProfilePhoto()" alt="User Avatar">
                          </div>
                          <div class="card-header">
                            <div class="row mt-3">
                              <div class="col-sm-4 border-right">
                                <div class="description-block">
                                  <h5 class="description-header">{{this.user.ongoing_orders}}</h5>
                                  <span class="description-text">ONGOING ORDERS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4 border-right">
                                <div class="description-block">
                                  <h5 class="description-header">{{this.user.completed_orders}}</h5>
                                  <span class="description-text">COMPLETED ORDERS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4">
                                <div class="description-block" v-if="$gate.isWorkerOrAdmin()">
                                  <h5 class="description-header">{{this.user.rank}}</h5>
                                  <span class="description-text">RANK</span>
                                </div>
                                <div class="description-block" v-if="$gate.isClient()">
                                  <h5 class="description-header">{{this.user.created_at | myDate2}}</h5>
                                  <span class="description-text">REGISTRATION DATE</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->
                          </div>
                        </div>

                        <div class="card">
                                      <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                          <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Account</a></li>
                                          <li class="nav-item"  v-if="$gate.isBoosterOrCoach()"><a class="nav-link" href="#orders" data-toggle="tab">Orders</a></li>
                                          <li class="nav-item"  v-if="$gate.isBoosterOrCoach()"><a class="nav-link" href="#payouts" data-toggle="tab">Payouts</a></li>

                                        </ul>
                                      </div><!-- /.card-header -->
                                      <div class="card-body">
                                        <div class="tab-content">
                                          <div class="tab-pane" id="orders"  v-if="$gate.isBoosterOrCoach()">

                                            <div class="card-header">
                                              <h3 class="card-title">Order History (Completed)</h3>
                                              <div class="card-tools">
                                              <button class="btn btn-success" @click="requestAllPayouts()">Request All Payouts
                                              <i class="fas fa-arrows-alt-v"></i>
                                              </button>
                                            </div>
                                          </div>
                                          <div class="card-body table-responsive p-0">
                                            <table class="table table-hover">
                                              <thead>
                                                <tr>
                                                  <th>Order ID</th>
                                                  <th>Order Type</th>
                                                  <th>Order Payout</th>
                                                  <th>Payout Status</th>
                                                  <th>Order Date</th>

                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr v-for="order in user.current_orders_arr" :key="order.order_id">

                                                  <td>{{order.order_id}}</td>

                                                  <td>{{order.order_type}}</td>
                                                  <td>{{boosterCut(order.order_price)}}</td>
                                                  <td>{{psTranslate(order.payout_status)|upText}}</td>
                                                  <td>{{order.created_at|myDate}}</td>

                                                  <td>
                                                    <div v-if="order.payout_status != 'completed' && order.payout_status != 'requested'">
                                                    <button class="btn btn-block btn-primary" @click="requestPayout(order)">Request Payout</button>
                                                    </div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>

                                          </div>
                                          <!-- /.tab-pane -->

                                          <div class="tab-pane" id="payouts"  v-if="$gate.isBoosterOrCoach()">
                                            <div class="card-header">
                                              <h3 class="card-title">Payout Info</h3>
                                              <div class="card-tools">
                                              <button class="btn btn-success" @click="payoutDash()">Payout Dashboard
                                              <i class="fas fa-arrows-alt-v"></i>
                                              </button>
                                              </div>
                                            </div>

                                            <div class="card-body">
                                              <!-- Add Stripe UI for Payouts -->
                                            </div>
                                          </div>

                                          <!-- /.tab-pane -->

                                          <div class="tab-pane active" id="settings">
                                          <form @submit.prevent="updateInfo()">

                                            <div class="form-group">
                                            <label for="name" class="col-sm-2">Username</label>

                                                  <input v-model="form.name" type="text" name="name"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Username">
                                                  <has-error :form="form" field="name"></has-error>
                                            </div>

                                            <div class="form-group">
                                            <label for="email" class="col-sm-2">Email</label>

                                                  <input v-model="form.email" type="text" name="email"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email Address">
                                                  <has-error :form="form" field="email"></has-error>
                                            </div>

                                            <div class="form-group">
                                            <label for="bio" class="col-sm-2">User Bio</label>

                                                  <textarea v-model="form.bio" name="bio" id="bio"  placeholder="Short bio for user (Optional)"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                                  <has-error :form="form" field="bio"></has-error>
                                            </div>


                                                      <div class="form-group">
                                                          <label for="photo" class="col-sm-2">Profile Photo</label>
                                                            <input type="file" name="photo"
                                                              @change="updateProfile" class="form-input" >
                                                      </div>

                                            <div class="form-group">
                                            <label for="password" class="col-sm-2">Password</label>

                                                  <input v-model="form.password" type="password" name="password" id="password"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                                                  <has-error :form="form" field="password"></has-error>
                                            </div>


                                              <button type="button" class="btn btn-secondary">Close</button>
                                              <button type="submit" class="btn btn-success">Update</button>


                                          </form>
                                          </div>
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->

                                      </div><!-- /.card-body -->
                                    </div>
                                    </div>
                                </div>
                            </div>
</template>

<script>
    import Form from 'vform';
    import HasError from 'vform';
    Vue.component(HasError.name, HasError);
    export default {
        data(){
          return{
            orders:{},
            user:{},
            form: new Form({
              id: '',
              name: '',
              email: '',
              password: '',
              type: '',
              payout:'',
              rank:'',
              bio: '',
              photo: '',
              ongoing_orders:'',
              completed_orders:'',
            }),
            order_form: new Form({
              order_id: '',
              order_type: '',
              order_price: '',
              order_message: '',
              payout_status: '',
              client_id: '',
              booster_id: '',
              created_at: '',
            }),
          }
        },
        methods:{
          updateInfo(){
            //axios.post("api/profile", this.form);
            axios.put("api/profile", this.form).then(()=>{
              swal.fire(
                'Profile Updated',
                'You have successfully updated your profile.',
                'success'
              ).then((result)=>{
                if(result.value){
                  this.refreshPage();
                }
              });
            }).catch(()=>{
              swal.fire(
                'Sorry About That',
                'Something went wrong with updating your profile.',
                'error'
              )
            });
          },
          loadOrders(){
            if(this.$gate.isWorkerOrAdmin){
              axios.get("api/orders").then((data)=>(this.orders=data));
            }
          },
          payoutDash(){
            //redirect to url with stripe dashboard
            axios.post('https://app.bmsboosting.com/api/user-stripe-dash',
            {
              email:this.form.email
            }).then((data)=>{
              console.log(data);
              window.location.replace(data.data);
            });
          },
          requestAllPayouts(){
            let found = false;
            for(let i=0; i<this.user.current_orders_arr.length; i++){
              if(this.user.current_orders_arr[i].payout_status != 'completed'){
                axios.put('https://app.bmsboosting.com/api/requestAllPayouts/'+this.user.id).then((data)=>{
                  toast.fire({
                    icon: 'success',
                    title: 'Payout Requests Sent.'
                  });
                });
                found = true;
                break;
              }
            }
            if(!found){
              toast.fire({
                icon: 'error',
                title: 'You have no payouts.'
              });
            }
            /*axios.put('https://app.bmsboosting.com/api/requestAllPayouts/'+this.user.id).then((data)=>{
              toast.fire({
                icon: 'success',
                title: 'Payout Requests Sent.'
              });
            });*/
            /*for(let i=0; i<this.form.current_orders_arr; i++){
              requestPayout(this.form.current_orders_arr[i]);
            }*/
          },
          requestPayout(order){
            if(order.payout_status != 'completed'){
              order.payout_status = 'requested';
              //console.log(order);
              axios.put('https://app.bmsboosting.com/api/orders/'+order.order_id, order).then(()=>{
              });
              for(let i=0; i<this.user.current_orders_arr.length; i++){
                if(this.user.current_orders_arr[i].order_id === order.order_id){
                  this.user.current_orders_arr[i].payout_status = 'requested';
                }
              }
              axios.put('https://app.bmsboosting.com/api/me', this.user);
            }else{
              toast.fire({
                icon: 'error',
                title: 'This payout has already been sent.'
              });
            }
          },
          getProfilePhoto(){
            let photo = (this.form.photo.length > 100) ? this.form.photo: "img/profile/"+this.form.photo;
            if(this.form.photo == ''){
              return "img/profile/profile.png";
            }
            //return "img/profile/"+this.form.photo;
            return photo;
          },
          refreshPage(){
            window.location.reload();
          },
          boosterCut(totalPrice){
            let adjustedPrice = (totalPrice*0.96)-0.3;
            let bCut = Math.floor(adjustedPrice*0.7);
            return bCut;
          },
          getUser(){
            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{
              this.user = data.data;
              ////console.log(this.user);
            });
          },
          psTranslate(status){
            if(status === 'in-progress'){
              return 'Payout Unpaid';
            }else if(status === 'processed'){
              return 'Payout Unpaid';
            }else if(status === 'requested'){
              return 'Payout Requested';
            }else if(status === 'completed'){
              return 'Payout Sent';
            }else{
              return "N/A"
            }
          },
          updateProfile(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if(file['size']<2111775){
              reader.onloadend = (file)=>{
                this.form.photo=reader.result;
              }
              reader.readAsDataURL(file);
            }else{
              toast.fire({
                icon: 'error',
                title: 'File too large to upload.'
              });
            }
          }
          },
        mounted() {
            //console.log('Component mounted.');
            let that = this;
            window.Echo.private('claims')
              .listen('order-claimed', (e) => {
              ////console.log("Order claim heard!!");
              ////console.log(e);
              for(let i=0; i<that.user.ongoing_orders_arr.length; i++){
                if(e.orderID === that.user.ongoing_orders_arr[i].order_id && that.user.type === 'client'){
                swal.fire({
                title: 'Order Claimed',
                text: 'Your order has been claimed by a booster.',
                icon: 'success',
                confirmButtonText: 'Go To Order Page'
                }).then((result)=>{
                  if(result.value){
                    window.location.replace('https://app.bmsboosting.com/order/'+e.orderID);
                  }
                })
                  break;
                }
              }
              });
        },
        created(){
          this.loadOrders();
          Fire.$on('AfterCreate', ()=>{
            this.loadOrders();
          });
          this.getUser();
          axios.get("api/me").then((data)=>(this.form.fill(data.data)));
          Fire.$on('AfterCreate', ()=>{
            axios.get("api/me").then((data)=>(this.form.fill(data.data)));
            });
        }
};
</script>