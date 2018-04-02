export const state = () => ({
  active: false
})

export const mutations = {
  ACTIVE (state, isActive) {
    state.active = isActive
  },

  TOGGLE (state) {
    state.active = !state.active
  }
}

export const getters = {
  isActive (state) {
    return state.active
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
  }
}
