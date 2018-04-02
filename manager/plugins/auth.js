export default ({ req, store, app: { $axios } }) => {
  if (process.client && store.state.auth.token) {
    $axios.setToken(store.state.auth.token)
  }

  if (process.server && req.session.token) {
    $axios.setToken(req.session.token)
  }
}
