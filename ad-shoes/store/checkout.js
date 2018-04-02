import ErrorBag from '@/app/error'

const BOLETO = 'boleto'
const CREDIT_CARD = 'credit_card'

const checkout = {
  payment: {
    type: '',
    link: ''
  },
  holder: {
    hash: null
  },
  address: {
    id: null
  },
  shipping: {
    price: 0
  },
  creditCard: {
    owner: true,
    token: null,
    holder: {
      name: '',
      cpf: '',
      phone: '',
      birthdate: ''
    },
    installment: null
  },
  errors: {},
  loading: false,
  completed: false,
  currentStep: 'checkout'
}

/**
 * STATE
 */
export const state = () => ({...checkout})

/**
 * MUTATIONS
 */
export const mutations = {
  CLEAR (state) {
    Object.assign(state, checkout)
  },

  SET_ERROR (state, data) {
    state.errors = data
  },

  LOADING (state, isLoading) {
    state.loading = isLoading
  },

  SET_PAYMENT_TYPE (state, type) {
    state.payment.type = type
  },

  SET_HOLDER_HASH (state, hash) {
    state.holder.hash = hash
  },

  SET_CREDIT_CARD_TOKEN (state, token) {
    state.creditCard.token = token
  },

  SET_INSTALLMENT (state, { price, amount }) {
    state.creditCard.installment = {
      price,
      amount
    }
  },

  SET_CREDIT_CARD_OWNER (state, isOwner) {
    state.creditCard.owner = isOwner
  },

  SET_ADDRESS (state, address) {
    state.address = address
  },

  SET_SHIPPING (state, shipping) {
    state.shipping = shipping
  },

  SET_COMPLETED (state) {
    state.errors = {}
    state.completed = true
  },

  SET_PAYMENT_LINK (state, link) {
    state.payment.link = link
  },

  GO_TO_STEP (state, step) {
    state.currentStep = step
  },

  UPDATE_CREDIT_CARD_HOLDER (state, { key, value }) {
    state.creditCard.holder[key] = value
  }
}

/**
 * GETTERS
 */
export const getters = {
  isCompleted (state) {
    return state.completed
  },

  hasAddress (state) {
    return state.address.id > 0
  },

  hasShipping (state) {
    return state.shipping.price > 0
  },

  hasPayment (state) {
    return state.payment.type !== ''
  },

  hasCreditCardToken (state) {
    return state.creditCard.token !== null
  },

  hasInstallment (state) {
    return state.creditCard.installment !== null
  },

  isBoleto (state) {
    return state.payment.type === BOLETO
  },

  isCreditCard (state) {
    return state.payment.type === CREDIT_CARD
  },

  isLoading (state) {
    return state.loading
  },

  shippingPrice (state) {
    return state.shipping.price
  },

  errors (state) {
    return new ErrorBag(state.errors)
  },

  holder (state) {
    return state.creditCard.holder
  },

  total (state, getters, rootState, rootGetters) {
    return rootGetters['order/total'] + getters['shippingPrice']
  }
}

/**
 * ACTIONS
 */
export const actions = {
  setBoleto ({ commit }) {
    commit('SET_PAYMENT_TYPE', BOLETO)
  },

  setCreditCard ({ commit }) {
    commit('SET_PAYMENT_TYPE', CREDIT_CARD)
  },

  clearPaymentType ({ commit }) {
    commit('SET_PAYMENT_TYPE', '')
  },

  async process ({ commit, state, rootState }) {
    let data = {
      hash: state.holder.hash,
      method: state.payment.type,
      order_id: rootState.order.id,
      shipping: {
        price: state.shipping.price,
        address_id: state.address.id
      },
      creditCard: state.creditCard
    }

    commit('LOADING', true)

    return new Promise((resolve, reject) => {
      this.$axios.post('/payments/pagseguro', data).then(({ data }) => {
        commit('LOADING', false)
        commit('GO_TO_STEP', 'done')
        commit('SET_COMPLETED')
        commit('SET_PAYMENT_LINK', data.link)
        commit('order/CLEAR', null, { root: true })
        resolve(data)
      }).catch(error => {
        console.log(error)
        commit('LOADING', false)
        commit('SET_ERROR', error.response.data)
        reject(error)
      })
    })
  }
}
