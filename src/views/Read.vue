<template>
  <div class="blog-read-wrap">
    <div>
      <div class="p-a-xxxxsm m-l-auto m-r-auto container m-b-xxxxsm flex sm-flex sm-column">
        <router-link to="/">
          <h1 class="txt-c-white m-t-auto m-b-auto">Adewale's Blog</h1>
        </router-link>
        <div
          class="flex txt-s-sm space-between full-width m-t-auto m-b-auto m-l-auto sm-m-l-none sm-m-r-auto sm-m-t-xxxsm"
          style="max-width: 200px"
        >
          <a :href="fb_profile_link">
            <i class="fab txt-c-sec-shade-5 fa-facebook-square"></i>
          </a>
          <a :href="twitter_profile_link">
            <i class="fab txt-c-sec-shade-5 fa-twitter-square"></i>
          </a>
          <a :href="github_profile_link">
            <i class="fab txt-c-sec-shade-5 fa-github-square"></i>
          </a>
          <a :href="instagram_profile_link">
            <i class="fab txt-c-sec-shade-5 fa-instagram"></i>
          </a>
        </div>
      </div>
      <div class="full-width bg-c-white bd-round-a-xxxxsm container sm-p-a-xxxsm">
        <div class="p-a-xxxsm m-l-auto m-r-auto sm-p-a-xxxxsm">
          <h1>{{title}}</h1>
          <span class="m-t-auto m-b-auto txt-c-grey-shade-2 txt-s-xxsm">By: {{author}}</span>
          <span class="txt-bold m-l-xxsm">&middot;</span>
          <span class="m-l-xxsm txt-s-xxsm txt-c-grey-shade-2">{{time}}</span>
        </div>
        <div class="post-body p-a-xxxsm sm-p-a-xxxxsm">
          <div class v-if="body != null">
            <vue-mark-down :toc="true">{{body}}</vue-mark-down>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import axios from "axios";
import VueMarkDown from "vue-markdown";
import Prism from "prismjs";
import "prismjs/prism";
import "prismjs/components/prism-markup-templating";
import "prismjs/components/prism-php";
import "prismjs/components/prism-bash";
import "../assets/css/prism-atom-dark.css";
//    import 'prism-theme-night-owl';

export default {
  name: "Read",
  components: {
    VueMarkDown
  },
  data() {
    return {
      fb_profile_link: "https://www.facebook.com/sulaiman.semiu.79",
      twitter_profile_link: "https://twitter.com/sulaiman_wale",
      instagram_profile_link: "https://instagram.com/__adewale__",
      github_profile_link: "https://github.com/Wharley01/",
      watcher: null,
      title: "",
      author: "",
      body: null,
      raw_time: null
    };
  },
  async created() {
    try {
      let blogs = await axios.get(
        `/api/1/blog/fetch/${this.$route.params.post_id}`
      );
      this.title = blogs.data.result.title;
      this.author = blogs.data.result.author;
      this.body = blogs.data.result.body;
      this.raw_time = blogs.data.result.date_added;
    } catch (err) {
      console.log(err);
    }
  },
  updated() {
    Prism.highlightAll();
  },
  mounted() {
    Prism.highlightAll();
  },
  computed: {
    time: function() {
      if (this.raw_time) {
        let date = new Date(this.raw_time * 1000);
        return date.getDay() + "/" + date.getMonth() + "/" + date.getFullYear();
      } else {
        return "";
      }
    }
  }
};
</script>
<style lang="scss">
.post-body {
  line-height: 200%;
  font-size: 19px;
}
</style>
