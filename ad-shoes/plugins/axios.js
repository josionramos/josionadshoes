import axios from 'axios'

class Axios {
  /**
   * Constructor
   */
  constructor (env, redirect, toast) {
    this.env = env
    this.token = null
    this.toast = toast
    this.redirect = redirect
  }

  /**
   * Set token
   *
   * @param  {String}  token
   * @return  {void}
   */
  setToken (token) {
    this.token = token
  }

  /**
   * Send HTTP request
   *
   * @param  {String}  method
   * @param  {String}  url
   * @param  {Object}  data
   * @return  {Promise}
   */
  getAxios (onUploadProgress = null) {
    let request = {
      onUploadProgress,
      baseURL: this.env.API_BASEURL,
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    }

    if (this.token) {
      request['headers']['Authorization'] = `Bearer ${this.token}`
    }

    let instance = axios.create(request)

    instance.interceptors.response.use(response => response, error => {
      if (error.response.status === 401) {
        this.unauthorized()
      }

      return Promise.reject(error)
    })

    return instance
  }

  /**
   * Send POST HTTP request
   *
   * @param  {String}  url
   * @param  {Object}  data
   * @return  {Promise}
   */
  post (url, data) {
    return this.getAxios().post(url, data)
  }

  /**
   * Send PUT HTTP request
   *
   * @param  {String}  url
   * @param  {Object}  data
   * @return  {Promise}
   */
  put (url, data) {
    return this.getAxios().put(url, data)
  }

  /**
   * Send GET HTTP request
   *
   * @param  {String}  url
   * @return  {Promise}
   */
  get (url) {
    return this.getAxios().get(url)
  }

  /**
   * Send POST HTTP request
   *
   * @param  {String}  url
   * @return  {Promise}
   */
  upload (url, data, onUploadProgress) {
    return this.getAxios(onUploadProgress).post(url, data)
  }

  /**
   * Send DELETE HTTP request
   *
   * @param  {String}  url
   * @return  {Promise}
   */
  delete (url, data = null) {
    return this.getAxios().delete(url, data)
  }

  /**
   * Handle with unauthorized requests
   *
   * @return {void}
   */
  unauthorized () {
    this.toast.open({
      state: 'danger',
      message: '<b>Ups!</b> Sua sessão expirou.'
    })

    this.redirect('/entrar')
  }
}

export default ({ env, redirect, app: { $toast } }, inject) => {
  inject('axios', new Axios(env, redirect, $toast))
}
