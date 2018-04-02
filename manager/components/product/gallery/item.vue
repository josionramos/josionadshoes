<template>
  <div class="card">
    <div class="card-image">
      <figure class="image" :style="imageStyle"></figure>
    </div>
    <footer class="card-footer">
      <a v-if="!isCurrentCover" href="#" class="card-footer-item" @click.prevent="setCover">
        Capa
      </a>
      <p v-else class="card-footer-item">
        <b>Capa</b>
      </p>
      <a href="#" class="card-footer-item" @click.prevent="destroy">Excluir</a>
    </footer>
  </div>
</template>

<script>
  export default {
    props: {
      image: {
        type: Object,
        required: true
      },
      currentCover: {
        type: Object
      }
    },
    data () {
      return {
        loading: false
      }
    },
    computed: {
      imageStyle () {
        return {
          'background-image': `url(${this.image.thumbnail})`
        }
      },

      isCurrentCover () {
        if (this.currentCover) {
          return this.currentCover.id === this.image.id
        }

        return false
      }
    },
    methods: {
      destroy () {
        this.loading = true
        this.$emit('destroy', this.image)
      },

      setCover () {
        this.$emit('setCover', this.image)
      }
    }
  }
</script>

<style lang="sass">
  .card-image
    text-align: center
    .image
      min-height: 150px
      background-size: cover
      background-repeat: no-repeat
      background-position: center
</style>
