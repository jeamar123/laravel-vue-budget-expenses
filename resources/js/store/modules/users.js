import axios from 'axios'
// axios.defaults.adminBaseURL = import.meta.env.VITE_APP_ADMIN_API_URL

import { UPDATE_LOADING_STATE } from '@/store/index'

export const UPDATE_USERS_STATE = 'UPDATE_USERS_STATE'

export const REQUEST_GET_USERS = 'REQUEST_GET_USERS'
export const REQUEST_UPLOAD_USERS = 'REQUEST_UPLOAD_USERS'
export const REQUEST_CREATE_USER = 'REQUEST_CREATE_USER'
export const REQUEST_UPDATE_USER = 'REQUEST_UPDATE_USER'
export const REQUEST_DELETE_USER = 'REQUEST_DELETE_USER'

const state = {
  users: [],
  pagination: {},
  filters: {
    order: 'desc',
    orderBy: null,
    search: null
  },
}

const getters = {}

const mutations = {
  async [UPDATE_USERS_STATE](state, payload) {
    if (payload.users) state.users = payload.users
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

  async [REQUEST_GET_USERS]({ commit }) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios
        .get('/api/user', actions.getHeaders())
        .then((res) => {
          console.log(res)
          commit(UPDATE_USERS_STATE, { 
            users: res.data.users
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

  async [REQUEST_UPLOAD_USERS]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios.post('/api/user/import', params, {
        headers: {
          'Content-Type': 'multipart/form-data',
          ...actions.getHeaders().headers
        }
      })
        .then(res => {
          // console.log(res);
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

  async [REQUEST_CREATE_USER]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios.post('/api/user', params, actions.getHeaders())
        .then(res => {
          // console.log(res);
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

  async [REQUEST_UPDATE_USER]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios.patch(`/api/user/${params.id}`, params.data, actions.getHeaders())
        .then(res => {
          console.log(res);
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

  async [REQUEST_DELETE_USER]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, { show: true })
      axios.delete(`/api/user/${params.id}`, actions.getHeaders())
        .then(res => {
          // console.log(res);
          commit(UPDATE_LOADING_STATE, { show: false })
          resolve(res)
        })
        .catch(err => {
          // console.log(err.response)
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
