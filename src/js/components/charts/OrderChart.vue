<script>
import { Line, Bar } from 'vue-chartjs';
import moment from 'moment';

    export default {
    extends : Bar,

        mounted: function(){

            let Dates = new Array();
            let Prices = new Array();

            axios.get('https://app.bmsboosting.com/api/orders').then((response)=>{
              let data = response.data.data;
              if(data){
                for(let i=0; i<data.length; i++){

                  let splitter = data[i].order_type.split('');
                  if(splitter[splitter.length-1]!=='.'){

                  let tempDate = moment(data[i].created_at).format('MMMM Do YYYY');
                    ////console.log(tempDate);
                    if(Dates.indexOf(tempDate) == -1){
                    ////console.log(tempDate+" not in Dates Array");
                      let counter = 0;
                      Dates.push(moment(data[i].created_at).format('MMMM Do YYYY'));
                      for(let j=0; j<data.length; j++){
                        if(moment(data[j].created_at).format('MMMM Do YYYY') == tempDate){
                          counter+= data[j].order_price;
                        }

                      }
                      Prices.push(counter);
                    }else{
                      ////console.log("in dates array");
                      ////console.log(data[i]);
                    }
                  }

                }


                this.renderChart({
                labels: Dates,
                datasets: [
                {
                  label: 'Value of Orders',
                  backgroundColor: "#3f51b5",
                  data: Prices
                }
                ]
                }, {responsive: true, maintainAspectRatio: false})


              }
              else{
              }
            })


        },
        methods:{
          myDate(created){
              return moment(created).format('MMMM Do YYYY');
          }
        }
    }

</script>
