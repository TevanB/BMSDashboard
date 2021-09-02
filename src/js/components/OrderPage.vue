<template>
  <div id="hoa" v-if="$gate.hasOrderAccess($route.params.order_id)">

    <div class="container">

    <div class="jumbotron border border-dark mt-4">
      <h1 class="display-4 text-center">{{form.order_type}}</h1>
      <h2 class="text-center" v-if="$gate.isClient()">Current Status: {{form.order_status | upText}}</h2>
      <h2 class="text-center" v-if="$gate.isAdmin()">Current Status: {{form.order_status | upText}}</h2>
      <h2 class="text-center" v-if="$gate.isBoosterOrCoach() && form.order_status=='reassign'">Current Status: Claimed</h2>
      <h2 class="text-center" v-else-if="$gate.isBoosterOrCoach() && form.order_status=='reassigned'">Current Status: Claimed</h2>
      <h2 class="text-center" v-else-if="$gate.isBoosterOrCoach()">Current Status: {{form.order_status | upText}}</h2>

      <p class="lead text-center">Order #{{form.order_id}}</p>
      <hr class="my-4">
      <p class="text-center" v-if="form.order_status=='verify'">This order has been marked as completed by the booster, awaiting approval from administration.</p>
      <p class="text-center" v-if="form.order_status=='unclaimed'">This order has been processed and sent out to our boosters, please be patient as it gets claimed.</p>
      <p class="text-center" v-if="form.order_status=='claimed'">This order has been assigned, good luck and have fun!</p>
      <p class="text-center" v-if="form.order_status=='completed'">This order has been completed, thanks for choosing BMS Boosting!</p>
      <p class="text-center" v-if="form.order_status=='paused'">This order has been paused, the order will resume when it gets un-paused by the client.</p>
      <p class="text-center" v-if="form.order_status=='reassigned' && $gate.isClient()">You have requested a new booster. The current booster cannot see this status, you should continue working with this booster until we find a replacement.</p>
      <p class="text-center" v-if="form.order_status=='reassign' && $gate.isBoosterOrCoach()">This order has been assigned, good luck and have fun!</p>
      <p class="text-center" v-if="form.order_status=='reassigned' && $gate.isBoosterOrCoach()">This order has been assigned, good luck and have fun!</p>
      <p class="text-center" v-if="form.order_status=='reassign' && $gate.isClient()">You have requested a new booster. The current booster cannot see this status, you should continue working with this booster until we find a replacement.</p>

    </div>

