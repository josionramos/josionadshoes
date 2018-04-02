import Error from './error'

export default class {
  /**
   * Constructor.
   *
   * @param  {Object}  errors
   * @return {void}
   */
  constructor (fields, $axios) {
    this.busy = false
    this.fields = fields
    this.$axios = $axios
    this.errors = new Error({})
  }

  /**
   * Send HTTP request.
   *
   * @param  {String}  method
   * @param  {String}  url
   * @param  {Object}  data
   * @return {Promise}
   */
  async request (method, url, data = null) {
    return new Promise((resolve, reject) => {
      this.busy = true
      this.errors.clear()

      return this.$axios[method](url, data).then(({ data }) => {
        this.busy = false
        resolve(data)
      }).catch(error => {
        this.busy = false

        if (error.response && error.response.status === 422) {
          this.setError(error.response.data)
        }

        reject(error)
      })
    })
  }

  /**
   * Set response errors.
   *
   * @param  {Object}  errors
   * @return {void}
   */
  setError (errors) {
    this.errors = new Error(errors)
  }

  /**
   * Is sending request?
   *
   * @param  {Object}  errors
   * @return {Boolean}
   */
  isBusy () {
    return this.busy
  }

  /**
   * Set a POST request.
   *
   * @param  {String}  url
   * @return {Promise}
   */
  post (url) {
    return this.request('post', url, this.fields)
  }

  /**
   * Set a PUT request.
   *
   * @param  {String}  url
   * @return {Promise}
   */
  put (url) {
    return this.request('put', url, this.fields)
  }
}
