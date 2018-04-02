<template>
  <div class="card" :class="{ 'is-loading': uploading, 'is-danger': !isValid }">
    <div v-if="isValid" class="card-image">
      <figure class="image"></figure>
    </div>
    <div v-if="!isValid" class="card-content">
      <p class="has-text-danger">
        <b>Ups!</b> Não foi possível enviar!
      </p>
      <br>
      <ul>
        <li v-if="!isValidType"><b-icon type="is-danger" icon="alert-circle-outline" size="is-small"/> O arquivo não é uma imagem</li>
        <li v-if="!isValidSize"><b-icon type="is-danger" icon="alert-circle-outline" size="is-small"/> Máximo <b>{{ size / 1024 }} kB</b></li>
      </ul>
    </div>
    <div class="card-progress">
      <progress
        max="100"
        class="progress is-small"
        :value="progress"
        :class="{ 'is-success': progress >= 100, 'is-danger': !isValid }"
      >
        {{ progress }}%
      </progress>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      file: {
        type: Object,
        required: true
      },
      galleryId: {
        type: Number,
        required: true
      },
      size: Number,
      accept: Array
    },
    data () {
      return {
        progress: 1
      }
    },
    computed: {
      uploading () {
        return this.progress < 100
      },

      isValid () {
        return this.isValidType && this.isValidSize
      },

      isValidSize () {
        console.log(this.file.size, this.size)
        return this.file.size <= this.size
      },

      isValidType () {
        return this.accept.indexOf(this.file.type) > -1
      }
    },
    mounted () {
      if (this.isValid) {
        let reader = new FileReader()
        let preview = this.$el.querySelector('.image')

        reader.onloadend = () => {
          preview.style.backgroundImage = `url(${reader.result})`
          this.upload()
        }

        reader.readAsDataURL(this.file)
      }
    },
    methods: {
      upload () {
        let data = new FormData()
        let url = `galleries/${this.galleryId}/media`

        data.append('image', this.file)

        this.$axios.upload(url, data, this.onProgress).then(({ data }) => {
          this.$emit('uploaded', this.file, data.data)
        })
      },

      onProgress (progress) {
        this.progress = Math.round((progress.loaded * 100) / progress.total)
      }
    }
  }
</script>

<style lang="sass">
  .card-content
    height: 150px

  .card-image
    text-align: center
    .image
      min-height: 150px
      background-size: cover
      background-repeat: no-repeat
      background-position: center

  .card-progress
    height: 3rem
    position: relative
    padding-left: .75rem
    padding-right: .75rem
    border-top: 1px solid #dbdbdb
    .progress
      width: calc(100% - 1.5rem)
      position: absolute
      top: 50%
      transform: translateY(-50%)
</style>
