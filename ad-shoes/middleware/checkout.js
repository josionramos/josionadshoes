export default ({ store, redirect }) => {
  if (store.getters['checkout/isCompleted']) {
    store.commit('checkout/CLEAR')
  }
}
