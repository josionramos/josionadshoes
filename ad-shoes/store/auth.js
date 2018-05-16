import axios from 'axios'

const auth = {
  token: null,
  customer: null
}

export const state = () => ({...auth})

export const mutations = {
  LOGIN (state, token) {
    state.token = token
  },

  LOGOUT (state) {
    Object.assign(state, state)
    state.token = null
  },

  SET_CUSTOMER (state, customer) {
    state.customer = customer
  }
}

export const getters = {
  isLoggedIn (state) {
    return state.token && state.token.length > 1
  }
}

export const actions = {
  check ({ commit }, request) {
    let session = request.session
    if (session && session.token) {
      commit('LOGIN', session.token)
    }
  },

  async logout ({ commit }) {
    await axios.get('/api/logout')

    commit('LOGOUT')
  },

  async login ({ commit }, user) {
    const { data } = await axios.post('/api/login', user)

    commit('LOGIN', data.access_token)
    commit('SET_CUSTOMER', data.customer)
  }
}
