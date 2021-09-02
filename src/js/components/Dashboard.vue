<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="jumbotron container-fluid">
            <div class="container-fluid">
              <h1 class="display-4">Welcome to the BMS Dashboard</h1>
              <p class="lead">You can use this interactive dashboard to manage your orders. </p>
              <hr class="my-4">
              <p>To continue, please navigate through the tabs on the left or look below.</p>
              <p>To return to the main homepage, click on the "BMS Home" tab.</p>
            </div>
          </div>
        </div>

        <div class="container-fluid" v-if="$gate.isAdmin()">
        <div class="row">
          <div class="col">

            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{getCompletedOrders()}}</h3>

                <p>Completed Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="https://app.bmsboosting.com/payments" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>

          </div>

          <div class="col">

            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{getUnclaimedOrders()}}</h3>

                <p>Unclaimed Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-briefcase"></i>
              </div>
              <a href="https://app.bmsboosting.com/payments" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>

          </div>

          <div class="col">

            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{getOngoingOrders()}}</h3>

                <p>Ongoing Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-hammer"></i>
              </div>
              <a href="https://app.bmsboosting.com/payments" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>

          </div>

        </div>
        <div class="row">

          <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Admin Payout</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <h3>${{getPayout(user)}} USD</h3>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="col">

            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Grand Summary</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <h3> Total Order Value: ${{getTotalOrderValue()}} USD <br></h3>
                  <h3> Total Profit Value: ${{getTotalProfitValue()}} USD <br></h3>
                </div>
                <!-- /.card-body -->
              </div>


            </div>
        </div>



        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Performance Charts</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-sm">
                  <h2 class="display-4 text-center">Order Overview</h2>
                  <order-chart></order-chart>
                </div>
                <div class="col-sm">
                  <h2 class="display-4 text-center">User Registration</h2>
                  <user-chart></user-chart>
                </div>
              </div>
            </div>
              </div>
              <!-- /.card-body -->
            </div>

        <div class="container-fluid" v-if="$gate.isBoosterOrCoach()">
          <div class="card">
            <div class="card-header bg-primary">
              Current Stats
            </div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col">
                  <div class="card border border-primary mb-3 ml-5" style="max-width: 18rem;">
                    <div class="card-body text-dark">
                      <h4 class="card-featured text-center">You Have Completed</h4><br>
                      <h3 class="card-featured text-center text-primary">{{user.completed_orders}}</h3><br>
                      <h4 class="text-center">Order(s)</h4>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="card border border-primary mb-3" style="max-width: 18rem;">
                    <div class="card-body text-dark">
                      <h4 class="card-featured text-center">You Currently Have</h4><br>
                      <h3 class="card-featured text-center text-primary">{{user.ongoing_orders}}</h3><br>
                      <h4 class="text-center">Order(s)</h4>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="card border border-primary mb-3" style="max-width: 18rem;">
                    <div class="card-body text-dark">
                      <h4 class="card-featured text-center">Your Current Payout Is</h4><br>
                      <h3 class="card-featured text-center text-primary">${{user.payout}}</h3><br>
                      <h4 class="text-center">USD</h4>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid" v-if="$gate.isClient()">
          <div class="row">
            <div class="col">
            <h2 class="mt-2 mb-5 ml-4">Order Stages</h2>
            <div class="timeline">
              <!-- Timeline time label -->

              <div>
              <!-- Before each timeline item corresponds to one icon on the left scale -->
                <i class="fas fa-money-bill-wave-alt bg-blue"></i>
                <!-- Timeline item -->
                <div class="timeline-item">
                <!-- Time -->
                  <!-- Header. Optional -->
                  <h3 class="timeline-header"><a href="#">Order Processed</a></h3>
                  <!-- Body -->
                  <div class="timeline-body">
                    Your order has been processed and has been sent out to our boosters.<br>
                    At this stage you can check out your preliminary order management page, your order's status will be 'Unclaimed'.<br>
                    You will get an update by email and through our dashboard when a booster claims your order.<br>
                  </div>

                </div>

              </div>


              <div>
                  <i class="fas fa-user-check bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Order Claimed</a></h3>
                    <div class="timeline-body">
                      Your order has been claimed by a booster.
                      Please visit your order management page under the "My Orders" tab to track your order and chat with your booster.<br>
                      If you'd like to play on your account, you can use the Pause feature. When you are done please Resume the order so we can complete your order.<br>
                      There are rules to moderate abuse of order features you can review in our <a href="http://www.bmsboosting.com/tos" target="_blank">Terms of Service</a>.
                      </div>

                </div>
            </div>

            <div>
                <i class="fas fa-check-circle bg-blue"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header"><a href="#">Order Completed</a></h3>
                  <div class="timeline-body">
                    Your order has been completed!
                    All orders will be approved as 'Completed' by management for verification.<br>
                    At the end of your order you may see the status 'Verify' which means the order has been sent to management verify completion.<br>
                    If you had a great experience with your booster, we'd encourage you to leave them a Tip through the "Tip Booster" option in your Order Management dashboard.<br>
                    </div>

              </div>
          </div>

          <div>
              <i class="fas fa-check-circle bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Leave us a Review</a></h3>
                <div class="timeline-body">
                  We would appreciate it if you could leave us a review for your order!
                  Every review is appreciated, and helps us grow and improve our service.<br>

                  </div>
                  <div class="timeline-footer">
                    <a href="https://trustpilot.com/evaluate/bmsboosting.com" target="_blank" class="btn btn-primary btn-sm">Review</a>
                  </div>

            </div>
          </div>
              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
              </div>
            </div>
            </div>
        </div>

        <div class="container-fluid mt-5" v-if="$gate.isBoosterOrCoach()">
          <div class="row">
            <div class="col">
            <h2 class="mt-2 mb-5 ml-4">Order Steps</h2>
            <div class="timeline">
              <!-- Timeline time label -->

              <div>
              <!-- Before each timeline item corresponds to one icon on the left scale -->
                <i class="fas fa-money-bill-wave-alt bg-blue"></i>
                <!-- Timeline item -->
                <div class="timeline-item">
                <!-- Time -->
                  <!-- Header. Optional -->
                  <h3 class="timeline-header"><a href="#">Claiming Order</a></h3>
                  <!-- Body -->
                  <div class="timeline-body">
                    When a client orders, the order will be sent to the Orders page (accessible from side menu).<br>
                    To claim an order simply click the claim button next to the order.<br>
                    All boosters have a limit of 3 claims at a time, please finish your order before claiming more.<br>
                  </div>

                </div>

              </div>


              <div>
                  <i class="fas fa-user-check bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Order Claimed</a></h3>
                    <div class="timeline-body">
                      Once you claim an order, the order dashboard will appear under the "My Orders" tab.
                      You will be able to communicate with the client, see order details, and track the account's rank through this dashboard.<br>
                      You are not allowed to contact the client outside of this dashboard unless given permission from management, doing so will result in penalties.<br>
                      It is important to keep an eye on the Order Status, if it says "Paused" it means the client has paused the order and you must wait until the status changed back to "Claimed" to continue.<br>

                      If a client violates parts of our <a href="http://www.bmsboosting.com/tos" target="_blank">Terms of Service</a>, please inform management.

                      </div>

                </div>
            </div>

            <div>
                <i class="fas fa-check-circle bg-blue"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header"><a href="#">Order Completion</a></h3>
                  <div class="timeline-body">
                    When the order has been completed, you can click the "Mark Completed" button on your Dashboard, sending a notification to management to verify the completion of the order. <br>
                    There are penalties for false reports of order completion, you must use this button with care after making sure your order has been completed.<br>
                    Once your order gets approved for completion, the link to the dashboard will disappear from your "My Orders" menu and your current payout will be update.<br>
                    If there are issues in the process, please contact management.<br>
                    </div>

              </div>
          </div>

          <div>
              <i class="fas fa-check-circle bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Payouts</a></h3>
                <div class="timeline-body">
                  Congratulations on completing your order and obtaining a payout!
                  Payouts get sent to the email attached to your account, it is important that you make sure you use the same email for your BMS Account as your PayPal.<br>
                  You can request payouts under the "Payouts" tab in the "Profile" page and a request for a payout will be sent to management.<br>
                  Payout requests are usually approved on weekends and will be sent instantly once approved.<br>
                  </div>
                  <div class="timeline-footer">
                    <a href="https://app.bmsboosting.com/profile" target="_blank" class="btn btn-primary btn-sm">Profile</a>
                  </div>

            </div>
        </div>
              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
              </div>
            </div>
          </div>
        </div>
    </div>

