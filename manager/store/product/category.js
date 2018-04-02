import ErrorBag from '@/app/error-bag'

export const state = () => ({
  data: {},
  errors: null,
  loading: false
})

export const mutations = {
  STORE (state, data) {
    state.data = data
  },

  SET_LOADING (state) {
    state.loading = true
  },

  SET_LOADED (state) {
    state.loading = false
  },

  SET_ERROR (state, data) {
    state.errors = data
  }
}

export const getters = {
  loading (state) {
    return state.loading
  },

  errors (state) {
    return new ErrorBag(state.errors)
  }
}

export const actions = {
  /**
   * Store a category.
   */
  store ({ commit }, form) {
    commit('SET_LOADING')

    return this.$axios.post('/products/categories', form).then(({ data }) => {
      commit('STORE', data.data)
      commit('SET_LOADED')

      return data.data
    }).catch(({ response }) => {
      commit('SET_LOADED')
      commit('SET_ERROR', response.data)

      return Promise.reject(response)
    })
  },

  /**
   * Update a category.
   */
  update ({ commit }, form) {
    commit('SET_LOADING')
    let url = `/products/categories/${form.id}`

    return this.$axios.put(url, form).then(({ data }) => {
      commit('STORE', data.data)
      commit('SET_LOADED')

      return data.data.id
    }).catch(({ response }) => {
      commit('SET_LOADED')
      commit('SET_ERROR', response.data)

      return Promise.reject(response)
    })
  },

  clear ({ commit }) {
    commit('SET_ERROR', null)
  }
}
