<template>
  <div class="blog-wrap">
    <div class="content">
      <h1 class="txt-c-white">Edit Post</h1>
      <!--FORM HERE-->
      <post-form :post_id="$route.params.post_id" :params="postParams"></post-form>
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
  },
  async created() {
    try {
      let blogs = await axios.get(
        `/api/1/blog/fetch/${this.$route.params.post_id}`
      );
      this.postParams = {
        title: {
          value: blogs.data.result.title,
          errors: []
        },
        author: {
          value: blogs.data.result.author,
          errors: []
        },
        body: {
          value: blogs.data.result.body,
          errors: []
        }
      };
    } catch (err) {
      console.log(err);
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../assets/css/styles";

.blog-wrap {
  .content {
    max-width: 900px;
    @extend .m-a-auto;
    @extend .p-a-sm;
  }
}
</style>
