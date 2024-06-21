import axios from 'axios'
import { objToURLParams } from '@/composables/utils'

import { UPDATE_LOADING_STATE } from '@/store/index'

export const UPDATE_CATEGORY_STATE = 'UPDATE_CATEGORY_STATE'

export const REQUEST_GET_CATEGORY = 'REQUEST_GET_CATEGORY'
export const REQUEST_CREATE_CATEGORY = 'REQUEST_CREATE_CATEGORY'
export const REQUEST_UPDATE_CATEGORY = 'REQUEST_UPDATE_CATEGORY'
export const REQUEST_DELETE_CATEGORY = 'REQUEST_DELETE_CATEGORY'

const state = {
  items: [],
  pagination: {
    total: 1,
    per_page: 10,
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
  async [UPDATE_CATEGORY_STATE](state, payload) {
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

  async [REQUEST_GET_CATEGORY]({ commit }) {
    let params = {
      page: state.pagination.current_page,
      perPage: state.pagination.per_page,
      paginate: false,
    }
    params.query = `?${objToURLParams(params)}`

    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get(`/api/transaction/category${params.query}`, actions.getHeaders())
        .then((res) => {
          // console.log(res)
          commit(UPDATE_CATEGORY_STATE, {
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

  async [REQUEST_CREATE_CATEGORY]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .post('/api/transaction/category', params, actions.getHeaders())
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

  async [REQUEST_UPDATE_CATEGORY]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .patch(
          `/api/transaction/category/${params.id}`,
          params,
          actions.getHeaders(),
        )
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

  async [REQUEST_DELETE_CATEGORY]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .delete(`/api/transaction/category/${params.id}`, actions.getHeaders())
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
