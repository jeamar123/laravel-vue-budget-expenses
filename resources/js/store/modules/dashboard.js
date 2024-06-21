import axios from 'axios'
import { objToURLParams } from '@/composables/utils'
import { format } from '@/composables/date'

import { UPDATE_LOADING_STATE } from '@/store/index'
import { startOfMonth, endOfMonth } from 'date-fns'

export const UPDATE_DASHBOARD_STATE = 'UPDATE_DASHBOARD_STATE'

export const FETCH_BALANCE_REPORT = 'FETCH_BALANCE_REPORT'

const filterObj =
  localStorage.getItem('transaction_filters') !== null &&
  localStorage.getItem('transaction_filters') !== 'null'
    ? JSON.parse(localStorage.getItem('transaction_filters'))
    : null

const state = {
  filters: filterObj || {
    start: format(startOfMonth(new Date()), 'yyyy-MM-dd'),
    end: format(endOfMonth(new Date()), 'yyyy-MM-dd'),
  },
  balanceReport: {},
}

const getters = {}

const mutations = {
  async [UPDATE_DASHBOARD_STATE](state, payload) {
    if (payload.filters) {
      state.filters = payload.filters
      localStorage.setItem('transaction_filters', JSON.stringify(payload.filters))
    }
    if (payload.balanceReport) state.balanceReport = payload.balanceReport
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

  async [FETCH_BALANCE_REPORT]({ commit }) {
    let params = {
      start: state.filters.start,
      end: state.filters.end,
    }
    params.query = `?${objToURLParams(params)}`

    return new Promise((resolve) => {
      commit(UPDATE_LOADING_STATE, {
        show: true,
      })
      axios
        .get(
          `/api/transaction/dashboard/balance-report${params.query}`,
          actions.getHeaders(),
        )
        .then((res) => {
          // console.log(res)
          commit(UPDATE_DASHBOARD_STATE, {
            balanceReport: res.data,
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
