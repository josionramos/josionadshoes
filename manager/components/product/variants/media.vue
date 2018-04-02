<template>
  <section>
    <div class="modal-card">
      <!-- HEADER -->
      <header class="modal-card-head">
        <p class="modal-card-title has-text-left">Media</p>
      </header>

      <!-- BODY -->
      <section class="modal-card-body">
        <div v-if="!hasFile && !hasMedia" class="has-text-centered">
          <!-- Drag and drop -->
          <b-field>
            <b-upload
              v-model="file"
              drag-drop
              @input="setPreview"
            >
              <section class="section">
                <div class="content has-text-centered">
                  <p><b-icon icon="upload" size="is-large"/></p>
                  <p>Arraste aqui seus arquivos ou clique para enviar</p>
                </div>
              </section>
            </b-upload>
          </b-field>
        </div>
        <!-- Preview -->
        <div v-show="hasFile || hasMedia" class="media-preview">
          <!-- Image -->
          <div class="preview" :class="{ 'is-uploading': isUploading }"></div>

          <!-- Progress -->
          <progress
            v-if="isUploading && !isComplete"
            max="100"
            class="progress is-primary is-medium"
            :value="progress.percent"
          >
            {{ progress.percent }}%
          </progress>
        </div>
      </section>

      <!-- FOOTER -->
      <footer class="modal-card-foot">
        <!-- Save button -->
        <button
          v-if="isComplete"
          class="button is-success"
          @click="attachMedia"
        >
          Salvar
        </button>

        <!-- Delete button -->
        <button
          v-if="hasMedia"
          class="button is-danger"
          @click="detachMedia"
        >
          Remover
        </button>

        <!-- Upload button -->
        <button
          v-if="hasFile && !isComplete"
          class="button is-success"
          :disabled="isUploading"
          @click="upload"
        >
          Upload
        </button>

        <!-- Close button -->
        <button
          class="button"
          type="button"
          @click="close"
        >
          Cancelar
        </button>
      </footer>
    </div>
  </section>
</template>

<script>
  export default {
    props: {
      show: {
        type: Boolean,
        default: false
      },
      variant: {
        type: Object,
        required: true
      },
      galleryId: {
        type: Number,
        required: true
      }
    },
    data () {
      return {
        file: [],
        media: {},
        progress: {
          active: false,
          percent: 1
        }
      }
    },
    mounted () {
      let media = this.variant.media

      if (media && media.id) {
        this.media = media
        this.setPreviewImage(media.medium)
      }
    },
    computed: {
      /**
       * Has file to be upload.
       *
       * @return {Boolean}
       */
      hasFile () {
        return this.file.length > 0
      },

      /**
       * Has media.
       *
       * @return {Boolean}
       */
      hasMedia () {
        return this.media && this.media.id > 0
      },

      /**
       * Is uploading.
       *
       * @return {Boolean}
       */
      isUploading () {
        return this.progress.active
      },

      /**
       * Upload was completed.
       *
       * @return {Boolean}
       */
      isComplete () {
        return !this.hasFile && !this.isUploading && this.hasMedia
      }
    },
    methods: {
      /**
       * Close modal.
       *
       * @return {void}
       */
      close () {
        this.$emit('close')
      },

      /**
       * Set background image preview.
       *
       * @param  mixed  content
       * @return {void}
       */
      setPreviewImage (content) {
        let preview = this.$el.querySelector('.media-preview .preview')

        preview.style.backgroundImage = `url(${content})`
      },

      /**
       * Set preview from file reader.
       *
       * @return {void}
       */
      setPreview () {
        let reader = new FileReader()

        reader.onloadend = () => {
          this.setPreviewImage(reader.result)
        }

        reader.readAsDataURL(this.file[0])
      },

      /**
       * Send upload request.
       *
       * @return {void}
       */
      upload () {
        this.progress.active = true
        let data = new FormData()
        let url = `galleries/${this.galleryId}/media`

        data.append('image', this.file[0])

        this.$axios.upload(url, data, this.onProgress).then(({ data }) => {
          this.file = []
          this.media = data.data
          this.resetProgress()
        }).catch(error => {
          console.log(error)
          this.file = []
          this.resetProgress()
        })
      },

      /**
       * Update upload progress.
       *
       * @param  {ProgressEvent}  progress
       * @return {void}
       */
      onProgress (progress) {
        this.progress.percent = Math.round((progress.loaded * 100) / progress.total)
      },

      resetProgress () {
        this.progress.percent = 1
        this.progress.active = false
      },

      remove () {
        //
      },

      attachMedia () {
        return this.updateVariantMedia({
          media_id: this.media.id
        }).then(() => {
          this.$toast.open({
            message: `Imagem de variação vinculado com sucesso!`,
            type: 'is-success'
          })
        })
      },

      detachMedia () {
        let url = `/products/${this.variant.product_id}/variants/${this.variant.id}`

        return this.$axios.put(url, { media_id: null }).then(() => {
          this.close()

          this.variant['media'] = this.media = null
          this.$emit('update:variant', this.variant)
        })
      },

      /**
       * Save product variant media.
       *
       * @return {void}
       */
      updateVariantMedia (data) {
        let url = `/products/${this.variant.product_id}/variants/${this.variant.id}`

        return this.$axios.put(url, data).then(() => {
          this.close()

          this.variant['media'] = this.media
          this.$emit('update:variant', this.variant)
        })
      }
    }
  }
</script>

<style lang="sass">
  .media-preview
    height: 300px
    position: relative

    .preview
      width: 100%
      height: 100%
      background-size: contain
      background-repeat: no-repeat
      background-position: center
      border: 1px dashed #ccc
      border-radius: 4px
      background-color: #f4f4f4

      &.is-uploading
        opacity: .6

    .progress
      position: absolute
      width: 70%
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
</style>
