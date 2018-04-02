<template>
  <select
    v-model="newValue"
    class="form-control"
    :loading="loading"
    :required="required"
    :disabled="disabled"
  >
    <option
      v-if="placeholder"
      selected
      disabled
      :value="null"
    >
      {{ placeholder.toUpperCase() }}
    </option>
    <slot/>
  </select>
</template>

<script>
  import defaultProps from './default'

  export default {
    props: {
      ...defaultProps,
      value: {
        default: null
      }
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
        this.$emit('input', value)
      }
    }
  }
</script>
