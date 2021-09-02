<template>

    <div class="container-fluid">
        <div>
        <div class="row mt-5 justify-content-center" v-if="$gate.isAdmin()">





            <div class="row container-fluid">
            <div class="col">
            <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Admin Options</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">

            <div class="row">

            <div class="col">
            <div class="card bg-light mb-3" style="max-width: 18rem;">
              <div class="card-header"></div>
              <div class="card-body">
                <h5 class="card-title mb-5">Admin Payout Getter</h5>
                <button type="button" class="btn btn-block btn-outline-primary" @click.prevent="adminPayouts()">Process</button>
              </div>
            </div>
            </div>

            <div class="col">
            <div class="card bg-light mb-3" style="max-width: 18rem;">
              <div class="card-header"></div>
              <div class="card-body">
                <h5 class="card-title mb-5">Admin Mark Withdrawn</h5>
                <button type="button" class="btn btn-block btn-outline-primary" @click.prevent="adminWithdraw()">Process</button>
              </div>
            </div>
            </div>

            <div class="col">
              <div class="card bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header"></div>
                <div class="card-body">
                  <h5 class="card-title mb-5">Current Admin Payout</h5>
                  <h2  id="uPayoutID" class="text-center card-text" :key="adminUser.payout">${{getPayout(user)}} USD</h2>

                </div>
              </div>
              </div>
            </div>






            </div>
            <!-- /.card-body -->
            </div>
          </div>


            </div>


            <div class="row container-fluid">
            <div class="col">
            <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Active Orders Summary</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h2 class="mt-3 mb-3 ml-3">Order Reassign Requests</h2>
                  <div class="row container-fluid" id="reassignAlerts">

                  </div>
                </div>
                <div class="col">
                  <h2 class="mt-3 mb-3 ml-3">Order Drop Requests</h2>
                  <div class="row container-fluid" id="dropAlerts">

                  </div>
                </div>
                <div class="col">
                  <h2 class="mt-3 mb-3 ml-3">Order Completion Requests</h2>
                  <div class="row container-fluid" id="doneAlerts">

                  </div>
                </div>
                <div class="col">
                  <h2 class="mt-3 mb-3 ml-3">Order Claims</h2>
                  <div class="row container-fluid" id="claimAlerts">

                  </div>
                </div>
              </div>
              <h2 class="mt-3 mb-3 ml-3">Ongoing Orders</h2>

              <div class="row ml-3 mr-3">

                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Booster ID</th>
                      <th>Order Type</th>
                      <th>Order Price</th>
                      <th>Booster Payout</th>
                      <th>Company Profits</th>
                      <th>Order Message</th>
                      <th>Order Status</th>
                      <th>Payout Status</th>
                      <th>Order Date</th>

                    </tr>
                  </thead>


                  <tbody v-if="orders.data">
                    <tr v-for="order in orders.data.data" :key="order.order_id" v-if="orders.data && orders.data.data && order.order_status != 'unclaimed' && order.order_status != 'completed' && order.order_status != 'reassigned' && order.order_status != 'cancelled'">







