<template>
  <transition name="fade">
    <div v-show="active" class="zoom-container">
      <div class="zoom">
        <div class="zoom-image">
          <img :src="src" alt="">
        </div>
        <div class="zoom-close" @click="close">
          <ui-icon name="times"/>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
  export default {
    props: {
      src: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        active: false,
        container: null
      }
    },
    beforeMount () {
      this.setup()
    },
    mounted () {
      this.showZoom()
    },
    methods: {
      setup () {
        this.container = document.querySelector('.zoom-wrapper')

        if (this.container) {
          return
        }

        this.container = document.createElement('div')
        this.container.className = 'zoom-wrapper'

        document.body.appendChild(this.container)
      },

      showZoom () {
        this.active = true
        this.container.insertAdjacentElement('afterbegin', this.$el)
      },

      close () {
        this.active = false

        setTimeout(() => {
          this.$destroy()
          this.$el.remove()
        }, 150)
      }
    }
  }
</script>

<style lang="sass">
  .zoom-container
    position: fixed
    top: 0
    left: 0
    width: 100%
    height: 100%
    z-index: 1000
    background: rgba(#000, .8)

  .zoom
    width: 100%
    height: 80vh
    margin: 10vh auto 0

  .zoom-image
    width: 70%
    height: 100%
    margin: 0 auto
    position: relative
    text-align: center
    img
      max-width: 100%
      max-height: 100%
      display: inline-block

  @media screen and (max-width: 768px)
    .zoom
      height: 90vh
    .zoom-image
      width: 90%
      img
        display: block
        position: absolute
        top: 50%
        transform: translateY(-50%)

  .zoom-close
    position: absolute
    top: 1.5rem
    right: 1.5rem
    font-size: 3rem
    color: #fff
    cursor: pointer
</style>
