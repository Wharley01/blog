import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'

router.beforeEach( (to,from, next) => {
    store.commit("UPDATE_LOAD_STATE",true);
    console.log("Route Loading");
    next();
});

router.afterEach( (to,from) => {
    store.commit("UPDATE_LOAD_STATE",false);
    console.log("Route Loaded");
})

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
