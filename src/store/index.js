import Vue from 'vue'
import Vuex from 'vuex'
import Global from '../components/Global'
import qs from 'querystring'
import axios from 'axios'
// import * as actions from './actions'
// import * as mutations from './mutations'
// import state from './rootState'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    isLoggedIn: false,
    uid: ''
  },
  mutations: {
    auth_success(state, user) {
      state.isLoggedIn = true;
      state.uid = user.uid;
    },
    logout(state) {
      state.status = '';
      state.uid = '';
      state.isLoggedIn = false;
    }
  },
  actions: {
    CheckLoginState({ commit }) {
      return new Promise((resolve, reject) => {
        if (!this.state.isLoggedIn) {
          axios({
            method: 'get',
            url: Global.localServer + 'data/user/session_data.php',
            withCredentials: true
          })
            .then(res => {
              // console.log(res.data)
              if (res.data.uid) {
                commit('auth_success', res.data)
              }
              resolve(res);
            })
            .catch(err => {
              reject(err)
            })
        } else {
          resolve()
        }
      })
    },
    Login({ commit }, user) {
      let data = qs.stringify(user);
      return new Promise((resolve, reject) => {
        axios({
          method: 'post',
          url: Global.localServer + 'data/user/loginapp.php',
          data: data,
          withCredentials: true
        })
          .then(res => {
            resolve(res);
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    Logout({ commit }) {
      return new Promise((resolve, reject) => {
        axios({
          method: 'get',
          url: Global.localServer + 'data/user/logout.php',
          withCredentials: true
        })
          .then(res => {
            // console.log(res.data)
            commit('logout');
            resolve(res);
          })
          .catch(err => {
            reject(err);
          })
      })
    }
  },
  getters: {
    isLoggedIn: state => state.isLoggedIn,
    uid: state => state.uid,
  }
})

export default store;