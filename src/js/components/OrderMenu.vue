<template>
  <li class="nav-item has-treeview">
    <a href="" class="nav-link">
      <i class="nav-icon fas fa-gavel blue"></i>
      <p>
          My Orders
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>

      <ul class="nav nav-treeview" v-for="order in user.ongoing_orders_arr" :key="order.order_id">
        <li class="nav-item" @click.prevent="reloadPage()">
          <router-link :to="`/order/${order.order_id}`" append class="nav-link">
            <i class="fas fa-caret-right nav-icon"></i>
            <p>{{menuFormat(order.order_type)}}</p>
          </router-link>
        </li>
      </ul>


  </li>
</template>

<script>
    export default {
        mounted() {
            //console.log('Component mounted.')
        },
        data(){
          return{
            orders:[],
            user: {},

          }
        },

    methods:{
      isUserOrder(item){


      },
      reloadPage(){
        window.location.reload();
      },
      menuFormat(input){
        let counter=0;
        let index=0;
        for(let i=0; i<input.length; i++){
          if(input[i]=='-'){
            counter++;
          }
          if(counter==2){
            index=i+1;
            break;
          }
        }
        ////console.log(tempArr);
        return input.slice(index);
      },
      getUser(){
        axios.get("https://app.bmsboosting.com/api/me").then((data)=>{

          this.user = data.data;
          ////console.log(this.user);
        });
      },
      loadOrders(){
        if(this.$gate.isAdmin){
          axios.get("https://app.bmsboosting.com/api/orders").then((response)=>{
            //console.log(response.data.data);
            var i = response.data.data[0];

            for(var i=0; i < response.data.data.length; i++){

              ////console.log(response.data.data[i]);
              this.orders.push(response.data.data[i]);

            }
            //console.log(this.orders);

          });
        }

      },
      },
      created(){
        //this.loadOrders();
        this.getUser();
        //console.log(this.orders);

      }
    }
</script>
