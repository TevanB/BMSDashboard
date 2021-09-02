<template>
    <div class="container">
      <a href="#" data-toggle="modal" data-target="#addNew" @click="click(data)">
        <i class="fa fa-edit"></i>
      </a>






    </div>
</template>

<script>
    import Form from 'vform';
    export default {
        props:{
          data: {},
          name: {},
          click: {},
          meta: {},
          classes: {}
        },

        methods:{
        },
        mounted() {
        }
    }
</script>
