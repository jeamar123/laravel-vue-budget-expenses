import axios from 'axios'
import { objToURLParams } from '@/composables/utils'

import { UPDATE_LOADING_STATE } from '@/store/index'

export const UPDATE_BUDGET_STATE = 'UPDATE_BUDGET_STATE'

export const REQUEST_GET_BUDGET = 'REQUEST_GET_BUDGET'
export const REQUEST_CREATE_BUDGET = 'REQUEST_CREATE_BUDGET'
export const REQUEST_UPDATE_BUDGET = 'REQUEST_UPDATE_BUDGET'
export const REQUEST_DELETE_BUDGET = 'REQUEST_DELETE_BUDGET'

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
  async [UPDATE_BUDGET_STATE](state, payload) {
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

  async [REQUEST_GET_BUDGET]({ commit }) {
    let params = {
      page: state.pagination.current_page,
      perPage: state.pagination.per_page,
      paginate: false
    }
    params.query = `?${objToURLParams(params)}`

    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get(`/api/transaction/budget${params.query}`, actions.getHeaders())
        .then((res) => {
          // console.log(res)
          commit(UPDATE_BUDGET_STATE, {
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

  async [REQUEST_CREATE_BUDGET]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .post('/api/transaction/budget', params, actions.getHeaders())
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

  async [REQUEST_UPDATE_BUDGET]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .patch(
          `/api/transaction/budget/${params.id}`,
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

  async [REQUEST_DELETE_BUDGET]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .delete(`/api/transaction/budget/${params.id}`, actions.getHeaders())
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
