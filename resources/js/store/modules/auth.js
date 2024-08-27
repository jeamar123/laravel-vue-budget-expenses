import axios from 'axios'

import { UPDATE_LOADING_STATE } from '@/store/index'

export const UPDATE_AUTH_STATE = 'UPDATE_AUTH_STATE'

export const REQUEST_AUTH_LOGIN = 'REQUEST_AUTH_LOGIN'
export const REQUEST_AUTH_REGISTER = 'REQUEST_AUTH_REGISTER'
export const REQUEST_AUTH_LOGOUT = 'REQUEST_AUTH_LOGOUT'
export const FETCH_CURRENT_USER = 'FETCH_CURRENT_USER'
export const UPDATE_ACCOUNT_SETTINGS = 'UPDATE_ACCOUNT_SETTINGS'
export const UPDATE_PASSWORD = 'UPDATE_PASSWORD'

const state = {
  isLoggedIn: false,
  token: null,
  user: null,
  isLoading: false,
}

const getters = {
  token: (state) => () => state.user,
}

const mutations = {
  async [UPDATE_AUTH_STATE](state, payload) {
    if (payload.isLoggedIn !== undefined) state.isLoggedIn = payload.isLoggedIn
    if (payload.isLoading !== undefined) state.isLoading = payload.isLoading
    if (payload.user) state.user = payload.user
  },
}

const actions = {
  getHeaders() {
    return {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token'),
      },
    }
  },

  async [REQUEST_AUTH_LOGIN]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_AUTH_STATE, {
        isLoading: true,
      })
      axios
        .post('/api/user/login', params)
        .then((res) => {
          console.log(res)
          let token = res.data.token
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
          localStorage.setItem('token', token)
          commit(UPDATE_AUTH_STATE, {
            isLoggedIn: true,
            token: token,
          })
          commit(UPDATE_AUTH_STATE, {
            isLoading: false,
          })
          resolve(res)
        })
        .catch((err) => {
          // console.log(err.response)
          handleErr(err)
          commit(UPDATE_AUTH_STATE, {
            isLoading: false,
          })
          resolve(err.response)
        })
    })
  },

  async [REQUEST_AUTH_REGISTER]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_AUTH_STATE, {
        isLoading: true,
      })
      axios
        .post('/api/user/register', params)
        .then((res) => {
          console.log(res)
          commit(UPDATE_AUTH_STATE, {
            isLoading: false,
          })
          resolve(res)
        })
        .catch((err) => {
          // console.log(err.response)
          handleErr(err)
          commit(UPDATE_AUTH_STATE, {
            isLoading: false,
          })
          resolve(err.response)
        })
    })
  },

  async [REQUEST_AUTH_LOGOUT]({ commit }) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios.defaults.headers.common['Authorization'] = null
      localStorage.removeItem('token')
      commit(UPDATE_AUTH_STATE, {
        isLoggedIn: false,
        user: null,
        token: null,
      })
      commit(UPDATE_LOADING_STATE, {
        show: false,
      })
      resolve(true)
    })
  },

  async [FETCH_CURRENT_USER]({ commit }) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get('/api/user/settings', actions.getHeaders())
        .then((res) => {
          // console.log(res)
          commit(UPDATE_AUTH_STATE, {
            user: res.data.user,
          })
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
          resolve(res)
        })
        .catch((err) => {
          console.log(err.response)
          handleErr(err)
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
          resolve(err.response)
        })
    })
  },

  async [UPDATE_ACCOUNT_SETTINGS]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_AUTH_STATE, {
        isLoading: true,
      })
      axios
        .patch(`/api/user/settings`, params, actions.getHeaders())
        .then((res) => {
          console.log(res)
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
          resolve(res)
        })
        .catch((err) => {
          // console.log(err.response)
          handleErr(err)
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
          resolve(err.response)
        })
    })
  },

  async [UPDATE_PASSWORD]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_AUTH_STATE, {
        isLoading: true,
      })
      axios
        .patch(`/api/user/password`, params, actions.getHeaders())
        .then((res) => {
          console.log(res)
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
          resolve(res)
        })
        .catch((err) => {
          // console.log(err.response)
          handleErr(err)
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
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

export default {
  state,
  getters,
  mutations,
  actions,
}
