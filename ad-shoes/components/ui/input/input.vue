<template>
  <input
    v-model="newValue"
    class="form-control"
    :type="type"
    :class="classes"
    :required="required"
    :disabled="disabled"
    :placeholder="placeholder"
    :maxLength="maxLength"
  >
</template>

<script>
  import defaultProps from './default'

  export default {
    props: {
      ...defaultProps,
      type: {
        type: String,
        default: 'text'
      },
      value: {
        default: ''
      },
      maxLength: Number
    },
    data () {
      return {
        newValue: this.value
      }
    },
    watch: {
      value (value) {
        this.newValue = value
      },

      newValue (value) {
        if (this.newValue === value) {
          this.$emit('input', value)
        }
      }
    },
    computed: {
      classes () {
        return [
          this.size ? 'input-' + this.size : ''
        ]
      }
    }
  }
</script>
