import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [{
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/read/:post_id',
      name: 'home',
      component: () => import( /* webpackChunkName: "blogs" */ './views/Read.vue')
    },
    {
      path: '/manage/list/posts',
      name: 'home',
      component: () => import( /* webpackChunkName: "blogs" */ './views/Manage/Index.vue')
    },
    {
      path: '/manage/update/:post_id',
      name: 'home',
      component: () => import( /* webpackChunkName: "blogs" */ './views/Manage/EditPost.vue')
    },
    {
      path: '/manage/delete/:post_id',
      name: 'home',
      component: () => import( /* webpackChunkName: "blogs" */ './views/Manage/DeletePost.vue')
    },
    {
      path: '/manage/draft/post',
      name: 'home',
      component: () => import( /* webpackChunkName: "blogs" */ './views/Manage/NewPost.vue')
    }
  ]
})