<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewLabel">Reassignment Info Setter</h5>


        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="createOrder()">
      <div class="modal-body">


      <h5 id="initOrderPrice"></h5>
      <h5 id="initOrderType"></h5>
      <h5 id="curOrderRank"></h5>
      <h5 id="orderSumName"></h5>
      <div class="form-group mt-3 mb-3">
            <label for="orderPriceInput">Set Reassignment Order Price</label>
            <input v-model="newOrder.order_price" type="number" name="order_price" id="orderPriceInput"
              class="form-control" :class="{ 'is-invalid': newOrder.errors.has('order_price') }" placeholder="Order Price">
            <has-error :form="newOrder" field="order_price"></has-error>
      </div>
      <div>
        <label for="gameSel">Set Number of Wins/Games</label>
        <h4 id="gameNum">{{new_gameNum}}</h4>

        <div class="form-group" id="gameSec">
          <input type="range" min="1" max="20" step="1" value="10" id="gameSel" v-model="new_gameNum" class="custom-range">

        </div>
      </div>

      <label for="radioSec">Set Reassignment Order LP</label>

      <div class="form-group" id="radioSec">

        <div class="form-check">
            <input v-model="new_curLP" type="radio" name="order_lp" value="(0-20)" id="020"
              class="form-check-input" checked>
              <label class="form-check-label" for="020">(0-20) LP</label>

              </div>


            <div class="form-check">

              <input v-model="new_curLP" type="radio" name="order_lp" value="(21-40)" id="2140"
                class="form-check-input">
                <label class="form-check-label" for="2140">(21-40) LP</label>

                </div>
                <div class="form-check">

                <input v-model="new_curLP" type="radio" name="order_lp" value="(41-60)" id="4160"
                  class="form-check-input">
                  <label class="form-check-label" for="4160">(41-60) LP</label>

                  </div>
                  <div class="form-check">


                  <input v-model="new_curLP" type="radio" name="order_lp" value="(61-80)" id="6180"
                    class="form-check-input">
                    <label class="form-check-label" for="6180">(61-80) LP</label>

                    </div>
                    <div class="form-check">


                    <input v-model="new_curLP" type="radio" name="order_lp" value="(81-99)" id="8199"
                      class="form-check-input">
                      <label class="form-check-label" for="8199">(81-99) LP</label>

                      </div>
                      <div class="form-check">


                      <input v-model="new_curLP" type="radio" name="order_lp" value="100" id="100"
                        class="form-check-input">
                        <label class="form-check-label" for="100">100 LP</label>

                        </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" @click.prevent="createNewOrder()" class="btn btn-primary">Create</button>

      </div>
      </form>
    </div>
  </div>
