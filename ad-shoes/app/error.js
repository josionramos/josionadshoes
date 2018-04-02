export default class {
  /**
   * Constructor.
   *
   * @param  {Object}  data
   * @return {void}
   */
  constructor (data) {
    this.data = data
  }

  /**
   * Check if has errors.
   *
   * @return {Boolean}
   */
  hasErrors () {
    return this.data.hasOwnProperty('errors')
  }

  /**
   * Check if field name has errors.
   *
   * @param  {String}  name
   * @return {Boolean}
   */
  has (name) {
    return this.hasErrors() && this.data.errors.hasOwnProperty(name)
  }

  /**
   * Get all errors.
   *
   * @return {Array}
   */
  all () {
    if (this.hasErrors()) {
      return this.data.errors
    }
  }

  /**
   * Get message error from field name.
   *
   * @param  {String}  name
   * @return {String}
   */
  get (name) {
    if (this.has(name)) {
      return this.data.errors[name][0]
    }
  }

  clear () {
    this.data = []
  }
}
