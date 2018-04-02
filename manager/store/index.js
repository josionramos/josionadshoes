export const state = () => ({
  preferences: {
    sidebarOpen: false
  }
})

export const mutations = {
  TOGGLE_SIDEBAR (state) {
    state.preferences.sidebarOpen = !state.preferences.sidebarOpen
  }
}

export const actions = {
  nuxtServerInit ({ dispatch }, { req }) {
    return Promise.all([
      dispatch('auth/check', req)
    ])
  }
}
