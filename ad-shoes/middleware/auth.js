export default ({ store, redirect, app: { $axios } }) => {
  let token = store.state.auth.token

  if (!token) {
    redirect('/entrar')
  } else {
    $axios.setToken(token)
  }
}