<div>
      <div class="row justify-content-center mt-5" v-if="form.order_type.includes('Net') || form.order_type.includes('Place')">
       <div class="container-fluid">
          <div class="row">
             <div class="col-7 h-75">
                <div class="card">
                   <div class="card-header bg-dark">
                      <h5 class="card-title">Order Chat</h5>
                   </div>
                   <div class="card-body">

                      <div class="row">
                         <!---->
                         <div class="col">


                         <order-chat :order_id="{order_id}"></order-chat>
                         </div>

                         <!---->
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-5 card-group mb-3">
                <div class="card">
                   <div class="card-header bg-dark">
                      <h5 class="card-title">Order Details</h5>
                   </div>
                   <div class="card-body">

                      <div class="row">
                         <!---->

                         <div class="col">
                            <div class="row justify-content-center">
                               <p class="h5"> Current Rank </p>
                            </div>
                            <div class="row justify-content-center"><img id="currentRankIMG" src="https://app.bmsboosting.com/img/unranked.png"></div>
                            <div class="row justify-content-center">
                               <p id="fRC" class="h5">Unranked</p>
                            </div>
                         </div>
                         <!---->
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="container-fluid">
          <div class="row">



                   <div class="col">
                      <div class="card">
                         <div class="card-header bg-dark">
                            <h5 class="card-title">Order Options</h5>
                         </div>
                         <div class="card-body">
                            <!---->
                            <div v-if="$gate.isWorkerOrAdmin()">
                            <p class="card-text">Order options that are sent directly to management. Penalties will be imposed on false reports.</p>

                                  <a href="" class="btn btn-primary mt-1 mb-1" @click.prevent="requestComplete()">Mark Completed</a>

                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle mt-1 mb-1" data-toggle="dropdown">
                                       Extra
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="" @click.prevent="requestDrop()">Request Drop Order</a>
                                    </div>
                                  </div>


                            </div>

                            <div v-if="$gate.isClient()">
                            <p class="card-text">Use order options with care. Abusing them could lead to financial penalties.</p>

                                <div v-if="this.form.order_status != 'paused'">
                                  <a href="" class="btn btn-primary mt-1 mb-1" @click.prevent="pauseOrder()">Pause</a>
                                  <a href="" class="btn btn-primary mt-1 mb-1" data-toggle="modal" data-target="#tipModal">Tip Booster</a>

                                  <!-- Modal -->
                                  <div class="modal fade" id="tipModal" tabindex="-1" role="dialog" aria-labelledby="tipModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Tip Amount</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="form-group">
                                          <label for="tipAmount">Tip Amount</label>
                                          <input type="range" class="custom-range" min="1" max="100" step="1" value='10' v-model="tipValue" id="tipAmount">
                                          <small id="tipHelp" class="form-text text-muted">We give 100% of tips to boosters.</small>
                                          <p class="h3" id="currentTipAmount">${{tipValue}} USD</p>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                          <div class="col" id="paypalButtons">

                                          </div>
                                          </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                       Extra
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="" @click.prevent="requestBoosterChange()" >Request Booster Change</a>
                                    </div>
                                  </div>

                                </div>

                                <div v-if="this.form.order_status == 'paused'">
                                  <a href="" class="btn btn-primary" @click.prevent="pauseOrder()">Resume</a>

                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                       Extra
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="#">Request Booster Change</a>
                                    </div>
                                  </div>

                                </div>
                            </div>

                          </div>
                         </div>
                      </div>
                   </div>

                      <div class="col mb-3 card-group">
                         <div class="card">
                            <div class="card-header bg-dark">
                               <h5 class="card-title">Order Information</h5>
                            </div>
                            <div class="card-body" v-if="this.$gate.isClient()">
                              <div>
                               <div class="row">
                                  <div class="col">
                                     <p id="assignedBooster" class="font-weight-bold mt-3">Assigned Booster: {{boosterName}}</p>
                                  </div>
                               </div>
                               </div>

                            </div>
                            <div class="card-body" v-if="this.$gate.isWorkerOrAdmin()">



                                 <div v-if="orderInfo.type=='duo'">
                                   <div class="row">
                                    <div class="col">
                                      <p class="font-weight-bold">Order Summoner Name: </p>
                                      {{orderInfo.summoner_name}}

                                    </div>
                                    <div class="col">
                                      <p class="font-weight-bold">Order Message: </p>
                                      {{orderInfo.message}}
                                      <p class="font-weight-bold mt-3">Order Extras: </p>
                                      <div v-for="extra in orderInfo.extras">
                                        {{extra}} <br>
                                      </div>
                                    </div>
                                  </div>

</div>

                                   <div v-else-if="orderInfo.type=='solo'">
                                     <div class="row">
                                       <div class="col">
                                         <p class="font-weight-bold">Order Username: </p>
                                         {{orderInfo.username}}
                                         <p class="font-weight-bold mt-3">Order Password: </p>
                                         {{orderInfo.password}}
                                       </div>
                                       <div class="col">
                                       <p class="font-weight-bold">Order Message: </p>
                                       {{orderInfo.message}}
                                       <p class="font-weight-bold mt-3">Order Extras: </p>
                                       <div v-for="extra in orderInfo.extras">
                                        {{extra}} <br>
                                       </div>
                                       </div>
                                     </div>
                                  </div>

                            </div>
                         </div>
                      </div>

                <!---->
                <div>


                </div>

          </div>
       </div>
    </div>
