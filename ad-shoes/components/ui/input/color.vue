<template>
  <label
    class="radio-color"
    :class="{ 'is-active': isActive }"
    :title="color.value"
  >
    <input type="radio" name="option-color" v-model="radioValue" v-bind:value="color">
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
      console.log('data color: ' + this.color.value)
      return {
        newValue: this.color
      }
    },

    computed: {
      radioValue: {
        get: function valueradio () {
          console.log('get radioValue color value : ' + this.color.value)
          if (this.value) {
            return this.color
          }
        },
        set: function valueradio (cor) {
          console.log('set radioValue color value : ' + cor.value)
          // if (cor === this.value) {
          // console.log('set radioValue color value Not emit:')
          // } else {
          this.$emit('changeButton', cor)
          // }
        }
      },

      isActive () {
        if (this.value) {
          console.log('isActive value : ' + this.value.value)
        }
        if (this.newValue) {
          console.log('isActive newValue : ' + this.newValue.value)
        }
        // return this.value && this.value.extra === this.color.extra
        return this.value === this.newValue
      },

      backgroundColor () {
        return {
          backgroundColor: this.color.extra
          // backgroundColor: this.color.extra ? this.color.extra : 'red'
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

    .input
      display: none

</style>
