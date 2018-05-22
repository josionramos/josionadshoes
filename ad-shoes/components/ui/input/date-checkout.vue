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
  import moment from 'moment'
  import masker from 'vanilla-masker'

  import defaultProps from './default'

  const PATTERN = '99/99/9999'

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
        this.$emit('input', value)
      }
    },
    methods: {
      format (value) {
        return masker.toPattern(value, PATTERN)
      }
    }
  }
</script>