</div>
<div>
        <div class="row justify-content-center mt-5" v-if="form.order_type.includes('Division')">

          <div class="container-fluid">

            <div class="row">

              <div class="col h-75">

                <div class="card">
                  <div class="card-header bg-dark">
                    <h5 class="card-title">Order Details</h5>

                  </div>
                  <div class="card-body">

                    <h2 class="text-center"> Current Progress</h2>
                    <div class="progress border border-dark mb-5">
                      <div id="orderProgressAmt" class="progress-bar progress-bar-striped progress-bar-animated " style="width: 0%;"></div>
                    </div>
                    <div class="row">

                      <div class="col" v-if="form.order_type.includes('Division')">
                        <div class="row justify-content-center">
                          <p class="h5"> Start </p>
                        </div>
                        <div class="row justify-content-center">

                          <img src="https://app.bmsboosting.com/img/bronze.png" v-if="rankStart == 'Bronze'"></img>
                          <img src="https://app.bmsboosting.com/img/iron.png" v-if="rankStart == 'Iron'"></img>
                          <img src="https://app.bmsboosting.com/img/silver.png" v-if="rankStart == 'Silver'"></img>
                          <img src="https://app.bmsboosting.com/img/gold.png" v-if="rankStart == 'Gold'"></img>
                          <img src="https://app.bmsboosting.com/img/platinum.png" v-if="rankStart == 'Platinum'"></img>
                          <img src="https://app.bmsboosting.com/img/diamond.png" v-if="rankStart == 'Diamond'"></img>
                          <img src="https://app.bmsboosting.com/img/unranked.png" v-if="rankStart == 'Unranked'"></img>

                          <img src="https://app.bmsboosting.com/img/master.png" v-if="rankStart == 'Master'"></img>
                          <img src="https://app.bmsboosting.com/img/grandmaster.png" v-if="rankStart == 'Grandmaster'"></img>
                          <img src="https://app.bmsboosting.com/img/challenger.png" v-if="rankStart == 'Challenger'"></img>
                        </div>
                        <div class="row justify-content-center">
                          <p class="h5">{{fullRankStart}}</p>
                        </div>
                      </div>

                      <div class="col">
                        <div class="row justify-content-center">
                          <p class="h5"> Current </p>
                        </div>
                        <div class="row justify-content-center">

                          <img id="currentRankIMG"></img>


                        </div>
                        <div class="row justify-content-center">
                          <p class="h5" id="fRC"></p>
                        </div>
                      </div>

                      <div class="col" v-if="form.order_type.includes('Division')">
                        <div class="row justify-content-center">
                          <p class="h5"> End </p>
                        </div>
                        <div class="row justify-content-center">


                          <img src="https://app.bmsboosting.com/img/bronze.png" v-if="rankEnd == 'Bronze'"></img>
                          <img src="https://app.bmsboosting.com/img/iron.png" v-if="rankEnd == 'Iron'"></img>
                          <img src="https://app.bmsboosting.com/img/silver.png" v-if="rankEnd == 'Silver'"></img>
                          <img src="https://app.bmsboosting.com/img/gold.png" v-if="rankEnd == 'Gold'"></img>
                          <img src="https://app.bmsboosting.com/img/platinum.png" v-if="rankEnd == 'Platinum'"></img>
                          <img src="https://app.bmsboosting.com/img/diamond.png" v-if="rankEnd == 'Diamond'"></img>
                          <img src="https://app.bmsboosting.com/img/master.png" v-if="rankEnd == 'Master'"></img>
                          <img src="https://app.bmsboosting.com/img/grandmaster.png" v-if="rankEnd == 'Grandmaster'"></img>
                          <img src="https://app.bmsboosting.com/img/challenger.png" v-if="rankEnd == 'Challenger'"></img>
                          <img src="https://app.bmsboosting.com/img/unranked.png" v-if="rankEnd == 'Unranked'"></img>

                        </div>
                        <div class="row justify-content-center">
                          <p class="h5">{{fullRankEnd}}</p>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>

            </div>

          </div>

          <div class="container-fluid">
            <div class="row">
              <div class="col-6">

                <div class="card">
                  <div class="card-header bg-dark">
                    <h5 class="card-title">Order Chat</h5>

                  </div>
                  <div class="card-body">
                  <order-chat :order_id="{order_id}"></order-chat>
                  </div>
                </div>

              </div>

              <div class="col-6">

                <div class="row">
                  <div class="col">
                    <div class="card">
                    <div class="card-header bg-dark">
                      <h5 class="card-title">Order Options</h5>
                    </div>
                      <div class="card-body">



                        <div v-if="$gate.isWorkerOrAdmin()">
                        <p class="card-text">Order options that are sent directly to management. Penalties will be imposed on false reports.</p>

                              <a href="" class="btn btn-primary mt-1 mb-1" @click.prevent="requestComplete()">Mark Completed</a>

                              <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle mt-1 mb-1" data-toggle="dropdown">
                                   Extra
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="" @click.prevent="requestDrop()">Request Drop Order</a>
                                </div>
                              </div>


                        </div>

                        <div v-if="$gate.isClient()">
                        <p class="card-text">Use order options with care. Abusing them could lead to financial penalties.</p>

                            <div v-if="this.form.order_status != 'paused'">
                              <a href="" class="btn btn-primary mt-1 mb-1" @click.prevent="pauseOrder()">Pause</a>
                              <a href="" class="btn btn-primary mt-1 mb-1" data-toggle="modal" data-target="#tipModal">Tip Booster</a>

                              <!-- Modal -->
                              <div class="modal fade" id="tipModal" tabindex="-1" role="dialog" aria-labelledby="tipModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Tip Amount</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group">
                                      <label for="tipAmount">Tip Amount</label>
                                      <input type="range" class="custom-range" min="1" max="100" step="1" value='10' v-model="tipValue" id="tipAmount">
                                      <small id="tipHelp" class="form-text text-muted">We give 100% of tips to boosters.</small>
                                      <p class="h3" id="currentTipAmount">${{tipValue}} USD</p>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                      <div class="col" id="paypalButtons">

                                      </div>
                                      </div>
                                  </div>
                                </div>
                              </div>

                              <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                   Extra
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="" @click.prevent="requestBoosterChange()" >Request Booster Change</a>
                                </div>
                              </div>

                            </div>

                            <div v-if="this.form.order_status == 'paused'">
                              <a href="" class="btn btn-primary" @click.prevent="pauseOrder()">Resume</a>

                              <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                   Extra
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="#">Request Booster Change</a>
                                </div>
                              </div>

                            </div>
                        </div>

                      </div>
                    </div>
                    </div>
                </div>

                <div v-if="$gate.isWorkerOrAdmin()">

                  <div class="row">
                    <div class="col">
                      <div class="card">
                        <div class="card-header bg-dark">

                          <h5 class="card-title">Order Information</h5>
                        </div>


                        <div class="card-body" v-if="orderInfo.type=='solo'">
                          <div class="row">
                            <div class="col">
                            <p class="font-weight-bold">Order Username: </p> {{orderInfo.username}}
                            <p class="font-weight-bold mt-3">Order Password: </p>
                            {{orderInfo.password}}
                            </div>
                            <div class="col">
                            <p class="font-weight-bold">Order Message: </p>
                            {{orderInfo.message}}
                            <p class="font-weight-bold mt-3">Order Extras: </p>
                              <div v-for="extra in orderInfo.extras">
                                {{extra}} <br>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card-body" v-if="orderInfo.type=='duo'">
                          <div class="row">
                            <div class="col">
                              <p class="card-text font-weight-bold">Client Summoner Name: </p>
                              {{orderInfo.summoner_name}}
                              <p class="card-text font-weight-bold mt-3">Order Message: </p>
                              {{orderInfo.message}}
                            </div>
                            <div class="col">
                              <p class="font-weight-bold">Order Extras: </p>
                              <div v-for="extra in orderInfo.extras">
                              {{extra}} <br>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                  </div>
                  </div>
                </div>
                <div v-if="$gate.isClient()">


                  <div class="row">
                    <div class="col">
                      <div class="card">
                        <div class="card-header bg-dark">

                          <h5 class="card-title">Order Information</h5>
                        </div>


                        <div class="card-body" v-if="orderInfo.type==='solo'">
                          <div class="row">
                            <div class="col">
                            <p id="assignedBooster" class="font-weight-bold mt-3">Assigned Booster: {{boosterName}}</p>

                            </div>

                          </div>
                        </div>
                        <div class="card-body" v-if="orderInfo.type==='duo'">
                          <div class="row">
                            <div class="col">
                            <p id="assignedBooster" class="font-weight-bold mt-3">Assigned Booster: {{boosterName}}</p>

                            </div>

                          </div>
                        </div>

                      </div>

                  </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          </div>

          </div>
          </div>

          </div>

