<template>
  <div>
    <!-- Drag and Drop -->
    <div v-if="showUploader" class="gallery-upload has-text-centered">
      <b-field>
        <b-upload
          v-model="files"
          multiple
          drag-drop
        >
          <section class="section">
            <div class="content has-text-centered">
              <p><b-icon icon="upload" size="is-large"/></p>
              <p>Arraste aqui seus arquivos ou clique para enviar</p>
            </div>
          </section>
        </b-upload>
      </b-field>
      <br>
      <br>
    </div>

    <div class="columns is-multiline">
      <!-- Uploading -->
      <div v-for="file in files" class="column is-3">
        <ui-imgupload
          :file="file"
          :size="size"
          :accept="accept"
          :gallery-id="1"
          @uploaded="uploaded"
        />
      </div>

      <!-- Uploaded -->
      <div v-for="image in images" class="column is-3">
        <gallery-item
          :image="image"
          :current-cover="product.cover"
          @destroy="destroy"
          @setCover="setCover"
        />
      </div>
    </div>

    <!-- Send more button -->
    <div class="has-text-centered">
      <button v-if="!showUploader" class="button is-primary is-outlined" @click="showUploader = true">
        <b-icon icon="image"/>
        <span>Enviar mais imagens</span>
      </button>
    </div>
  </div>
</template>

<script>
  import GalleryItem from './item'

  export default {
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    components: {
      GalleryItem
    },
    data () {
      return {
        size: 8192 * 1024,
        files: [],
        accept: [
          'image/png',
          'image/jpeg'
        ],
        images: [],
        showUploader: false
      }
    },
    mounted () {
      this.images = this.product.images
    },
    methods: {
      /**
       * Remove file from queue
       */
      removeFile (index) {
        this.files.splice(index, 1)
      },

      /**
       * When file has been uploaded
       */
      uploaded (file, media) {
        let url = `products/${this.product.id}/media`

        this.$axios.post(url, { id: media.id }).then(({ data }) => {
          let index = this.files.findIndex(item => item.name === file.name)
          this.removeFile(index)
          this.images.push(data.data)
        })
      },

      destroy (media) {
        let url = `products/${this.product.id}/media`

        this.$axios.delete(url, { id: media.id }).then(() => {
          let index = this.images.findIndex(item => item.id === media.id)
          this.images.splice(index, 1)
        })
      },

      setCover (image) {
        let url = `products/${this.product.id}/cover`
        this.product.cover = image

        this.$axios.post(url, { id: image.id }).then(() => {
          //
        })
      }
    }
  }
</script>
