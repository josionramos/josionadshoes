<template>
  <button
    class="button"
    :type="type"
    :class="btnClasses"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
    <slot/>
  </button>
</template>

<script>
  export default {
    props: {
      type: {
        type: String,
        default: 'button'
      },
      state: {
        type: String,
        default: 'default'
      },
      loading: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      btnClasses () {
        return [
          `is-${this.state}`,
          { 'is-loading': this.loading }
        ]
      }
    }
  }
</script>
