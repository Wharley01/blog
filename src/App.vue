<style lang="scss" src="./assets/css/styles.scss"></style>
<style lang="scss" src="./assets/css/animate.scss"></style>
<style lang="scss" src="./assets/css/responsive.scss"></style>
<template>
  <div id="app">
    <div v-if="route_is_loading" class="route-loading-indicator is-loading"></div>
    <router-view/>
  </div>
</template>
<script>
  import {mapMutations,mapState} from 'vuex'
  export default {
      name:'App',
      data(){
          return {

          }
      },
      computed:{
          ...mapState([
              'route_is_loading'
          ])
      }
  }
</script>
<style lang="scss" scoped>
  #app{
    .route-loading-indicator{
      height: 5px;
      background: -webkit-linear-gradient(90deg, rgb(63, 81, 181), rgb(181, 59, 165));
      background: linear-gradient(90deg, rgb(63, 81, 181), rgb(181, 59, 165));
      width: 10%;
      display: none;
      left:1%;
      top: 0;
      position: fixed;
    }

    .route-loading-indicator.is-loading{
      animation: loading-animate 1s infinite;
      display: block;
    }

    @keyframes loading-animate {
      0% {
        left:5%;
        width: 40%;
      }
      20% {
        left:60%;
        width: 40%;

      }
      40% {
        left:30%;
        width: 30%;
      }

      60% {
        left:20%;
        width: 50%;
      }

      70% {
        left:10%;
        width: 60%;
      }

      90% {
        left:20%;
        width: 30%;
      }

      100% {
        left:10%;
        width: 20%;
      }
    }
  }

</style>

