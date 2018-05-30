export const state = () => ({
  active: false,
  previousURL: ''
})

export const mutations = {
  ACTIVE (state, isActive) {
    state.active = isActive
  },

  TOGGLE (state) {
    state.active = !state.active
  },

  SET_PREVIOUS_URL (state, url) {
    state.previousURL = url
  }
}

export const getters = {
  isActive (state) {
    return state.active
  },
  previousURL (state) {
    return state.previousURL
  }
}

export const actions = {
  open ({ commit }) {
    commit('ACTIVE', true)
  },

  close ({ commit }) {
    commit('ACTIVE', false)
  },

  toggle ({ commit }) {
    commit('TOGGLE', false)
  },

  previousURL ({ commit, state }, url) {
    commit('SET_PREVIOUS_URL', url)
  }

}
