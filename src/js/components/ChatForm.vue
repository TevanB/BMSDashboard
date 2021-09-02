<template>
    <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">

        <span class="input-group-append">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user', 'orderid'],

        data() {
            return {
                newMessage: '',
            }
        },
        created(){

        },
        methods: {
            sendMessage() {
                let data = {
                    user: this.user.user,
                    message: this.newMessage,
                };
                //console.log(data);
                this.$emit('messagesent', JSON.stringify(data));
                //console.log("MESSAGESENT EVENT EXECUTED");
                this.newMessage = '';
            },
            fetchMessages() {
                axios.get('/messages/'+this.orderid).then(response => {
                    this.messages = response.data;
                });
            },

        }
    }
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
