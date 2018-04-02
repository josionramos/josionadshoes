<template>
  <input
    v-model="newValue"
    type="text"
    class="form-control"
    :required="required"
    :disabled="disabled"
    :placeholder="placeholder"
  />
</template>

<script>
  import VMasker from 'vanilla-masker'

  import defaultProps from './default'

  export default {
    props: {
      ...defaultProps,
      mask: {
        type: String,
        required: true
      },
      value: {
        default: ''
      }
    },
    data () {
      return {
        newValue: this.format(this.value)
      }
    },
    watch: {
      value (value) {
        this.newValue = this.format(value)
      },

      newValue (value) {
        if (this.newValue === value) {
          this.$emit('input', value)
        }
      }
    },
    methods: {
      format (value) {
        return VMasker.toPattern(value, this.mask)
      }
    }
  }
</script>
