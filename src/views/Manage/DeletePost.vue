<template>
  <div class="blog-wrap">
    <div class="content">
      <form @submit="deleteBlog">
        <input placeholder="Enter Auth password" v-model="password" type="password">
        <button>Continue</button>
      </form>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import axios from "axios";
// import Watcher from "@__path/watcher"
import PostForm from "../../components/PostForm/Index.vue";
export default {
  name: "NewBlogPost",
  components: {
    PostForm
  },
  data() {
    return {
      password: ""
    };
  },
  methods: {
    async deleteBlog(e) {
      e.preventDefault();
      try {
        let blogs = await axios.post(
          `/api/1/blog/delete/${this.$route.params.post_id}`,
          {
            password: this.password
          }
        );
        this.$router.push("/manage/list/posts?success=true");
      } catch (err) {
        console.log(err);
        alert("Unable to delete");
      }
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../assets/css/styles";

.blog-wrap {
  .content {
    max-width: 700px;
    margin: auto;
    padding: 18px;
  }
  input[type="text"],
  input[type="email"],
  input[type="password"],
  textarea {
    display: block;
    width: 100%;
    @extend .p-a-xxsm;
    @extend .m-t-xxsm;
    @extend .bd-round-a-xxxsm;

    @extend .bd-c-a-none;
    @extend .txt-bold;
    @extend .bg-c-grey-shade-3;
  }
  button {
    @extend .bg-c-black-shade-1;
    display: block;
    width: 100%;
    @extend .p-a-xxsm;
    @extend .m-t-xxsm;
    @extend .bd-round-a-xxxsm;

    @extend .bd-c-a-none;
    @extend .txt-bold;
    @extend .txt-c-white;
    cursor: pointer;
  }
}
</style>
