import { createStore } from 'vuex'
import auth from './modules/auth'
import users from './modules/users'

export const UPDATE_LOADING_STATE = 'UPDATE_LOADING_STATE'

export default createStore({
  state: {
    isLoading: {
      show: false,
      message: 'Loading...',
    },
  },
  getters: {},
  mutations: {
    async [UPDATE_LOADING_STATE](state, payload) {
      state.isLoading = { ...state.isLoading, ...payload }
    },
  },
  actions: {},
  modules: {
    auth,
    users
  },
})
