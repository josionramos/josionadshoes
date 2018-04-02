<template>
  <div v-show="isActive" class="toast" :class="stateClass">
    <div v-html="message"/>
  </div>
</template>

<script>
  export default {
    props: {
      state: {
        type: String,
        default: 'success'
      },
      message: String
    },
    data () {
      return {
        timer: null,
        isActive: false,
        container: null
      }
    },
    beforeMount () {
      this.setup()
    },
    mounted () {
      this.showToast()
    },
    computed: {
      stateClass () {
        return 'toast-' + this.state
      }
    },
    methods: {
      setup () {
        this.container = document.querySelector('.toast-container')

        if (this.container) {
          return
        }

        this.container = document.createElement('div')
        this.container.className = 'toast-container'

        document.body.appendChild(this.container)
      },

      showToast () {
        this.isActive = true
        this.container.insertAdjacentElement('afterbegin', this.$el)

        this.timer = setTimeout(() => this.close(), 2000)
      },

      close () {
        clearTimeout(this.timer)
        this.isActive = false

        setTimeout(() => {
          this.$destroy()
          this.$el.remove()
        }, 150)
      }
    }
  }
</script>

<style lang="sass">
  .toast-container
    position: fixed
    display: inline-block
    top: 2rem
    left: 50%
    z-index: 100
    text-align: center
    transform: translateX(-50%)

  .toast
    opacity: .9
    position: relative
    padding: .75em 1.5em
    padding-right: 2.75rem
    border-radius: 2rem

  .toast-success
    color: #fff
    background: #23d160

  .toast-danger
    color: #fff
    background: #ff3860
</style>
