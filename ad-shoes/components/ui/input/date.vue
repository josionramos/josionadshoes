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
        if (value.length === 10) {
          value = moment(value).format('DD-MM-YYYY')
        }

        this.newValue = this.format(masker.toNumber(value))
      },

      newValue (value) {
        if (this.newValue === value) {
          let date = moment(value, 'DD-MM-YYYY')

          if (value.length === 10 && date.isValid()) {
            this.$emit('input', date.format('YYYY-MM-DD'))
          } else {
            this.$emit('input', value)
          }
        }
      }
    },
    methods: {
      format (value) {
        return masker.toPattern(value, PATTERN)
      }
    }
  }
</script>
