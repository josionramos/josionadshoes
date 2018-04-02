import axios from 'axios'

class Axios {
  /**
   * Constructor
   */
  constructor (env) {
    this.env = env
    this.token = null
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
  send (method, url, data, onUploadProgress = null) {
    let request = {
      url: url,
      data: data,
      method: method,
      baseURL: this.env.API_BASEURL,
      onUploadProgress,
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    }

    if (this.token) {
      request['headers']['Authorization'] = `Bearer ${this.token}`
    }

    return axios(request)
  }

  /**
   * Send POST HTTP request
   *
   * @param  {String}  url
   * @param  {Object}  data
   * @return  {Promise}
   */
  post (url, data) {
    return this.send('POST', url, data)
  }

  /**
   * Send PUT HTTP request
   *
   * @param  {String}  url
   * @param  {Object}  data
   * @return  {Promise}
   */
  put (url, data) {
    return this.send('PUT', url, data)
  }

  /**
   * Send GET HTTP request
   *
   * @param  {String}  url
   * @return  {Promise}
   */
  get (url) {
    return this.send('GET', url)
  }

  /**
   * Send POST HTTP request
   *
   * @param  {String}  url
   * @return  {Promise}
   */
  upload (url, data, onUploadProgress) {
    return this.send('POST', url, data, onUploadProgress)
  }

  /**
   * Send DELETE HTTP request
   *
   * @param  {String}  url
   * @return  {Promise}
   */
  delete (url, data = null) {
    return this.send('DELETE', url, data)
  }
}

export default ({ env }, inject) => {
  inject('axios', new Axios(env))
}
