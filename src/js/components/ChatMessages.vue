<template>
    <ul class="chat">
        <li class="left clearfix" v-for="message in trimOrderMessages(messages)" :key="message.id" >
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">
                        {{ message.user_name }}
                    </strong>| {{  message.created_at | messageDate}}

                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
        </li>
    </ul>
</template>

<script>
  export default {
    props: ['messages', 'order_id'],
    data(){
      return{
        sender:{},
        users:[],
      }
    },
    watch:{
      messages: function(){
        this.$emit('messagesent');

      }
    },
    created(){

    },

    mounted(){


      //this.scrollToEnd();
    },
    methods:{
      fetchMessages() {
          axios.get('/messages').then(response => {
              this.messages = response.data;
          });
      },
      scrollToEnd() {
        var container = this.$el.querySelector("#scroller");
        //console.log(container);
        //container.scrollTop = container.scrollHeight;
      },

      getUsername(message){


        //used model relationship to get username

        if(Number.isInteger(message.id)){
          axios.get('https://app.bmsboosting.com/messages/'+message.id, message).then((data)=>{
            //console.log(data.data.name);
            this.sender = data.data.name;

          })
        }
        return this.sender;
      },

      trimOrderMessages(messageArr){
        //console.log(this.order_id.order_id);
        let tempArr = [];
        for(let i =0; i<messageArr.length; i++){
          if(messageArr[i].order_id == this.order_id.order_id){
            tempArr.push(messageArr[i]);
          }
        }

        return tempArr;
      }
    }
  };
</script>
<style module>
  .chat {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .chat li {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
  }

  .chat li .chat-body p {
    margin: 0;
    color: #777777;
  }

  .panel-body {
    overflow-y: scroll;
    height: 350px;
  }

  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
  }
</style>
