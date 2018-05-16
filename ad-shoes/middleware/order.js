export default ({ store, redirect }) => {
  if (!store.getters['order/hasItems']) {
    redirect('/checkout')
  }
}
