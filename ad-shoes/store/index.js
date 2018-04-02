export const actions = {
  nuxtServerInit ({ dispatch }, { req }) {
    return Promise.all([
      dispatch('auth/check', req)
    ])
  }
}
