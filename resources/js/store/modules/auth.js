import axios from 'axios'
// axios.defaults.adminBaseURL = import.meta.env.VITE_APP_ADMIN_API_URL
// axios.defaults.apiKey = import.meta.env.VITE_APP_AUTHORIZATION

import { UPDATE_LOADING_STATE } from '@/store/index'

export const UPDATE_AUTH_STATE = 'UPDATE_AUTH_STATE'

export const REQUEST_AUTH_LOGIN = 'REQUEST_AUTH_LOGIN'
export const REQUEST_AUTH_LOGOUT = 'REQUEST_AUTH_LOGOUT'
export const FETCH_CURRENT_USER = 'FETCH_CURRENT_USER'

const state = {
  isLoggedIn: false,
  token: null,
  user: null,
}

const getters = {}

const mutations = {
  async [UPDATE_AUTH_STATE](state, payload) {
    if (payload.isLoggedIn !== undefined) state.isLoggedIn = payload.isLoggedIn
    if (payload.user) state.user = payload.user
  },
}

const actions = {
  getHeaders() {
    return  {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token'),
      }
    }
  },

  async [REQUEST_AUTH_LOGIN]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios.post('/api/admin/login', params)
        .then(res => {
          console.log(res);
          let token = res.data.token
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
          localStorage.setItem('token', token)
          commit(UPDATE_AUTH_STATE, {
            isLoggedIn: true,
            token: token,
          })
          commit(UPDATE_LOADING_STATE, { show: false })
          resolve(res)
        })
        .catch(err => {
          // console.log(err.response)
          handleErr(err)
          commit(UPDATE_LOADING_STATE, { show: false })
          resolve(err.response)
        })
    })
  },

  async [REQUEST_AUTH_LOGOUT]({ commit }) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios.defaults.headers.common["Authorization"] = null
      localStorage.removeItem("token")
      commit(UPDATE_AUTH_STATE, { 
        isLoggedIn: false,
        user: null,
        token: null
      })
      commit(UPDATE_LOADING_STATE, { show: false })
      resolve(true)
    })
  },

  async [FETCH_CURRENT_USER]({ commit }) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios
        .get('/api/user', actions.getHeaders())
        .then((res) => {
          console.log(res)
          commit(UPDATE_AUTH_STATE, { 
            user: res.data.user
          })
          commit(UPDATE_LOADING_STATE, { show: false })
          resolve(res)
        })
        .catch((err) => {
          console.log(err.response)
          handleErr(err)
          commit(UPDATE_LOADING_STATE, { show: false })
          resolve(err.response)
        })
    })
  },
}

const handleErr = (err) => {
  if (
    err?.code === 'ERR_NETWORK' ||
    err?.response?.statusText === 'Unauthorized'
  ) {
    location.href = '/auth/login'
  }
}

export default { state, getters, mutations, actions }
