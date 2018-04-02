<template>
  <label
    class="radio-color"
    :class="{ 'is-active': isActive }"
    :title="color.value"
  >
    <input type="radio" v-model="newValue" :value="color">
    <span class="checkable" :style="backgroundColor"></span>
  </label>
</template>

<script>
  export default {
    props: {
      value: {},
      color: {
        type: Object,
        required: true
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
        if (value === this.color) {
          this.$emit('input', value)
        }
      }
    },
    computed: {
      isActive () {
        return this.value && this.value.extra === this.color.extra
      },

      backgroundColor () {
        return {
          backgroundColor: this.color.extra ? this.color.extra : 'red'
        }
      }
    }
  }
</script>

<style lang="sass">
  .radio-color
    width: 3.4rem
    height: 3.4rem
    position: relative
    border: 1px solid #898989
    cursor: pointer
    margin-right: 1rem
    display: inline-block

    .checkable
      position: absolute
      top: 50%
      left: 50%
      margin: 0
      width: 1.4rem
      height: 1.4rem
      transform: translate(-50%, -50%)
      background-color: red
      border: none

    &.is-active
      border-color: #000

    input
      display: none

</style>
