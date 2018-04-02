import { filter } from 'lodash'

const order = {
  id: null,
  items: [],
  loading: false
}

/**
 * STATE
 */
export const state = () => ({...order})

/**
 * MUTATIONS
 */
export const mutations = {
  SET_ORDER (state, { id, items }) {
    state.id = id
    state.items.forEach((item, index) => {
      item['id'] = items[index].id
    })
  },

  SET_ITEM_ID (state, { id, index }) {
    state.items[index]['id'] = id
  },

  ADD (state, { product, amount, variants }) {
    state.items.push({
      price: product.price_sale ? product.price_sale : product.price,
      amount: amount,
      product: {
        id: product.id,
        name: product.name,
        thumbnail: product.cover ? product.cover.thumbnail : ''
      },
      variants
    })
  },

  REMOVE (state, index) {
    state.items.splice(index, 1)
  },

  OPEN (state) {
    state.open = true
  },

  CLOSE (state) {
    state.open = false
  },

  CLEAR (state) {
    Object.assign(state, order)
  },

  SET_AMOUNT (state, { index, amount }) {
    state.items[index].amount = amount
  },

  LOADING (state, loading) {
    state.loading = loading
  }
}

/**
 * GETTERS
 */
export const getters = {
  items (state) {
    return state.items
  },

  hasItems (state) {
    return state.items.length > 0
  },

  isSaved (state) {
    return state.id > 0
  },

  isLoading (state) {
    return state.loading
  },

  total (state) {
    return state.items.reduce((sum, item) => sum + (item.price * item.amount), 0)
  },

  find: (state, getters) => (product, variants) => {
    let index = getters.findIndex(product, variants)

    if (index > -1) {
      return getters.items[index]
    }
  },

  findIndex: (state) => (product, variants) => {
    return state.items.findIndex(item => {
      let matchVariants = filter(item.variants, (variant, index) => {
        return variants[index] && variant.id === variants[index].id
      })

      return item.product.id === product.id && matchVariants.length > 0
    })
  }
}

/**
 * ACTIONS
 */
export const actions = {
  add ({ commit, getters, dispatch }, { product, variants }) {
    let find = getters.find(product, variants)

    if (!find) {
      let item = {
        product,
        variants,
        amount: 1
      }

      commit('ADD', item)

      if (getters.isSaved) {
        dispatch('save', item)
      }
    }
  },

  remove ({ commit, state, getters }, { id, product, variants }) {
    let index = getters.findIndex(product, variants)

    if (id && getters.isSaved) {
      commit('LOADING', true)
      let url = `/customers/me/orders/${state.id}/items/${id}`

      return this.$axios.delete(url).then(({ data }) => {
        commit('REMOVE', index)
        commit('LOADING', false)
      })
    } else {
      commit('REMOVE', index)
    }
  },

  open ({ commit }) {
    commit('OPEN')
  },

  close ({ commit }) {
    commit('CLOSE')
  },

  clear ({ commit }) {
    commit('CLEAR')
  },

  create ({ commit, getters }) {
    let data = getters.items.map((item) => {
      return {
        amount: item.amount,
        price: item.price,
        product_id: item.product.id,
        variants: item.variants
      }
    })

    commit('LOADING', true)

    return this.$axios.post('/customers/me/orders', { items: data }).then(({ data }) => {
      commit('LOADING', false)
      commit('SET_ORDER', data)
    })
  },

  save ({ commit, state, getters }, item) {
    let data = {
      amount: item.amount ? item.amount : 1,
      price: item.price,
      product_id: item.product.id,
      variants: item.variants
    }

    let url = `/customers/me/orders/${state.id}/add`
    commit('LOADING', true)

    return this.$axios.post(url, { item: data }).then(({ data }) => {
      commit('LOADING', false)
      commit('SET_ITEM_ID', {
        id: data.data.id,
        index: getters.findIndex(item.product, item.variants)
      })
    })
  },

  setAmount ({ commit, getters, state }, { id, product, variants, amount }) {
    if (amount > 0) {
      commit('SET_AMOUNT', {
        amount,
        index: getters.findIndex(product, variants)
      })

      if (id && getters.isSaved) {
        let url = `/customers/me/orders/${state.id}/items/${id}`
        commit('LOADING', true)

        return this.$axios.put(url, { item: { amount } }).then(({ data }) => {
          commit('LOADING', false)
        })
      }
    }
  }
}
