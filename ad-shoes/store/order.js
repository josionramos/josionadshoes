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
    console.log('find index: ' + index)
    if (index > -1) {
      return getters.items[index]
    }
  },

  findIndex: (state) => (product, variants) => {
    // console.log('for Id tam: ' + state.items.length)
    state.items.forEach((item) => {
      console.log('Olds prod for Id: ' + [item.product.id] + ' name: ' + [item.product.name])
    })
    console.log('new prod for Id: ' + product.id + ' name: ' + product.name)

    var foundSize = false
    var foundcolor = false
    var hasSize = false
    var hasColor = false
    // corrigir logica
    return state.items.findIndex(item => {
      let matchVariants = filter(item.variants, (variant, index) => {
        console.log('variants for index: ' + index)
        if (variants[index] && index === 'color') {
          foundcolor = true
          console.log('new color for Id: ' + variants[index].id)
          console.log('old color for Id: ' + variant.id)
          if (variants[index].id === variant.id) {
            hasColor = true
            return true
          }
        } else if (variants[index] && index === 'size') {
          foundSize = true
          console.log('new size for Id: ' + variants[index].id)
          console.log('old size for Id: ' + variant.id)
          if (variants[index].id === variant.id) {
            hasSize = true
            return true
          }
        }
        return false
      })
      console.log('matchVariants size: ' + matchVariants.length)
      console.log('found color : ' + foundcolor)
      console.log('found size : ' + foundSize)
      console.log('has color : ' + hasColor)
      console.log('has size : ' + hasSize)
      if (foundcolor && foundSize) {
        if (matchVariants.length !== 2) {
          return false
        }
      } else if (foundcolor || foundSize) {
        if (matchVariants.length !== 1) {
          return false
        } else if (!hasColor && !hasSize) {
          return false
        }
      }
      return item.product.id === product.id
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
