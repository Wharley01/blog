<template>
  <div class="blog-wrap">
    <div class="content">
      <h1>New Post</h1>
      <!--FORM HERE-->
      <post-form :params="postParams"></post-form>
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
      postParams: {
        title: {
          value: "",
          errors: []
        },
        author: {
          value: "",
          errors: []
        },
        body: {
          value: "",
          errors: []
        }
      }
    };
  }
};
</script>
<style lang="scss" scoped>
@import "../../assets/css/styles";

.blog-wrap {
  .content {
    max-width: 700px;
    @extend .m-a-auto;
    @extend .p-a-sm;
  }
}
</style>
