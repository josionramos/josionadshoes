<template>
  <div class="form-group" :class="{ 'has-error': hasError }">
    <label v-if="label">{{ label }}</label>
    <slot></slot>
    <span v-if="hasError" class="help-block">{{ error }}</span>
  </div>
</template>

<script>
  export default {
    props: {
      label: String,
      field: String,
      errors: Object
    },
    computed: {
      hasError () {
        return this.field && this.errors.has(this.field)
      },

      error () {
        if (this.hasError) {
          return this.errors.get(this.field)
        }
      }
    }
  }
</script>
