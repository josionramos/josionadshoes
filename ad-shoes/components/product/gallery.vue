<template>
  <div class="gallery" @mouseover="pauseLoop" @mouseleave="resume">
    <div class="gallery-zoom" @click="zoom">
      <img :src="current.medium" alt="">
    </div>
    <ol class="list-unstyled gallery-dots">
      <li
        v-for="image in images"
        :class="{ active: current.id === image.id }"
        @click="change(image)"
      >
        {{ image.id }}
      </li>
    </ol>
  </div>
</template>

<script>
  export default {
    props: {
      images: {
        type: Array,
        required: true
      },
      value: Object
    },
    data () {
      return {
        current: this.value ? this.value : this.images[0],
        currentIndex: 0,
        pause: false
      }
    },
    watch: {
      value (value) {
        this.current = value
      }
    },
    mounted () {
      this.loop()
    },
    methods: {
      zoom () {
        this.$zoom.open({
          src: this.current.medium
        })
      },

      pauseLoop () {
        // console.log('pauseLoop')
        this.pause = true
        // console.log('this.pause: ' + this.pause)
      },

      resume () {
        // console.log('resume')
        this.pause = false
        // console.log('this.pause: ' + this.pause)
      },

      change (image) {
        this.current = image

        this.$emit('input', image)
      },

      loop () {
        // console.log('loop')
        let self = this

        setInterval(function () {
          if (!self.pause) {
            if (self.currentIndex === self.images.length - 1) {
              self.currentIndex = 0
            } else {
              self.currentIndex++
            }
            console.log('currentIndex ' + self.currentIndex)
            self.change(self.images[self.currentIndex])
          }
        }, 5000)
      }
    }
  }
</script>

<style lang="sass">
  // Zoom
  .gallery-zoom
    position: relative
    text-align: center
    border: 1px solid #898989
    cursor: zoom-in

    img
      display: inline-block
      max-height: 300px

    .btn-zoom
      position: absolute
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)

  // Dots
  .gallery-dots
    margin: 2rem 0
    text-align: center

    li
      display: inline-block
      width: 2rem
      height: 2rem
      margin: 0 .5rem
      font-size: 0
      cursor: pointer
      border: 1px solid #000

      &.active
        background: #000
</style>
