<template>
  <div class="home-wrap">
    <header class="m-l-auto m-r-auto txt-center p-a-xxlg md-p-a-md sm-p-a-xsm">
      <h1 class="txt-s-xxxlg md-txt-s-xlg sm-txt-s-md txt-c-white">Hi, I am SULAIMAN ADEWALE</h1>
      <p class="txt-s-md md-txt-s-sm sm-txt-s-xxsm txt-c-white hero-caption">I turn Coffee into Code</p>
      <div class="flex txt-s-xxlg space-between m-t-xxxlg sm-m-t-md">
        <a href>
          <i class="fab txt-c-sec-shade-5 fa-facebook-square"></i>
        </a>
        <a href>
          <i class="fab txt-c-sec-shade-5 fa-twitter-square"></i>
        </a>
        <a href>
          <i class="fab txt-c-sec-shade-5 fa-github-square"></i>
        </a>
        <a href>
          <i class="fab txt-c-sec-shade-5 fa-instagram"></i>
        </a>
      </div>
    </header>
    <section class="m-t-xlg sm-m-t-sm container sm-p-a-xxxsm">
      <template v-for="(post,index) in posts">
        <article :key="index" class="bg-c-white bd-round-a-xxxxsm p-a-xsm shadow-light m-t-xsm">
          <div class="flex">
          <span class="flex column" style="align-self: flex-start">
            <b class="txt-s-lg txt-c-grey-shade-2 m-b-auto">{{_date(post.date_added).day}}</b>
            <b class="txt-s-xxsm" style="m-a-top: -20px">{{_date(post.date_added).month}}</b>
          </span>
            <div class="m-l-sm m-t-auto m-b-auto">
              <router-link :to="`/read/${post.id}`"
                      class="txt-s-xsm sm-txt-s-xxsm txt-bold m-b-xxxxsm m-t-auto each-post-title"
              >{{post.title}}</router-link>
              <p class="m-t-xxxxsm txt-s-xxsm sm-txt-s-xxsm m-b-none txt-c-grey-shade-1">By: {{post.author}}</p>
            </div>
          </div>
          <p v-if="post.body"
                  class="txt-s-xxsm each-post-body sm-txt-s-xxsm"
          >{{post.body.slice(0,100)}}</p>
          <div class="flex ">
            <span class="read-more m-t-auto m-b-auto m-r-xxxxsm"></span>
            <router-link class="txt-c-black-shade-2 txt-s-xxsm sm-txt-s-xxsm txt-bold" :to="`/read/${post.id}`">
              Read more
          </router-link>
          </div>
        </article>

      </template>
    </section>
    <div class="p-a-md paging m-t-xsm container" style="max-width: 700px">
      <template v-for="(page,index) in pages">
        <router-link :key="index" :class="{'active': !page.navigable}" :to="`?page=${page.page_number}`">
          <span>{{page.page_number}}</span>
        </router-link>
      </template>
    </div>

  </div>
</template>

<script>
    // @ is an alias to /src

    import WOW from "wowjs";
    import { mapState, mapActions } from "vuex";
    import axios from "axios";

    export default {
        name: "home",
        data() {
            return {
                wow: null,
                posts:[],
                pages:[],
                total_pages: 0,
                is_loading: true,
                month_names_short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            };
        },
        components: {},
        created() {
            this.wow = new WOW.WOW();
            this.wow.init();
            this.wow.sync();
            let page_index = this.$route.query.page || 1;
            this.fetchData(page_index);
        },
        mounted() {
            this.wow.sync();
        },
        updated() {
            this.wow.sync();
        },
        computed: {

        },
        methods: {
            _date(timestamp){
                console.log(timestamp);
                if(timestamp){
                    let date = new Date(parseInt(timestamp) * 1000);
                    return {
                        day: date.getDay(),
                        month: this.month_names_short[date.getMonth()].toUpperCase()
                    };
                }else {
                    return {
                        day:'',
                        month:''
                    }
                }
            },
            async fetchData(page = null){
                try{
                    let blogs;
                    if(page === null){
                        blogs = await axios.get("/api/1/blog/fetch/all")
                    }else{
                        blogs = await axios.get(`/api/1/blog/fetch/all?page=${page}`)
                    }
                    this.posts = blogs.data.result;
                    this.pages = blogs.data.pages;
                    this.total_pages = blogs.data.total_pages;
                    this.wow.sync();
                }catch (err){
                    console.log(err);
                }
            }
        },
        watch:{
            "$route.query.page": async function() {
                await this.fetchData(this.$route.query.page);
            }
        }
    };
</script>
<style lang="scss">
  @import "../assets/css/styles";

  body {
    background-size: cover !important;
    background: url("../assets/images/hero.svg") no-repeat top center;
  }
  header {
    max-width: 900px;
  }
  .hero-caption {
    letter-spacing: 3px;
  }
  .each-post-title{
    letter-spacing: 2px;
  }
  .paging {
    @extend .flex;
    max-width: 500px;
    @extend .space-around;
    @extend .m-a-auto;
    a {
      height: 40px;
      width: 40px;
      @extend .bg-c-white;
      @extend .flex;
      @extend .shadow-normal;
      span {
        margin: auto;
        font-weight: bold;
      }
    }
    a.active {
      @extend .bg-c-grey-shade-2;
    }
  }
  .read-more{
    height: 4px;
    @extend .bg-c-black-shade-2;
    width: 60px;
    display: inline-block;
  }
</style>
