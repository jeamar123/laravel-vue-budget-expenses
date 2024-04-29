import axios from 'axios'
import { objToURLParams } from '@/composables/utils'
import { format } from '@/composables/date'

import { UPDATE_LOADING_STATE } from '@/store/index'
import { startOfMonth, endOfMonth } from 'date-fns'

export const UPDATE_TRANSACTIONS_STATE = 'UPDATE_TRANSACTIONS_STATE'

export const REQUEST_GET_TRANSACTIONS = 'REQUEST_GET_TRANSACTIONS'
export const REQUEST_GET_TRANSACTIONS_SUMMARY =
  'REQUEST_GET_TRANSACTIONS_SUMMARY'
export const REQUEST_UPLOAD_TRANSACTIONS = 'REQUEST_UPLOAD_TRANSACTIONS'
export const REQUEST_CREATE_TRANSACTION = 'REQUEST_CREATE_TRANSACTION'
export const REQUEST_UPDATE_TRANSACTION = 'REQUEST_UPDATE_TRANSACTION'
export const REQUEST_DELETE_TRANSACTION = 'REQUEST_DELETE_TRANSACTION'

const filterObj =
  localStorage.getItem('transaction_filters') !== null &&
  localStorage.getItem('transaction_filters') !== 'null'
    ? JSON.parse(localStorage.getItem('transaction_filters'))
    : null

const state = {
  items: [],
  pagination: {
    total: 1,
    per_page: 10,
    current_page: 1,
    last_page: 1,
  },
  headers: [],
  filters: filterObj || {
    order: 'desc',
    orderBy: null,
    search: null,
    start: format(startOfMonth(new Date()), 'yyyy-MM-dd'),
    end: format(endOfMonth(new Date()), 'yyyy-MM-dd'),
  },
  summary: {
    income: 0,
    expenses: 0,
    balance: 0,
  },
  sources: [
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
}

const getters = {}

const mutations = {
  async [UPDATE_TRANSACTIONS_STATE](state, payload) {
    if (payload.items) state.items = payload.items
    if (payload.pagination) state.pagination = payload.pagination
    if (payload.headers) state.headers = payload.headers
    if (payload.summary) state.summary = payload.summary
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

  async [REQUEST_GET_TRANSACTIONS]({ commit }) {
    let params = {
      page: state.pagination.current_page,
      perPage: state.pagination.per_page,
      start: state.filters.start,
      end: state.filters.end,
    }
    params.query = `?${objToURLParams(params)}`

    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get(`/api/transaction${params.query}`, actions.getHeaders())
        .then((res) => {
          // console.log(res)
          commit(UPDATE_TRANSACTIONS_STATE, {
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

  async [REQUEST_GET_TRANSACTIONS_SUMMARY]({ commit }) {
    let params = {
      start: format(new Date(), 'yyyy-MM-dd'),
      end: format(new Date(), 'yyyy-MM-dd'),
      // start: state.filters.start,
      // end: state.filters.end,
    }
    params.query = `?${objToURLParams(params)}`

    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get(`/api/transaction/summary${params.query}`, actions.getHeaders())
        .then((res) => {
          // console.log(res)
          commit(UPDATE_TRANSACTIONS_STATE, {
            summary: res.data.summary,
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

  async [REQUEST_UPLOAD_TRANSACTIONS]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .post('/api/transaction/import', params, {
          headers: {
            'Content-Type': 'multipart/form-data',
            ...actions.getHeaders().headers,
          },
        })
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

  async [REQUEST_CREATE_TRANSACTION]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .post('/api/transaction', params, actions.getHeaders())
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

  async [REQUEST_UPDATE_TRANSACTION]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .patch(`/api/transaction/${params.id}`, params, actions.getHeaders())
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

  async [REQUEST_DELETE_TRANSACTION]({ commit }, params) {
    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .delete(`/api/transaction/${params.id}`, actions.getHeaders())
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