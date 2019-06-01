<template>
  <div class="wrap shadow-light p-a-xxxsm bd-round-a-xxxxsm">
    <form @submit="submitPost">
      <input v-model="postParams.title.value" name="title" placeholder="Post Title" type="text">
      <input v-model="postParams.author.value" name="author" placeholder="Autor" type="text">
      <textarea v-model="postParams.body.value" cols="10" placeholder="Post Body"></textarea>
      <div class="html-preview bd-c-a-grey-shade-2 border-solid" v-html="compiledMarkDown"></div>
      <input v-model="password" name="password" placeholder="Password" type="password">
      <button>Submit</button>
    </form>
  </div>
</template>

<script>
// @ is an alias to /src
import axios from "axios";
import marked from "marked";

// import Watcher from "@__path/watcher";
export default {
  name: "Blog",
  props: ["post_id", "params"],
  data() {
    return {
      password: "",
      blogs: [],
      pages: [],
      total_pages: 0,
      postParams: {}
    };
  },
  computed: {
      compiledMarkDown(){
          return marked(this.postParams.body.value,{ sanitize: true })
      }
  },
  created() {
    this.postParams = this.params;
  },
  watch: {
    params() {
      this.postParams = this.params;
    }
  },
  methods: {
      writeBody: function(){

      },
    async submitPost(e) {
      e.preventDefault();
      try {
        let payload = {
          title: this.postParams.title.value,
          author: this.postParams.author.value,
          body: this.postParams.body.value,
          password: this.password
        };
        if (!this.post_id) {
          let post = await axios.post("/api/1/blog/store", payload);
        } else {
          let post = await axios.post(
            `/api/1/blog/update/${this.post_id}`,
            payload
          );
        }
        this.$router.push("/manage/list/posts");
      } catch (err) {
        alert("Unable to Post");
      }
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../assets/css/styles";

.wrap {
  @extend .bg-c-white;
  input[type="text"],
  input[type="email"],
  input[type="password"],
  textarea {
    display: block;
    width: 100%;
    @extend .p-a-xxsm;
    @extend .m-t-xxsm;
    @extend .bd-round-a-xxxxsm;
    @extend .bd-c-a-none;
    @extend .bg-c-grey-shade-3;
    @extend .txt-s-xxsm;

  }
  textarea{
    min-height: 400px;
    max-width: 100%;
    min-width: 100%;
  }
  button {
    @extend .bg-c-sec;
    display: block;
    width: 100%;
    @extend .p-a-xxsm;
    @extend .m-t-xxsm;
    @extend .bd-round-a-xxxxsm;
    @extend .bd-c-a-none;

    @extend .txt-c-white;
    @extend .txt-s-xxsm;
    cursor: pointer;
  }
  .html-preview {
    @extend .p-a-xxsm;
    @extend .txt-s-xxsm;
    overflow: auto;
    min-height: 400px;
    width: 100%;
  }
}
</style>
