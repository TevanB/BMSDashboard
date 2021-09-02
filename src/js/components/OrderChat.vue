<template>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">

                  <div id="scroller" class="panel-body mt-3 mb-3">
                      <chat-messages :messages="messages" :order_id="order_id"
                      v-on:change="scrollToEnd"
                      ></chat-messages>
                  </div>
                  <div class="panel-footer mb-3">
                      <chat-form
                          v-on:messagesent="addMessage"
                          :user="{ user }"
                          :orderid="{ order_id }"
                      ></chat-form>
                  </div>
              </div>
          </div>
        </div>
    </div>
</template>

<script>

import Form from 'vform';
import HasError from 'vform';
    export default {
        props: ['order_id'],

        data(){
          return{
            user: {},
            messages:[],
            result: new Form({
             order_id: '',
             message: ''
            }),
          }
        },
        mounted() {
            //console.log('Component mounted.')

            //console.log(window.Echo.private('chat'));
            window.Echo.private('chat')
              .listen('message-sent', (e) => {
              //console.log("MESSAGE SENT REQUEST HEARD");

                this.fetchMessages();

              })
              .listen('UpdateRequest', (e)=>{
                //console.log(e);
                //console.log("UPDATE REQUEST HEARD");
                this.fetchMessages();

              });



            //this.scrollToEnd();
            //console.log(this.$el.querySelector("#scroller"));

            this.fetchMessages();


        },
        updated(){
          //console.log('order chat updated');

          this.$emit('updaterequest');

        },
        methods:{
          scrollToEnd() {
            setTimeout(()=>{
            var container = this.$el.querySelector("#scroller");
            container.scrollTop = container.scrollHeight;
            }, 1000);

          },
          getUser(){
            axios.get("https://app.bmsboosting.com/api/me").then((data)=>{

              this.user = data.data.name;
              ////console.log(this.user);
            });
          },
          addMessage(message) {

              //console.log(this.messages);
              // message is the string not the object
              this.messages.push(message);


              this.result.order_id = this.order_id.order_id;
              this.result.message = message;
              axios.post('https://app.bmsboosting.com/messages', this.result).then(response => {
                //console.log(response.data);
                this.fetchMessages();

              });

              //consider individually adding newest message directly
              //problem is last message not registering in get req so left out in update

          },
          fetchMessages() {
              let that = this;
              axios.get('https://app.bmsboosting.com/messages/'+ that.order_id.order_id).then(response => {
                  //console.log(response);
                  this.messages = response.data;
                  this.scrollToEnd();

              });
              //console.log('messages fetched');
          },
        },
        created(){
          this.getUser();
          this.fetchMessages();
        }
    }
</script>
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
    display: flex;
    flex-direction: column-reverse;
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
