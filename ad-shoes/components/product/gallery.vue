<template>
  <div class="gallery">
    <div class="gallery-zoom">
      <img :src="current.medium" alt="">
      <div class="btn btn-light btn-circle btn-zoom" @click="zoom">
        <ui-icon name="search"/>
      </div>
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
        current: this.value ? this.value : this.images[0]
      }
    },
    watch: {
      value (value) {
        this.current = value
      }
    },
    methods: {
      zoom () {
        this.$zoom.open({
          src: this.current.medium
        })
      },

      change (image) {
        this.current = image

        this.$emit('input', image)
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
