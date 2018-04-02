<template>
  <i class="fa" :class="classes" aria-hidden="true"></i>
</template>

<script>
  export default {
    props: {
      name: {
        type: String,
        required: true
      },
      spin: {
        type: Boolean,
        default: false
      },
      size: String,
      type: String
    },
    computed: {
      classes () {
        return [
          `fa-${this.name}`,
          `text-${this.type}`,
          this.size ? `fa-${this.size}` : '',
          this.spin ? `fa-fw fa-spin` : ''
        ]
      }
    }
  }
</script>
