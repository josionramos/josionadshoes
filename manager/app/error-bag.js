class ErrorBag {
  constructor (data) {
    this.data = data
  }

  set (data) {
    this.data = data
  }

  has (name) {
    if (this.data) {
      return this.data.errors[name]
    }
  }

  get (name) {
    if (this.has(name)) {
      return this.data.errors[name][0]
    }
  }
}

export default ErrorBag
