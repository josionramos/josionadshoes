export default ({ store }) => {
  if (process.client && store.getters['nav/isActive']) {
    if (document.body.clientWidth < 768) {
      store.dispatch('nav/close')
    }
  }
}
