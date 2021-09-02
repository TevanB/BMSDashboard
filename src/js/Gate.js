export default class Gate{

  constructor(user){
    this.user=user;

  }
  isAdmin(){
    return this.user.type==='admin';
  }
  isBooster(){
    return this.user.type==='booster';
  }
  isCoach(){
    return this.user.type==='coach';
  }
  isClient(){
    return this.user.type=='client';
  }
  isBoosterOrCoach(){
    if(this.user.type==='coach' || this.user.type==='booster'){
      return true;
    }
    return false;
  }
  hasOrderAccess(order_id){
    if(this.user.type === 'admin'){
      return true;
    }else{
      for(let i=0; i<this.user.ongoing_orders_arr.length; i++){
        ////console.log(this.user.ongoing_orders_arr[i]);
        //axios.get('https://app.bmsboosting.com/api/orderinfo/'+order_id).then((data)=>{

        //});
        ////console.log(this.user.ongoing_orders_arr[i].order_id + " " + order_id);

        if(this.user.ongoing_orders_arr[i].order_id==order_id){
          //console.log('match');
          return true;
        }
      }
      return false;
    }
  }
  isWorkerOrAdmin(){
    if(this.user.type==='coach' || this.user.type==='booster' || this.user.type==='admin'){
      return true;
    }
    return false;
  }
}
