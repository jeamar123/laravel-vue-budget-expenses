import { createStore } from 'vuex'
import auth from './modules/auth'
import users from './modules/users'
import transactions from './modules/transactions'
import category from './modules/category'
import accounts from './modules/accounts'
import budgets from './modules/budgets'

export const UPDATE_LOADING_STATE = 'UPDATE_LOADING_STATE'
export const UPDATE_NOTIF_ALERT_STATE = 'UPDATE_NOTIF_ALERT_STATE'
export const SHOW_NOTIF_ALERT = 'SHOW_NOTIF_ALERT'

export default createStore({
  state: {
    isLoading: {
      show: false,
      message: 'Loading...',
    },
    notifAlert: {
      show: false,
      title: 'Success',
      message: '',
    },
  },
  getters: {},
  mutations: {
    async [UPDATE_LOADING_STATE](state, payload) {
      state.isLoading = {
        ...state.isLoading,
        ...payload,
      }
    },
    async [UPDATE_NOTIF_ALERT_STATE](state, payload) {
      state.notifAlert = {
        ...state.notifAlert,
        ...payload,
      }
    },
  },
  actions: {
    async [SHOW_NOTIF_ALERT]({ commit }, params) {
      await commit(UPDATE_NOTIF_ALERT_STATE, {
        show: true,
        ...params,
      })
    },
  },
  modules: {
    auth,
    users,
    transactions,
    category,
    accounts,
    budgets,
  },
})
