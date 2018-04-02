import axios from 'axios'

export const state = () => ({
  user: null,
  token: null
})

export const mutations = {
  LOGIN (state, token) {
    state.token = token
  },

  LOGOUT (state) {
    state.token = null
    state.user = null
  },

  SET_USER (state, user) {
    state.user = user
  }
}

export const actions = {
  check ({ commit }, request) {
    let session = request.session

    if (session && session.token && session.user) {
      commit('LOGIN', session.token)
      commit('SET_USER', session.user)
    }
  },

  async logout ({ commit }) {
    await axios.post('api/logout')
    commit('LOGOUT')
  },

  async login ({ commit }, user) {
    const { data } = await axios.post('api/login', user)

    commit('LOGIN', data.access_token)
    commit('SET_USER', data.user)
  }
}
