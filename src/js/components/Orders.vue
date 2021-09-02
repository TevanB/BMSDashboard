<template>
    <div class="container">
    <div class="row mt-5" v-if="$gate.isWorkerOrAdmin()">


      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Orders</h3>
            <div class="card-tools">
            <button class="btn btn-success" @click="newModal" v-if="$gate.isAdmin()">Add New
            <i class="fas fa-cart-plus"></i>
            </button>
          </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Order Type</th>
                  <th>Order Price</th>
                  <div v-if="$gate.isAdmin()">
                  <th>Company Cut</th>
                  </div>
                  <th>Order Message</th>
                  <th>Order Date</th>

                </tr>
              </thead>
              <tbody>
                <tr v-for="order in filterClaimed(orders)" :key="order.order_id">

                  <td>{{order.order_id}}</td>
                  <td>{{order.order_type}}</td>
                  <td>{{boosterCut(order.order_price)}}</td>
                  <div v-if="$gate.isAdmin()">
                  <td>{{companyCut(order.order_price)}}</td>
                  </div>
                  <td>{{orderExtraFormat(order.order_message)}}</td>
                  <td>{{order.created_at|myDate}}</td>

                  <td>

                    <button class="btn btn-block btn-primary" @click="claimOrder(order)">Claim</button>

                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="orders" :limit=-1 @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div v-if="!$gate.isWorkerOrAdmin()">
      <not-found></not-found>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLabel">Add New</h5>


            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createOrder()">
          <div class="modal-body">

          <div class="form-group">
                <input v-model="new_order.order_type" type="text" name="order_type"
                  class="form-control" :class="{ 'is-invalid': new_order.errors.has('order_type') }" placeholder="Order Type">
                <has-error :form="new_order" field="order_type"></has-error>
          </div>

          <div class="form-group">
                <input v-model="new_order.order_price" type="text" name="order_price"
                  class="form-control" :class="{ 'is-invalid': new_order.errors.has('order_price') }" placeholder="Order Price">
                <has-error :form="new_order" field="order_price"></has-error>
          </div>

          <div class="form-group">
                <input v-model="new_order.client_id" type="text" name="client_id"
                  class="form-control" :class="{ 'is-invalid': new_order.errors.has('client_id') }" placeholder="Client ID">
                <has-error :form="new_order" field="client_id"></has-error>
          </div>

          <div class="form-group">
                <input v-model="new_order.order_id" type="text" name="order_id"
                  class="form-control" :class="{ 'is-invalid': new_order.errors.has('order_id') }" placeholder="Order ID">
                <has-error :form="new_order" field="order_id"></has-error>
          </div>


          <div class="form-group">
                <label for="order_message">{"type":"","username":"","password":"","email":"","summoner_name":"","discord":"",<br>"message":"","lpg":"19","starting_lp":"(0-20)","extras":[]}</label>
                <textarea v-model="new_order.order_message" type="text" name="order_message" id="order_message"  placeholder="Order Message"
                  class="form-control" :class="{ 'is-invalid': new_order.errors.has('order_message') }"></textarea>
                <has-error :form="new_order" field="order_message"></has-error>
          </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>

          </div>
          </form>
        </div>
      </div>
    </div>
    </div>
</template>

