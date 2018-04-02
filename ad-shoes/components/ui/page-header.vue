<template>
  <div class="page-header" :class="classes">
    <slot></slot>
  </div>
</template>

<script>
  export default {
    props: {
      size: {
        type: String,
        default: 'is-default'
      }
    },
    computed: {
      classes () {
        return {
          'is-small': this.size === 'is-small'
        }
      }
    }
  }
</script>

<style lang="sass">
  .page-header
    font-size: 3rem
    font-weight: bold
    color: #000
    letter-spacing: 2rem
    text-align: center
    text-transform: uppercase
    padding: 0
    margin: 4rem 0 8rem
    border-bottom: none

    &.is-small
      font-size: 2rem

    @media screen and (max-width: 480px)
      font-size: 2rem
      letter-spacing: 1rem
      margin: 20px 10px
</style>
