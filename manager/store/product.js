import ErrorBag from '@/app/error-bag'

function data (form) {
  return {
    // required
    name: form.name,
    sku: form.sku,
    price: form.price,
    price_sale: form.price_sale,
    active: form.active,
    featured: form.featured,
    category_id: form.category_id,

    // seo
    title: form.seo.title,
    slug: form.seo.slug,
    description: form.seo.description,
    content: form.content,

    // shipping
    width: form.shipping.width,
    height: form.shipping.height,
    length: form.shipping.length,
    weight: form.shipping.weight
  }
}

export const state = () => ({
  data: {},
  errors: null,
  loading: false,
  currentTab: 0,
  mapFields: {
    general: ['name', 'price', 'sale_price', 'slug', 'category_id'],
    seo: ['title', 'slug', 'content', 'description'],
    shipping: ['width', 'height', 'length', 'weight']
  }
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

  SET_TAB (state, index) {
    state.currentTab = index
  },

  SET_ERROR (state, data) {
    let map = state.mapFields
    let fields = Object.keys(data.errors)

    // Find correct tab
    Object.keys(map).forEach((key, index) => {
      if (map[key].indexOf(fields[0]) !== -1) {
        state.currentTab = index
      }
    })

    state.errors = data
  },

  CLEAR_ERROR (state) {
    state.errors = null
  }
}

export const getters = {
  loading (state) {
    return state.loading
  },

  errors (state) {
    return new ErrorBag(state.errors)
  },

  tab (state) {
    return state.currentTab
  }
}

export const actions = {
  // Store a product
  store ({ commit }, form) {
    commit('SET_LOADING')

    return this.$axios.post('/products', data(form)).then(({ data }) => {
      commit('STORE', data.data)
      commit('SET_LOADED')
      commit('CLEAR_ERROR')

      return data.data.id
    }).catch(({ response }) => {
      commit('SET_LOADED')

      if (response.status === 422) {
        commit('SET_ERROR', response.data)
      }

      return Promise.reject(response)
    })
  },

  // Update a product
  update ({ commit }, form) {
    commit('SET_LOADING')

    let url = `/products/${form.id}`

    return this.$axios.put(url, data(form)).then(({ data }) => {
      commit('STORE', data.data)
      commit('SET_LOADED')
      commit('CLEAR_ERROR')

      return data.data.id
    }).catch(({ response }) => {
      commit('SET_LOADED')

      if (response.status === 422) {
        commit('SET_ERROR', response.data)
      }

      return Promise.reject(response)
    })
  }
}
