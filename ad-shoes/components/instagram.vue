<template>
  <div class="row no-gutters">
    <a
      v-for="media in medias"
      class="col-md-2 col-sm-3 col-xs-6 instagram-media"
      target="_blank"
      :href="'https://www.instagram.com/loveadshoes'"
    >
      <img :src="media.images.low_resolution.url" class="img-responsive">
      <button class="btn btn-light btn-circle">
        <ui-icon name="instagram"/>
      </button>
    </a>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        medias: []
      }
    },
    mounted () {
      this.$axios.get('/integration/instagram/recent').then(({ data }) => {
        this.medias = data.splice(0, 12)
      })
    }
  }
</script>

<style lang="sass">
  .instagram-media
    cursor: pointer
    position: relative

    .btn
      display: none
      z-index: 100
      opacity: .8
      position: absolute
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)

      .fa
        font-size: 2rem

    &::after
      content: ''
      width: 100%
      height: 100%
      position: absolute
      top: 0
      left: 0
      background: transparent
      transition: background .5s ease

    &:hover
      .btn
        display: inline-block

      &::after
        background: rgba(0, 0, 0, .5)
</style>
