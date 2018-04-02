<template>
  <div class="alert" :class="stateClass">
    <slot/>
  </div>
</template>

<script>
  export default {
    props: {
      state: {
        type: String,
        default: 'primary'
      }
    },
    computed: {
      stateClass () {
        return 'alert-' + this.state
      }
    }
  }
</script>
