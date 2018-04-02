<template>
  <ui-numeric
    prefix="R$ "
    :size="size"
    :value="value"
    :maxlength="13"
    :disabled="disabled"
    :placeholder="placeholder"
    @input="input"
  />
</template>

<script>
  export default {
    props: {
      value: {
        default: ''
      },
      disabled: {
        type: Boolean,
        default: false
      },
      size: String,
      placeholder: String
    },
    methods: {
      input (value) {
        this.$emit('input', value)
      }
    }
  }
</script>
