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

  const PATTERNS = {
    old: '(99) 9999-9999',
    new: '(99) 99999-9999'
  }

  export default {
    props: {
      ...defaultProps,
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
        this.$emit('input', value)
      }
    },
    methods: {
      format (value) {
        let mask = PATTERNS.old

        // If 9 comes after DDD, then change the mask "(DD) 9"
        if (value.length >= 6 && value[5] === '9') {
          mask = PATTERNS.new
        }

        return VMasker.toPattern(value, mask)
      }
    }
  }
</script>
