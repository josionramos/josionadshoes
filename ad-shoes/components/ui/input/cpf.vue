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

  const PATTERN = '999.999.999-99'

  export default {
    props: {
      ...defaultProps,
      value: String
    },
    data () {
      return {
        newValue: ''
      }
    },
    created () {
      if (this.value) {
        this.newValue = this.format(this.value)
      }
    },
    watch: {
      value (value) {
        this.newValue = this.format(value)
      },

      newValue (value) {
        this.$emit('input', value)
      }
    },
    methods: {
      format (value) {
        return VMasker.toPattern(value, PATTERN)
      }
    }
  }
</script>