<script>
    require('howler');
    import Form from 'vform';
    export default {
    data(){
     return{

       editmode: true,
       orders: {},
       new_order: new Form({
         order_id: '',
         order_type: '',
         order_price: '',
         order_message: '',
         client_id: '',


       }),
       form: new Form({
         order_id: '',
         order_type: '',
         order_price: '',
         order_message: '',
         client_id: '',
         booster_id: '',
         created_at: '',

       }),
       user: new Form({
         id: '',
         name: '',
         email: '',
         password: '',
         type: '',
         bio: '',
         photo: '',
         payout:'',
         ongoing_orders: '',
         completed_orders: '',
         ongoing_orders_arr: '',
         current_orders_arr: '',
       }),
       }
     },
        methods: {



        filterClaimed(items){

          if(items){
            let items2 = items.data;
            let result= [];
            if(items2){
              for(let i=0; i<items2.length; i++){
                if(items2[i].order_status=='unclaimed'){
                  result.push(items2[i]);
                }
              }
            }
            let result2 = result.reverse();
            //console.log(result);
            //console.log(result2);
            return result2;
          }

        },
        boosterCut(totalPrice){
          let adjustedPrice = (totalPrice*0.96)-0.3;
          let bCut = Math.floor(adjustedPrice*0.7);
          return bCut;
        },
        companyCut(totalPrice){
          let adjustedPrice = (totalPrice*0.96)-0.3;
          let bCut = Math.floor(adjustedPrice*0.7);

          let cCut = adjustedPrice - bCut;
          return cCut.toFixed(2);
        },
        orderExtraFormat(input){

          let tempObj = JSON.parse(input);
          if(tempObj){
          let arr = tempObj.extras;
          let result = (tempObj.region).toUpperCase() + " | ";
          for(let i=0; i<arr.length; i++){
            result += arr[i];
            if(i != arr.length-1){
              result += " | ";
            }

          }
          return result;}
        },
        refreshPage(){
          window.location.reload();
        },
        claimOrder(order){
          axios.get("api/me").then((data)=>{
            this.user.fill(data.data);
            if(data.data.ongoing_orders < 3){
              //this.user.ongoing_orders = this.user.ongoing_orders + 1;

              //let arr1 = this.user.ongoing_orders_arr;
              //if(!this.user.ongoing_orders_arr){
              //  arr1 = [];
              //}
              //this.user.ongoing_orders_arr = arr1;

              this.form.booster_id = data.data.id;
              order.booster_id = data.data.id;
              this.form.order_status = 'claimed';
              //order.order_status = 'claimed';
              ////console.log(this.user.ongoing_orders);
              ////console.log(order);
              //arr1.push(order);

              this.form.put('api/order/'+order.order_id)
              .then((data)=>{
                //successful
                if(data.data != 'false'){
                $('#addNew').modal('hide');
                swal.fire(
                  'Claimed!',
                  'You have claimed this order.',
                  'success'
                ).then((result)=>{
                  if(result.value){
                    this.refreshPage();

                  }
                });
                this.$Progress.finish();
                Fire.$emit('AfterCreate');
                }else{
                  swal.fire(
                    'Error',
                    'This order has already been claimed',
                    'error'
                  )
                }

              })
              .catch(()=>{
                this.$Progress.fail();
              });


            }
            else{
              $('#addNew').modal('hide');
                swal.fire(
                  'Claim Error',
                  'You have too many ongoing orders.',
                  'error'
                )
            }
            })
            .catch(error=>{
              //$('#addNew').modal('hide');
              //swal.fire(
                //'Server Error',
                //'There was a problem with the server.',
                //'error'
              //);
              //console.log(error);
              //this.$Progress.fail();
            });
        },
        getUserID(){


        },
        newModal(){
          this.editmode = false;
          this.form.reset();
          $('#addNew').modal('show')
        },
        getResults(page = 1) {
        			axios.get('api/orders?page=' + page)
        				.then(response => {
        					this.orders = response.data;
        				});
        		},

        loadOrders(){
          if(this.$gate.isAdmin){


          axios.get("api/ordersF").then((data)=>{
            this.orders=data;
            //console.log(data);
          });
          }
        },
        createOrder(){
        this.new_order.order_id = Date.now();
        //console.log(this.new_order.order_id);
        //console.log(this.new_order.order_price);
          axios.put('https://app.bmsboosting.com/api/orders', this.new_order).then(()=>{
            swal.fire(
              'Created!',
              'Your order has been successfully created.',
              'success'
            )
          });
        },
          },
        mounted() {
            let that = this;
            window.Echo.private('purchase')
              .listen('new-purchase', (e) => {
              that.loadOrders();
              var sound = new Howl({
                src: 'https://app.bmsboosting.com/assets/sounds/claim2.mp3',
                autoplay: true,
                loop: false,

              });
              sound.play();



              });
        },
        created(){
          this.loadOrders();

          Fire.$on('AfterCreate', ()=>{
            this.loadOrders();
          });

        }
    }
</script>
