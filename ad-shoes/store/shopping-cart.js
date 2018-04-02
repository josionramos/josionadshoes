/**
 * STATE
 */
export const state = () => ({
  open: false
})

/**
 * MUTATIONS
 */
export const mutations = {
  OPEN (state) {
    state.open = true
  },

  CLOSE (state) {
    state.open = false
  },

  TOGGLE (state) {
    state.open = !state.open
  }
}

/**
 * GETTERS
 */
export const getters = {
  isOpen (state) {
    return state.open
  }
}

/**
 * ACTIONS
 */
export const actions = {
  open ({ commit }) {
    commit('OPEN')
  },

  close ({ commit }) {
    commit('CLOSE')
  },

  toggle ({ commit }) {
    commit('TOGGLE')
  }
}