</div>

                      <td>{{order.order_id}}</td>
                      <td>{{order.booster_id}}</td>

                      <td>{{order.order_type}}</td>
                      <td>{{order.order_price}}</td>
                      <td>{{boosterCut(order.order_price)}}</td>
                      <td>{{companyCut(order.order_price)}}</td>
                      <td>{{orderExtraFormat(order.order_message)}}</td>
                      <td>{{order.order_status}}</td>
                      <td>{{order.payout_status}}</td>
                      <td>{{order.created_at|myDate}}</td>

                      <td>

                        <button class="btn btn-block btn-primary" @click.prevent="reassignOrder(order)">Reassign</button>

                      </td>




                    </tr>

                  </tbody>
                </table>

                </div>
                <h2 class="mt-3 mb-3 ml-4">Unclaimed Orders</h2>

                <div class="row ml-3 mr-3">

                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Booster ID</th>
                        <th>Order Type</th>
                        <th>Order Price</th>
                        <th>Booster Payout</th>
                        <th>Company Profits</th>
                        <th>Order Message</th>
                        <th>Order Status</th>
                        <th>Payout Status</th>
                        <th>Order Date</th>

                      </tr>
                    </thead>


                    <tbody v-if="orders.data">
                      <tr v-for="order in orders.data.data" :key="order.order_id" v-if="order.order_status == 'unclaimed'">

                                            <td>{{order.order_id}}</td>
                                            <td>{{order.booster_id}}</td>

                                            <td>{{order.order_type}}</td>
                                            <td>{{order.order_price}}</td>
                                            <td>{{boosterCut(order.order_price)}}</td>
                                            <td>{{companyCut(order.order_price)}}</td>
                                            <td>{{orderExtraFormat(order.order_message)}}</td>
                                            <td>{{order.order_status}}</td>
                                            <td>{{order.payout_status}}</td>
                                            <td>{{order.created_at|myDate}}</td>





                                          </tr>

                                        </tbody>
                                      </table>

                                      </div>

            </div>

            <!-- /.card-body -->
            </div>
            </div>


            </div>


            <div class="mt-5 container-fluid">

            <div class="card collapsed-card" v-for="user in users" :key="user.id" v-if="user.type!='client'">
            {{checkDropReq(user)}}

            <div v-if="checkRequested(user) == true">
                      <div class="ribbon-wrapper">
                        <div class="ribbon bg-primary">
                          Payout
                        </div>
                      </div>
                </div>

              <div class="card-header">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                <br>
                <h3 class="card-title">{{user.name}} | {{user.id}}</h3>


                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">

                  <div class="col">
                    <div class="card bg-light mb-3" style="max-width: 18rem;">
                      <div class="card-header">Current Payout</div>
                      <div class="card-body">
                        <h2  id="uPayout" class="text-center card-text">{{user.payout}}</h2>

                      </div>

                    </div>
                  </div>


                  <div class="col">
                  <div class="card bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-header"></div>
                    <div class="card-body">
                      <h5 class="card-title mb-5">Payout All</h5>
                      <button type="button" class="btn btn-block btn-outline-primary" @click.prevent="payoutAll(user)">Process</button>
                    </div>
                  </div>
                  </div>


                  <div class="col">
                    <div class="card bg-light mb-3" style="max-width: 18rem;">
                      <div class="card-header">Email Address</div>
                      <div class="card-body">
                        <p id="uPayout" class="text-center text-bold card-text">{{user.email}}</p>

                      </div>

                    </div>
                  </div>



                </div>
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Ongoing Orders</h3>
                    <div class="card-tools">

                  </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Booster ID</th>
                          <th>Order Type</th>
                          <th>Order Price</th>
                          <th>Booster Payout</th>
                          <th>Company Profits</th>
                          <th>Order Message</th>
                          <th>Order Status</th>
                          <th>Payout Status</th>
                          <th>Order Date</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="order in user.ongoing_orders_arr" :key="order.order_id">

                          <td>{{order.order_id}}</td>
                          <td>{{order.booster_id}}</td>

                          <td>{{order.order_type}}</td>
                          <td>{{order.order_price}}</td>
                          <td>{{boosterCut(order.order_price)}}</td>
                          <td>{{companyCut(order.order_price)}}</td>
                          <td>{{orderExtraFormat(order.order_message)}}</td>
                          <td>{{order.order_status}}</td>
                          <td>{{order.payout_status}}</td>
                          <td>{{order.created_at|myDate}}</td>

                          <td>

                            <button class="btn btn-block btn-primary" @click.prevent="markFinished(order, user)">Mark Finished</button>

                          </td>

                          <td>

                            <button class="btn btn-block btn-primary" @click.prevent="markReassigned(order, user)">Mark Reassigned</button>

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


                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Completed Orders</h3>
                    <div class="card-tools">

                  </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Booster ID</th>
                          <th>Order Type</th>
                          <th>Order Price</th>
                          <th>Booster Payout</th>
                          <th>Company Profits</th>
                          <th>Payout Status</th>
                          <th>Order Message</th>
                          <th>Order Date</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="order in user.current_orders_arr" :key="order.order_id">

                          <td>{{order.order_id}}</td>
                          <td>{{order.booster_id}}</td>

                          <td>{{order.order_type}}</td>
                          <td>{{order.order_price}}</td>
                          <td>{{boosterCut(order.order_price)}}</td>
                          <td>{{companyCut(order.order_price)}}</td>
                          <td>{{order.payout_status}}</td>
                          <td>{{orderExtraFormat(order.order_message)}}</td>
                          <td>{{order.created_at|myDate}}</td>


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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


            </div>
        </div>
        </div>
        <div>
        <div v-if="$gate.isAdmin() == false">
          <not-found></not-found>
        </div>
        </div>
    </div>
</template>

