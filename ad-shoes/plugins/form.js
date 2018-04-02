import Form from '@/app/form'

class FormHandler {
  constructor ($axios) {
    this.$axios = $axios
  }

  form (fields) {
    return new Form(fields, this.$axios)
  }
}

export default ({ $axios }, inject) => {
  inject('form', new FormHandler($axios).form)
}
