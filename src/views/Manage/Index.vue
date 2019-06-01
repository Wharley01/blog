<template>
  <div class="blog-wrap bg-c-white">
    <div class="content">
      <div class="flex space-between">
        <h1>Manage Post</h1>
        <router-link class="m-t-auto m-b-auto" to="/manage/draft/post">
          <button class="bg-c-link-color p-t-xxxsm p-b-xxxsm p-r-xsm p-l-xsm txt-bold txt-s-xxxsm txt-c-white">New Post</button>
        </router-link>
      </div>
      <!--TABLE HERE-->
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(blog,index) in blogs">
            <tr>
              <td>{{blog.id}}</td>
              <td>{{blog.title}}</td>
              <td>{{blog.body}}</td>
              <td class="flex space-around">
                <router-link :to="`/manage/update/${blog.id}`">Edit Post</router-link>
                <router-link :to="`/manage/delete/${blog.id}`">Delete</router-link>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
      <div class="p-a-md paging">
        <template v-for="(page,index) in pages">
          <router-link :class="{'active': !page.navigable}" :to="`?page=${page.page_number}`">
            <span>{{page.page_number}}</span>
          </router-link>
        </template>
      </div>
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
      watcher: null,
      blogs: [],
      pages: [],
      total_pages: 0,
      current_page: 1
    };
  },
  async created() {
    this.fetchNextPage(this.$route.query.page || 1);
  },
  methods: {
    async fetchNextPage(page) {
      try {
        let blogs = await axios.get(`/api/1/blog/fetch/all?page=${page}`);
        this.blogs = blogs.data.result;
        this.pages = blogs.data.pages;
      } catch (err) {
        console.log(err);
      }
    }
  },
  watch: {
    "$route.query.page": function() {
      this.fetchNextPage(this.$route.query.page);
    }
  }
};
</script>
<style lang="scss" >
@import "../../assets/css/styles";

.blog-wrap {
  .content {
    max-width: 1300px;
    @extend .m-a-auto;
    @extend .p-a-sm;

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
  }
  table {
    border-collapse: collapse;
    width: 100%;
    thead {
      @extend .bg-c-grey-shade-3;
      th {
        @extend .p-a-xxxsm;
      }
    }
    tbody {
      td {
        @extend .p-a-xxxsm;
        border-bottom: 1px solid map_get($colors, grey-shade-2);
      }
    }
  }
}
</style>
