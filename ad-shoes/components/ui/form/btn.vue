<template>
  <button
    class="btn"
    :class="classes"
    :disabled="loading"
    @click="$emit('click')"
  >
    <slot v-if="!loading"/>
    <ui-icon v-else spin name="circle-o-notch"/>
  </button>
</template>

<script>
  export default {
    props: {
      size: {
        type: String
      },
      type: {
        type: String,
        default: 'button'
      },
      state: {
        type: String,
        default: 'primary'
      },
      block: {
        type: Boolean,
        default: false
      },
      loading: {
        type: Boolean,
        default: false
      },
      outlined: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      classes () {
        return [
          'btn-' + this.state,
          this.size ? 'btn-' + this.size : '',
          this.outlined ? 'btn-outlined' : '',
          { 'btn-block': this.block }
        ]
      }
    }
  }
</script>
