export default ({ store, redirect, app: { $axios } }) => {
  let token = store.state.auth.token

  if (!token) {
    redirect('/')
  } else {
    $axios.setToken(token)
  }
}
