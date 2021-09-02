<script>
import { Line, Bar } from 'vue-chartjs';
import moment from 'moment';

    export default {
    data(){
      return{
        users:{},
      }
    },
    extends : Line,

        mounted: function(){

            let Dates = new Array();
            let Users = new Array();
            let NumUsers = new Array();
            axios.get('https://app.bmsboosting.com/api/user').then((response)=>{
              let data = response.data.data;
              //console.log(response.data.data);
              if(data){
                for(let i=0; i<data.length; i++){
                  if(Dates.indexOf(this.myDate(data[i].created_at))==-1){
                    Dates.push(this.myDate(data[i].created_at));
                  }
                  Users.push(data[i]);
                }
                  for(let i=0; i<Dates.length; i++){
                    let counter = 0;
                    for(let j=0; j<Users.length; j++){
                      if(this.myDate(Users[j].created_at)==Dates[i]){
                        counter+=1;
                      }
                    }
                    NumUsers.push(counter);
                  }
                }
                else{
                }
                Dates.reverse();
                NumUsers.reverse();
                this.renderChart({
                labels: Dates,
                datasets: [
                {
                  label: 'Number of Users',
                  backgroundColor: "#3f51b5",
                  data: NumUsers
                }
                ]
                }, {responsive: true, maintainAspectRatio: false})




            })


        },
        methods:{
          myDate(created){
              return moment(created).format('MMMM Do YYYY');
          },
          loadUsers(){
            if(this.$gate.isAdmin){


            axios.get("api/user").then((data)=>(this.users=data.data));
            }
          },
        }
    }

</script>
