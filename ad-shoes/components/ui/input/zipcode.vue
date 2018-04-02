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

  const PATTERN = '99999-999'

  export default {
    props: {
      ...defaultProps,
      value: String
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
        this.$emit('input', VMasker.toNumber(value))
      }
    },
    methods: {
      format (value) {
        if (value) {
          return VMasker.toPattern(value, PATTERN)
        }
      }
    }
  }
</script>