<script>
    import Form from 'vform';
    export default {
        data(){
         return{

           editmode: true,
           users: {},
           user:{},
           new_curLP:'',
           new_gameNum:1,
           orders:{},
           rOrder:{},
           adminUser:{},
           form: new Form({
             id: '',
             name: '',
             email: '',
             password: '',
             type: '',
             bio: '',
             photo: ''
           }),
           userPP: new Form({
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
           newOrder: new Form({
             order_id: '',
             order_type: '',
             order_price: '',
             order_message: '',
             order_status: '',
             client_id: '',
             booster_id: '',
             created_at: '',
             payout_status:'',
           }),
           }
         },
        mounted() {
        if(this.$gate.isAdmin()){

            /*for(let i=0; i<this.users.length; i++){
              if(this.users[i].type === 'admin'){
                //console.log('hit');
                this.adminPayout = this.users[i].payout;
              }
            }*/

            /*window.setInterval(()=>{
                this.loadOrders();
                this.loadUsers();
                //console.log('mounted reload');

            }, 10000);
*/



            window.Echo.private('reassign')
              .listen('request-booster-change', (e) => {

          //    $('#reassignAlerts').append(
          //    "<div class='alert alert-warning alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Reassign Request!</h5>Reassign request from Order # "+ e.orderID +" .</div>");
              axios.get("https://app.bmsboosting.com/api/orders").then((data)=>{
                this.orders=data;
                let response = data.data.data;
                //console.log(response);
                for(let i=0; i<response.length; i++){
                  if(response[i].order_status == 'reassign'){
                  //console.log('reassign match');
                  $('#reassignAlerts').append(
                  "<div class='alert alert-warning alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Reassign Request!</h5>Reassign request from Order # "+ response[i].order_id +" .</div>");

                  }
                }
              });
              })
              .listen('drop-request', (e) => {
                $('#alert'+e.orderID).remove();
                $('#dropAlerts').append(
                "<div id='alert"+e.orderID+"' class='alert alert-warning alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Drop Request!</h5>Drop request from Order # "+ e.orderID +" .</div>");

              })
              .listen('done-request', (e) => {
                $('#done'+e.orderID).remove();
                $('#doneAlerts').append(
                "<div id='done"+e.orderID+"' class='alert alert-success alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Completion Request!</h5>Completion request from Order # "+ e.orderID +" .</div>");

              });
              let that = this;
              window.Echo.private('claims')
                .listen('order-claimed', (e) => {
                  $('#claim'+e.orderID).remove();
                  axios.get('https://app.bmsboosting.com/api/user').then((data)=>{
                    let userList = data.data.data;
                    //console.log(userList);
                    for(let j=0; j<userList.length; j++){
                      if(userList[j].type != 'client'){
                      let tempName = userList[j].name;
                      for(let k=0; k<userList[j].ongoing_orders_arr.length; k++){
                        if(userList[j].ongoing_orders_arr[k].order_id == e.orderID){
                        //console.log('match');
                          $('#claimAlerts').append(
                          "<div id='claim"+e.orderID+"' class='alert alert-primary alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Order Claim!</h5>"+tempName+" claimed Order # "+ e.orderID +" .</div>");
                          break;
                        }
                      }}
                    }
                  });


              })
             axios.get("https://app.bmsboosting.com/api/orders").then((data)=>{
                let response = data.data.data;

               //console.log(response);
                for(let i=0; i<response.length; i++){
                  if(response[i].order_status == 'reassign'){
                  $('#reassignAlerts').append(
                  "<div class='alert alert-warning alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Reassign Request!</h5>Reassign request from Order # "+ response[i].order_id +" .</div>");

                  }else if(response[i].order_status == 'verify'){
                  $('#doneAlerts').append(
                  "<div class='alert alert-success alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-check'></i> Completion Request!</h5>Completion request from Order # "+ response[i].order_id +" .</div>");

                  }
                }

                });


              }
        },
        updated(){


        },
        methods:{
          getPayout(user){
            //if(user.payout){
              return user.payout.toFixed(2);
            //}else if(user.payout === 0){
              //return 0.00;
            //}
          },
          getUser(){
            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{

              this.user = data.data;
              ////console.log(this.user);
            });
          },
          loadUsers(){
            if(this.$gate.isAdmin){


            axios.get("https://app.bmsboosting.com/api/user").then((data)=>{

            this.users=data.data.data;
            for(let i=0; i<data.data.length; i++){
              if(data.data[i].type === 'admin'){
                this.adminUser = this.users[i];
              }
            }
            });


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
            let tempObj = input;
            if(tempObj){
            if(typeof tempObj == 'string'){
              tempObj = JSON.parse(input);
            }


            let arr = tempObj.extras;
            let result = '';
            for(let i=0; i<arr.length; i++){
              result += arr[i];
              if(i != arr.length-1){
                result += " | ";
              }

            }
            return result;
            }
          },
          isDiv(order){
           //console.log(order.order_type);
            if(order.order_type.includes('Division')){
              return true;
            }else{
              return false;
            }
          },
          adminPayouts(){
            let counter = 0;
            let ordersP = ''
            axios.get("https://app.bmsboosting.com/api/orders").then((data)=>{
              ordersP = data.data.data;

            for(let i=0; i<ordersP.length; i++){
              let splitter = ordersP[i].order_type.split('');
              if(splitter[splitter.length-1]!=='.'){
                if(ordersP[i].payout_status === 'in-progress'){

                  let adjustedPrice = (ordersP[i].order_price*0.96)-0.3;
                  let bCut = Math.floor(adjustedPrice*0.7);

                  let cCut = adjustedPrice - bCut;


                  counter += parseFloat(cCut.toFixed(2));
                  ordersP[i].payout_status = 'processed';

                }
              }
            }
            axios.put('https://app.bmsboosting.com/api/payouts');
            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{
              this.userPP.fill(data.data);
              this.userPP.payout += counter;
              axios.put('api/me', this.userPP).then((data)=>{
                window.location.reload();
              })
            });
            });
            this.loadUsers();
            this.$forceUpdate();
          },
          reassignOrder(oObj){
            this.rOrder = oObj;
           //console.log(JSON.parse(oObj.order_message).summoner_name);
            this.newOrder.reset();

            let that = this;
            $.ajax({
              method: 'GET',
              url: 'https://bms-dash-node.herokuapp.com/rankings/'+JSON.parse(oObj.order_message).summoner_name+'/'+JSON.parse(oObj.order_message).region,
              success: function(data){
                let ranks = ['I4', 'I3', 'I2', 'I1', 'B4', 'B3', 'B2', 'B1', 'S4', 'S3', 'S2', 'S1', 'G4', 'G3', 'G2', 'G1', 'P4', 'P3', 'P2', 'P1', 'D4', 'D3', 'D2', 'D1', "M", 'GM', 'C'];
                let ranks2 = ['Iron 4', 'Iron 3', 'Iron 2', 'Iron 1', 'Bronze 4', 'Bronze 3', 'Bronze 2', 'Bronze 1', 'Silver 4', 'Silver 3', 'Silver 2', 'Silver 1', 'Gold 4', 'Gold 3', 'Gold 2', 'Gold 1', 'Platinum 4', 'Platinum 3', 'Platinum 2', 'Platinum 1', 'Diamond 4', 'Diamond 3', 'Diamond 2', 'Diamond 1', "Master", 'GM', 'C'];

               //console.log(data);
                let current = data.rank;
                let type = oObj.order_type.split(' - ');
                let rankSec = type[2];
                let rankSecSplit = rankSec.split(' ');
                let lpOption = '';
                that.newOrder.order_id = Date.now();

                if(oObj.order_type.includes('Solo Division') || oObj.order_type.includes('Duo Division')){
                    that.newOrder.client_id = oObj.client_id
                    let initRank= '';
                    let finRank= '';
                    if(rankSecSplit[0]!=='Master' && rankSecSplit[0]!=='Grandmaster' && rankSecSplit[0]!=='Challenger'){
                      initRank = rankSecSplit[0]+" "+rankSecSplit[1];
                    }else{
                      initRank = rankSecSplit[0];
                    }

                    if(rankSecSplit[rankSecSplit.length - 1] != 'Master' && rankSecSplit[rankSecSplit.length - 1] != 'Grandmaster' && rankSecSplit[rankSecSplit.length - 1] != 'Challenger'){
                      finRank = rankSecSplit[rankSecSplit.length - 2]+" "+rankSecSplit[rankSecSplit.length - 1];
                    }else{
                      finRank = rankSecSplit[rankSecSplit.length - 1];
                    }

                    that.newOrder.order_message = oObj.order_message;

                    that.newOrder.client_id = oObj.client_id;




                    //modal section
                    $('#addNew').modal('show')
                    $('#initOrderPrice').text('Initial Price: $ '+oObj.order_price+' USD');
                    $('#initOrderType').text('Initial Type: '+initRank+' to '+finRank);
                    $('#curOrderRank').text('Current Rank: '+JSON.parse(data).rank);
                    $('#orderSumName').text('Summoner Name: '+JSON.parse(oObj.order_message).summoner_name);

                }else{
                  //design placement/netwin reassignment process
                  let initQuantity = type[2].charAt(0);
                  //console.log(initQuantity);
                  that.newOrder.order_message = oObj.order_message;
                  that.newOrder.client_id = oObj.client_id;

                  $('#addNew').modal('show')
                  $('#initOrderPrice').text('Initial Price: $ '+oObj.order_price+' USD');
                  let newSplit = type[3].split(' ');
                  let strtRank = newSplit[0];
                  if(oObj.order_type.includes('Net')){

                    $('#initOrderType').text('Initial Type: '+initQuantity+' - '+strtRank + " Net Win(s)");
                  }else{
                    $('#initOrderType').text('Initial Type: '+initQuantity+' - '+strtRank + " Placement Game(s)");
                  }
                  $('#curOrderRank').text('Current Rank: '+JSON.parse(data).rank);
                  $('#orderSumName').text('Summoner Name: '+JSON.parse(oObj.order_message).summoner_name);
                }
              }
            });
          },
          createNewOrder(){
            let oObj = this.rOrder;
            $('#addNew').modal('hide');
            let ranks = ['I4', 'I3', 'I2', 'I1', 'B4', 'B3', 'B2', 'B1', 'S4', 'S3', 'S2', 'S1', 'G4', 'G3', 'G2', 'G1', 'P4', 'P3', 'P2', 'P1', 'D4', 'D3', 'D2', 'D1', "M", 'GM', 'C'];
            let ranks2 = ['Iron 4', 'Iron 3', 'Iron 2', 'Iron 1', 'Bronze 4', 'Bronze 3', 'Bronze 2', 'Bronze 1', 'Silver 4', 'Silver 3', 'Silver 2', 'Silver 1', 'Gold 4', 'Gold 3', 'Gold 2', 'Gold 1', 'Platinum 4', 'Platinum 3', 'Platinum 2', 'Platinum 1', 'Diamond 4', 'Diamond 3', 'Diamond 2', 'Diamond 1', "Master", 'GM', 'C'];
            let type = oObj.order_type.split(' - ');
            let rankSec = type[2];
            let rankSecSplit = rankSec.split(' ');


            this.newOrder.order_price = $('#orderPriceInput').val();

            if(type[1] === 'Solo Division' || type[1] === 'Duo Division'){
              let initRank= '';
              let finRank= '';

              if(rankSecSplit[0]!=='Master' && rankSecSplit[0]!=='Grandmaster' && rankSecSplit[0]!=='Challenger'){
                initRank = rankSecSplit[0]+" "+rankSecSplit[1];
              }else{
                initRank = rankSecSplit[0];
              }

              if(rankSecSplit[rankSecSplit.length - 1] != 'Master' && rankSecSplit[rankSecSplit.length - 1] != 'Grandmaster' && rankSecSplit[rankSecSplit.length - 1] != 'Challenger'){
                finRank = rankSecSplit[rankSecSplit.length - 2]+" "+rankSecSplit[rankSecSplit.length - 1];
              }else{
                finRank = rankSecSplit[rankSecSplit.length - 1];
              }
              let curRankInfo =  $('#curOrderRank').text();
              let curRank = curRankInfo.substring(curRankInfo.search(':')+1);
              this.newOrder.order_type = type[0]+' - '+type[1]+' - '+ curRank + ' '+  $("input[name='order_lp']:checked").val() +' LP to '+finRank+'.';
            }else{
              //net win or placement
              let curRankInfo =  $('#curOrderRank').text();
              let curRank = curRankInfo.substring(curRankInfo.search(':')+1);
              if(oObj.order_type.includes('Net')){
                this.newOrder.order_type = type[0]+' - '+type[1]+' - '+ this.new_gameNum+' - '+curRank+" Net Wins.";
              }else{
                this.newOrder.order_type = type[0]+' - '+type[1]+' - '+ this.new_gameNum+' - '+curRank+" Placement Games.";
              }
            }
            let that = this;

            //format for client order arr
            let cOrder = {order_id:'', order_type:'', order_price:'', order_message:null, order_status:'unclaimed', payout_status:'in-progress', client_id: '', booster_id:null, created_at:null, updated_at:null};

            cOrder.order_id = this.newOrder.order_id;
            cOrder.order_type = this.newOrder.order_type;
            cOrder.order_price = this.newOrder.order_price;
            cOrder.order_message = this.newOrder.order_message.message;
            cOrder.payout_status = 'completed';

            cOrder.client_id = oObj.client_id;
           //console.log(cOrder);

            let inputObj = [cOrder, this.newOrder];

            axios.put('https://app.bmsboosting.com/api/orderRe', inputObj).then(()=>{
              swal.fire(
                'Created!',
                'Your reassignment has been sent out to boosters.',
                'success'
              );

            });
            oObj.order_status = 'reassign';
            axios.put("https://app.bmsboosting.com/api/orders/"+oObj.order_id, oObj).then(()=>{

            });

          },
          checkRequested(hooman){
            let result = false;
            if(hooman.current_orders_arr){
              for(let i=0; i<hooman.current_orders_arr.length; i++){
                if(hooman.current_orders_arr[i].payout_status === 'requested'){
                  result = true;
                  break;
                }
              }
              return result;
            }else{
              return false;
            }
          },
          markReassigned(order, person){
            order.order_status = 'reassigned';
            axios.put("https://app.bmsboosting.com/api/reassigned/"+order.order_id, order).then(()=>{
              toast.fire({
                icon: 'success',
                title: 'Order Marked as Reassigned!'
              })
            });
          },
          markFinished(order, person){


            axios.put('https://app.bmsboosting.com/api/finished/'+order.order_id).then((data)=>{
              toast.fire({
                icon: 'success',
                title: 'Order Marked as Completed!'
              })
            }).catch(()=>{
              toast.fire({
                icon: 'error',
                title: 'Something went wrong'
              })
            });
            /*order.order_status = 'completed';

            let index = person.ongoing_orders_arr.indexOf(order);
            person.ongoing_orders_arr.splice(index, 1);

            person.current_orders_arr.push(order);

            person.ongoing_orders -= 1;
            person.completed_orders += 1;
            let adjustedPrice = (order.order_price*0.96)-0.3;
            let bCut = Math.floor(adjustedPrice*0.7);
            person.payout += bCut;
            axios.put("https://app.bmsboosting.com/api/orders/"+order.order_id, order).then(()=>{
              toast.fire({
                icon: 'success',
                title: 'Order Marked as Completed'
              })
            }).catch(()=>{
              toast.fire({
                icon: 'error',
                title: 'Something went wrong'
              })
            });

            axios.put("https://app.bmsboosting.com/api/user/"+person.id, person).then(()=>{
             //console.log("User Update Success");
            }).catch(()=>{
             //console.log("User Update Failed");

            });
            */
          },
          loadOrders(){
            if(this.$gate.isAdmin){


            axios.get("https://app.bmsboosting.com/api/orders").then((data)=>{
              this.orders=data;

            });

            }
          },
          checkDropReq(user){
            for(let i=0; i<user.ongoing_orders_arr.length; i++){
            //console.log(user.ongoing_orders_arr[i].order_status+" "+user.name);
              if(user.ongoing_orders_arr[i].order_status == 'request_drop'){
                $('#alert'+user.ongoing_orders_arr[i].order_id).remove();
                $('#dropAlerts').append(
                "<div id='alert"+user.ongoing_orders_arr[i].order_id+"' class='alert alert-warning alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Drop Request!</h5>Drop request from Order # "+ user.ongoing_orders_arr[i].order_id +" .</div>");

              }
            }
          },
          checkDoneReq(user){
            for(let i=0; i<user.ongoing_orders_arr.length; i++){
            //console.log(user.ongoing_orders_arr[i].order_status+" "+user.name);
              if(user.ongoing_orders_arr[i].order_status == 'verify'){
             //console.log('alnsfklbadslg')
                $('#done'+user.ongoing_orders_arr[i].order_id).remove();
                $('#doneAlerts').append(
                "<div id='done"+user.ongoing_orders_arr[i].order_id+"' class='alert alert-success alert-dismissible container-fluid'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h5><i class='icon fas fa-exclamation-triangle'></i> Completion Request!</h5>Completion request from Order # "+ user.ongoing_orders_arr[i].order_id +" .</div>");

              }
            }
          },
          payoutAll(person){
          //console.log(process);
          //console.log(process.env);
          //console.log(process.env.MIX_PAYPAL_AUTHORIZATION);
            axios.get('https://app.bmsboosting.com/api/ppGet').then((data)=>{
              console.log(data);

            if(person.payout > 0){
              axios.post('https://app.bmsboosting.com/api/stripe-payout', {
                email: person.email,
                amount: (person.payout - (person.payout * 0.02)).toFixed(2)
              }).then((data)=>{
                if(data.data!='false'){
                  let orderArr = this.orders.data.data;
                  let userOrderArr = [];

                  axios.put('https://app.bmsboosting.com/api/payouts/'+person.id).then((data)=>{
                    toast.fire({
                      icon: 'success',
                      title: 'User Payout Complete'
                    })
                  });
                }else{
                  swal.fire(
                    'Worker Setup Error!',
                    'Your payout to ' + person.email + " has not been executed, they haven't setup their payout account",
                    'error'
                  )
                }
                
              });
              

              
            }else{
              swal.fire(
                'Payout Amount Error!',
                'Your payout to ' + person.email + " has not been executed, they have an insufficient balance",
                'error'
              )
            }
            });
          },
          adminWithdraw(){
            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{
              this.userPP.fill(data.data);
              this.userPP.payout = 0;
              axios.put('api/me', this.userPP).then((data)=>{
                window.location.reload();
              })
            });
          },
          getResults(page = 1) {
          			axios.get('api/orders?page=' + page)
          				.then(response => {
          					this.orders = response.data;
          				});
          		},
        },
        created(){
          if(this.$gate.isAdmin()){
            this.loadUsers();
            this.getUser();
            this.loadOrders();

          }

        }
    }
</script>
<style>
</style>