</template>

<script>

    export default {
        data(){
          return{
            user:{},
            orders:{},
          }
        },
        mounted: function(){

            //console.log('Component mounted.');

            let that = this;
            window.Echo.private('claims')
              .listen('order-claimed', (e) => {
              ////console.log("Order claim heard!!");
              ////console.log(e);
              for(let i=0; i<that.user.ongoing_orders_arr.length; i++){
                if(e.orderID === that.user.ongoing_orders_arr[i].order_id && that.user.type === 'client'){
                  //console.log("Order claim match!!");
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
          this.getUser();
          if(this.$gate.isAdmin){
            //console.log('admin orders loaded');
            this.loadOrders();
          }
        },
        methods:{
          notifTest(){
            swal.fire({
            title: 'Order Claimed',
            text: 'Your order has been claimed by a booster.',
            icon: 'success',
            confirmButtonText: 'Go To Order Page'
            }).then((result)=>{
              if(result.value){
                window.location.replace('https://app.bmsboosting.com/order/'+'24252');
              }
            })
          },
          getUser(){
            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{

              this.user = data.data;
              ////console.log(this.user);
            });
          },
          loadOrders(){
            if(this.$gate.isAdmin){
              axios.get("api/orders").then((data)=>(this.orders=data.data.data));
            }
          },
          companyCut(totalPrice){
            let adjustedPrice = (totalPrice*0.96)-0.3;
            let bCut = Math.floor(adjustedPrice*0.7);

            let cCut = adjustedPrice - bCut;
            return cCut.toFixed(2);
          },
          getCompletedOrders(){
            let counter=0;
            for(let i=0; i<this.orders.length; i++){
              if(this.orders[i].order_status === 'completed'){
                counter++;
              }
            }
            return counter;
          },
          getOngoingOrders(){
            let counter=0;
            for(let i=0; i<this.orders.length; i++){
              if(this.orders[i].order_status === 'claimed'){
                counter++;
              }
            }
            return counter;
          },
          getUnclaimedOrders(){
            let counter=0;
            for(let i=0; i<this.orders.length; i++){
              if(this.orders[i].order_status === 'unclaimed'){
                counter++;
              }
            }
            return counter;
          },
          getPayout(user){
            //if(user.payout){
              return user.payout.toFixed(2);
            //}else if(user.payout === 0){
              //return 0.00;
            //}
          },
          getTotalOrderValue(){
            let counter=0;

            for(let i=0; i<this.orders.length; i++){
              let splitter = this.orders[i].order_type.split('');
              if(splitter[splitter.length-1]!=='.'){
                counter += this.orders[i].order_price;
              }
            }
            return counter.toFixed(2);
          },
          getTotalProfitValue(){
            let counter=0;
            for(let i=0; i<this.orders.length; i++){
              let splitter = this.orders[i].order_type.split('');
              if(splitter[splitter.length-1]!=='.'){
                let myPrice = this.companyCut(this.orders[i].order_price);
                counter += parseInt(myPrice);
              }
            }
            return counter.toFixed(2);
          }
        }
    }

</script>
