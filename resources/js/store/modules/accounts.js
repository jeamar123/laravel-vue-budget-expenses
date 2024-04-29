import axios from 'axios'
import { objToURLParams } from '@/composables/utils'

import { UPDATE_LOADING_STATE } from '@/store/index'

export const UPDATE_ACCOUNT_STATE = 'UPDATE_ACCOUNT_STATE'

export const REQUEST_GET_ACCOUNTS = 'REQUEST_GET_ACCOUNTS'
export const REQUEST_CREATE_ACCOUNT = 'REQUEST_CREATE_ACCOUNT'
export const REQUEST_UPDATE_ACCOUNT = 'REQUEST_UPDATE_ACCOUNT'
export const REQUEST_DELETE_ACCOUNT = 'REQUEST_DELETE_ACCOUNT'

const state = {
  items: [
    {
      id: 1,
      name: 'cash',
    },
    {
      id: 2,
      name: 'gcash',
    },
    {
      id: 3,
      name: 'bank account',
    },
    {
      id: 4,
      name: 'income',
    },
  ],
  pagination: {
    total: 1,
    per_page: 50,
    current_page: 1,
    last_page: 1,
  },
  headers: [],
  filters: {
    order: 'desc',
    orderBy: null,
    search: null,
  },
}

const getters = {}

const mutations = {
  async [UPDATE_ACCOUNT_STATE](state, payload) {
    if (payload.items) state.items = payload.items
    if (payload.pagination) state.pagination = payload.pagination
    if (payload.headers) state.headers = payload.headers
    if (payload.filters) state.filters = payload.filters
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

  async [REQUEST_GET_ACCOUNTS]({ commit }) {
    let params = {
      page: state.pagination.current_page,
      perPage: state.pagination.per_page,
    }
    params.query = `?${objToURLParams(params)}`

    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get(`/api/user/account${params.query}`, actions.getHeaders())
        .then((res) => {
          // console.log(res)
          commit(UPDATE_ACCOUNT_STATE, {
            items: res.data.data,
            pagination: res.data.meta,
            headers: res.data.headers,
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

  async [REQUEST_CREATE_ACCOUNT]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .post('/api/user/account', params, actions.getHeaders())
        .then((res) => {
          // console.log(res);
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

  async [REQUEST_UPDATE_ACCOUNT]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .patch(`/api/user/account/${params.id}`, params, actions.getHeaders())
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

  async [REQUEST_DELETE_ACCOUNT]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .delete(`/api/user/account/${params.id}`, actions.getHeaders())
        .then((res) => {
          // console.log(res);
          commit(UPDATE_LOADING_STATE, {
            show: false,
          })
          resolve(res)
        })
        .catch((err) => {
          // console.log(err.response)
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
