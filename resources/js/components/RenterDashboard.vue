<template>
    <div class="container">

    </div>
</template>


<script>
    export default {
       data() {
          return {

          };
       },
      methods: {




      },
      created() {

      },
        mounted() {
            this.loaddaily();
            this.loadmonth();
            this.loadweek();
            this.lasttransaction();
            console.log('Component mounted.')
        }
    }
</script>
