// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueBus from 'vue-bus'
import App from './App'
import router from './router'
import store from './store'
import axios from 'axios'
import global_ from './components/Global'

import './assets/css/basic.css'
import './assets/fonts/iconfont.css'

Vue.use(VueBus);
Vue.config.productionTip = false
Vue.prototype.GLOBAL = global_

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