</div>
<div v-else-if="!$gate.hasOrderAccess($route.params.order_id)">
  <not-found></not-found>
</div>





</template>


<script>

import Form from 'vform';
import HasError from 'vform';
import json from './output.json';
    export default {

        data(){

         return{
         myJSON: json,
         tipValue : 10,
           orders: {},
           rankInfo:{},
           username:'',
           summName: '',
           boosterName:'',
           rankStart: '',
           fullRankStart:'',
           rankEnd: '',
           fullRankEnd:'',
           rankCurrent: '',
           fullRankCurrent: '',
           idInfo:[],
           order_id: this.$route.params.order_id,
           booster_id:'',
           form: new Form({
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
           orderInfo: new Form({
              username:'',
              password:'',
              email:'',
              summoner_name:'',
              type:'',
              discord:'',
              message:'',
              extras:'',
              starting_lp:'',
              lpg:'',
              region:'',



           }),
           }
         },

        mounted() {
            //console.log('Component mounted.')
            let bID = this.order_id;
            let bbID = this.tipValue;
            //console.log(this.tipValue);

            $("#boosterTipInput").change(function() {
          	    $("#currentTipAmount").val($('#boosterTipInput').val());
          	});

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
        updated(){
          this.booster_id = this.form.booster_id;

          if(this.$gate.isClient){
            let bID = this.booster_id;
            let bbID = this.tipValue;
            $('#paypalButtons').empty();
            if(this.$gate.isClient()){
            window.paypal.Buttons({
              createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                  purchase_units: [{
                    amount: {
                      value: bbID,
                    },
                    description: "Tip for Booster " + bID
                  }]
                });
              },
              onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                  // This function shows a transaction success message to your buyer.
                  swal.fire(
                    'Tip Sent',
                    'Your transaction was successful.',
                    'success'
                  )
                  swal.fire({
                  title: 'Tip Sent',
                  text: 'Your transaction was successful.',
                  icon: 'success',
                  confirmButtonText: 'Continue'
                  }).then((result)=>{
                    if(result.value){
                      $('#tipModal').modal('toggle');
                    }
                  })
                });
              }
            }).render('#paypalButtons');
            }
          }

        },
        watch:{
          orders: function(val){
            //console.log('change');
            axios.get('https://app.bmsboosting.com/api/users/'+this.form.booster_id).then((data)=>{
              ////console.log(data);
              this.boosterName = data.data;
            });
          }
        },
        created(){

          if(this.$gate.hasOrderAccess(this.$route.params.order_id)){


            this.getUser();

            axios.get("https://app.bmsboosting.com/api/orders/"+this.order_id).then((data)=>{

              ////console.log(data.data.data);
              this.form.fill(data.data.data);
              //if(!this.$gate.isWorkerOrAdmin){
                axios.get('https://app.bmsboosting.com/api/users/'+this.form.booster_id).then((data)=>{
                  //console.log(data);
                  this.boosterName = data.data;
                });
              //}
              this.orders = data.data.data;
              let tempObj = JSON.parse(data.data.data.order_message).type
              this.orderInfo.fill(JSON.parse(data.data.data.order_message));
              //console.log(this.orderInfo);
              this.username = tempObj.username;
              this.summName = tempObj.summoner_name;
              this.parseOrderInfo(this.orders.order_type);
              this.getRankInfo(this.orderInfo.summoner_name, this.orderInfo.region);
              //console.log(this.rankStart);

            });
            this.getRankInfo(this.orderInfo.summoner_name, this.orderInfo.region);

            window.setInterval(()=>{
              if(this.form.order_status != 'unclaimed'){
                this.getOrder();
              }

            }, 15000);
            window.setInterval(()=>{
              this.getRankInfo(this.orderInfo.summoner_name, this.orderInfo.region);
            }, 180000);

          }
        },
        methods:{
        scrollToEnd() {
          var container = this.$el.querySelector("#scroller");
          container.scrollTop = container.scrollHeight;
        },
        refreshPage(){
          window.location.reload();
        },
        getterRankInfo(){
          return this.rankCurrent;
        },
        accessCheck(){
          let that = this;
          axios.get('https://app.bmsboosting.com/api/orderinfo/'+this.order_id).then((data)=>{
              that.idInfo = data.data;
              if(that.$gate.hasOrderAccess(that.idInfo)){
                return true;
              }else{
                return false;
              }
          }).catch(()=>{
            return false;
          });
        },

        orderProgressSetter(currRank){
          let ranks2 = ['Iron 4', 'Iron 3', 'Iron 2', 'Iron 1', 'Bronze 4', 'Bronze 3', 'Bronze 2', 'Bronze 1', 'Silver 4', 'Silver 3', 'Silver 2', 'Silver 1', 'Gold 4', 'Gold 3', 'Gold 2', 'Gold 1', 'Platinum 4', 'Platinum 3', 'Platinum 2', 'Platinum 1', 'Diamond 4', 'Diamond 3', 'Diamond 2', 'Diamond 1', "Master", 'GM', 'C'];
          let startIndex = ranks2.indexOf(this.fullRankStart);
          let endIndex = ranks2.indexOf(this.fullRankEnd);
          let currIndex = ranks2.indexOf(currRank);
          //console.log(startIndex+" "+endIndex+" "+currIndex);
          let result = (((currIndex - startIndex)/(endIndex - startIndex))*100).toFixed(2);
          //console.log(result);
          $('#orderProgressAmt').attr('style', 'width:'+result+'%');
        },
        getRankInfo(name, region){




//          let PORT = process.env.MIX_PORT || 3000;


          let boom = '';
          let fullBoom='';
          let thisRef = this;
          $.ajax({
            method: 'GET',
            url: 'https://bms-dash-node.herokuapp.com/rankings/'+name+'/'+region,
            success: function(data){
            let ranks2 = ['Iron 4', 'Iron 3', 'Iron 2', 'Iron 1', 'Bronze 4', 'Bronze 3', 'Bronze 2', 'Bronze 1', 'Silver 4', 'Silver 3', 'Silver 2', 'Silver 1', 'Gold 4', 'Gold 3', 'Gold 2', 'Gold 1', 'Platinum 4', 'Platinum 3', 'Platinum 2', 'Platinum 1', 'Diamond 4', 'Diamond 3', 'Diamond 2', 'Diamond 1', "Master", 'GM', 'C'];

              this.rankInfo = data;
              let info = JSON.parse(data).rank;
              $('#fRC').text(info);
              this.fullRankCurrent = info;
              fullBoom = info;
              if(info != 'Unranked' && info != 'Master' && info != 'Grandmaster' && info != 'Challenger'){
                let splitter = info.split(' ');
                this.rankCurrent = splitter[0];
                boom = splitter[0];
                if(boom === 'Bronze'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/bronze.png");
                }else if(boom === 'Iron'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/iron.png");
                }else if(boom === 'Silver'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/silver.png");
                }else if(boom === 'Gold'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/gold.png");
                }else if(boom === 'Platinum'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/platinum.png");
                }else if(boom === 'Diamond'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/diamond.png");
                }

              }else{
                this.rankCurrent = JSON.parse(data).rank;
                boom = JSON.parse(data).rank;
                //console.log(this.rankCurrent);
                if(boom === 'Unranked'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/unranked.png");
                }else if(boom === 'Master'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/master.png");

                }else if(boom === 'Grandmaster'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/grandmaster.png");

                }else if(boom === 'Challenger'){
                  $('#currentRankIMG').attr("src", "https://app.bmsboosting.com/img/challenger.png");

                }
              }
              if((ranks2.indexOf(this.fullRankCurrent) >= ranks2.indexOf(this.fullRankEnd)) &&( this.fullRankEnd)){
                //console.log(rank2.indexOf(this.fullRankCurrent) + " " + ranks2.indexOf(this.fullRankEnd));
                thisRef.requestComplete();
              }
              thisRef.orderProgressSetter(fullBoom);

            }

          });

        },
        parseOrderInfo(input){
          let sep = input.split(' - ');
          let relevantInfo = sep[2];
          let ranks = ['Iron', 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Master', 'Grandmaster', 'Challenger'];
          let startDiv = '';
          let endDiv = '';
          let gameDiv = '';
          if(sep[1]==='Solo Division' || sep[1] === 'Duo Division'){
            let temp = relevantInfo.split(' ');
            let skipper = false;
            startDiv = temp[0];

            if(startDiv !== 'Master' && startDiv !== 'Grandmaster' && startDiv !== 'Challenger'){
              this.fullRankStart = startDiv + ' ' + temp[1]
            }else{
              this.fullRankStart = startDiv;
            }


            for(let i=1; i<temp.length; i++){
              for(let j=0; j<ranks.length; j++){
                if(temp[i] === ranks[j]){
                  endDiv = temp[i];

                  if(endDiv !== 'Master' && endDiv !== 'Grandmaster' && endDiv !== 'Challenger'){
                    this.fullRankEnd = endDiv + ' ' + temp[i+1]
                  }else{
                    this.fullRankEnd = endDiv;
                  }

                  skipper = true;
                  break;
                }
                if(skipper){
                  break;
                }
              }
            }

            this.rankStart = startDiv;
            this.rankEnd = endDiv;

          }else if(sep[1] === 'Solo Net Wins' || sep[1] === 'Duo Net Wins'){
            let temp = relevantInfo.split(' ');
            let skipper = false;

            for(let i=0; i<temp.length; i++){
              for(let j=0; j<ranks.length; j++){
                if(temp[i] === ranks[j]){
                  gameDiv = temp[i];
                  break;
                }

              }
              if(skipper){
                break;
              }
            }

          }else if(sep[1] === 'Solo Placement' || sep[1] === 'Duo Placement'){
            let temp = relevantInfo.split(' ');
            let skipper = false;

            for(let i=0; i<temp.length; i++){
              for(let j=0; j<ranks.length; j++){
                if(temp[i] === ranks[j]){
                  gameDiv = temp[i];
                  break;
                }

              }
              if(skipper){
                break;
              }
            }
          }
        },
        requestComplete(){

          axios.put('https://app.bmsboosting.com/api/requestComplete/'+this.form.order_id).then(()=>{
            swal.fire(
              'Request Submitted',
              'Management will now inspect completion, order remains active until approved.',
              'success'
            )
          }).catch(()=>{
            swal.fire(
              'Error',
              'Something went wrong.',
              'error'
            )
          });
          /*this.form.order_status = 'verify';
          axios.put("https://app.bmsboosting.com/api/order/"+this.form.order_id, this.form).then(()=>{
            swal.fire(
              'Request Submitted',
              'Management will now inspect completion, order remains active until approved.',
              'success'
            )
          }).catch(()=>{
            swal.fire(
              'Error',
              'Something went wrong.',
              'error'
            )
          });

          //let index = -1;
          for(let i =0; i<this.user.ongoing_orders_arr.length; i++){
            //console.log(this.user.ongoing_orders_arr[i]);
            if(this.user.ongoing_orders_arr[i].order_id == this.order_id){
              this.user.ongoing_orders_arr[i].order_status = 'verfiy';

              break;
            }
            //console.log(i);
          }


          axios.put("https://app.bmsboosting.com/api/me", this.user).then(()=>{
            //console.log("User Update Success");
          }).catch(()=>{
            //console.log("User Update Failed");

          });*/


        },
        requestDrop(){
          if(this.$gate.isWorkerOrAdmin){
            axios.put('https://app.bmsboosting.com/api/drop/'+this.form.order_id).then((data)=>{
              swal.fire(
                'Request Submitted',
                'Management will approve of the drop, please continue the order until drop request is approved.',
                'success'
              )
            }).catch(()=>{
              swal.fire(
                'Error',
                'There was a problem with your request, please contact management if this problem persists.',
                'error'
              )
            })
          }
        },
        orderExtraFormat(input){
        let arr = input;
        let result = '';
        for(let i=0; i<arr.length; i++){
          result += arr[i];
          if(i != arr.length-1){
            result += " \n ";
          }

        }
        return result;
        },
          getUser(){

            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{

              this.user.fill(data.data);


            });

          },
          requestBoosterChange(){
          ////console.log(this.orders.order_status);/
          if(this.orders.order_status != 'reassign' && this.orders.order_status != 'reassigned'){
            swal.fire({
              title : 'Request Verification',
              text : 'Booster change requests are taken seriously. Please make sure all of the following conditions are met before requesting.',
              icon : 'info',
              showCancelButton: true,
              confirmButtonText: 'Send Request',
              cancelButtonText: 'Cancel'
              }
            ).then((result)=>{
              if(result.value){

                axios.put('https://app.bmsboosting.com/api/reassign/'+this.order_id).then(()=>{
                  swal.fire(
                    'Request Sent',
                    'Your request to change boosters has been sent to management for approval.',
                    'success'
                  )
                })



              }
            });
            }else{
              swal.fire({
                title : 'Error',
                text : 'Order reassignment request already sent.',
                icon : 'error',

                }
              )
            }
          },
          getOrder(){
            axios.get("https://app.bmsboosting.com/api/orders/"+this.order_id).then((data)=>{
              //console.log(data.data.data.order_message);
              this.form.fill(data.data.data);
              this.orders = data.data.data;
              let tempObj = JSON.parse(data.data.data.order_message).type
              this.orderInfo.fill(JSON.parse(data.data.data.order_message));
              this.username = tempObj.username;
              this.summName = tempObj.summoner_name;
            });
          },
          pauseOrder(){

          if(this.form.order_status == 'unclaimed'){
              swal.fire(
                'Pause Error',
                'You cannot pause while the order is unclaimed.',
                'error'
              ).then((result)=>{
                if(result.value){
                  //this.refreshPage();

                }
              });
          }else{


            axios.put("https://app.bmsboosting.com/api/pause/"+this.form.order_id, this.form).then((data)=>{
              //console.log(data);
              swal.fire(
                'Order Pause Toggled',
                'The pause status of this order has been toggled.',
                'success'
              ).then((result)=>{
                if(result.value){
                  //this.refreshPage();

                }
              });
            });

            }
          }





        }
    }
</script>
