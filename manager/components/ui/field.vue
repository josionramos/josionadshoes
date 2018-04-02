<template>
  <b-field
    :type="type"
    :label="label"
    :message="message"
  >
    <slot></slot>
  </b-field>
</template>

<script>
  export default {
    props: {
      name: {
        type: String,
        required: true
      },
      label: String,
      errors: Object
    },
    computed: {
      type () {
        return this.hasError() ? 'is-danger' : ''
      },
      message () {
        if (this.hasError()) {
          return this.errors.get(this.name)
        }
      }
    },
    methods: {
      hasError () {
        return typeof this.errors !== 'undefined' && this.errors.has(this.name)
      }
    }
  }
</script>
