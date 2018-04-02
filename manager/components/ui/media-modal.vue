<template>
  <section>
      <div class="modal-card">
        <!-- HEADER -->
        <header class="modal-card-head">
          <p class="modal-card-title has-text-left">Media</p>
        </header>

        <!-- BODY -->
        <section class="modal-card-body">

          <div v-if="!hasFile" class="has-text-centered">
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
          <div v-show="hasFile" class="media-preview">
            <!-- Image -->
            <div class="preview" :class="{ 'is-uploading': uploading }"></div>

            <!-- Progress -->
            <progress
              v-if="uploading && progress <= 100"
              max="100"
              class="progress is-primary is-medium"
              :value="progress"
            >
              {{ progress }}%
            </progress>
          </div>
        </section>

        <!-- FOOTER -->
        <footer class="modal-card-foot">
          <!-- Save button -->
          <button
            v-if="complete"
            class="button is-success"
            @click="save"
          >
            Salvar
          </button>

          <!-- Delete button -->
          <button
            v-if="variant.media"
            class="button is-danger"
          >
            Remover
          </button>

          <!-- Upload button -->
          <button
            v-if="!complete && !hasMedia"
            class="button is-success"
            :disabled="!hasFile"
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
        progress: 1,
        uploading: false
      }
    },
    mounted () {
      if (this.variant.media && this.variant.media.id) {
        this.media = this.variant.media
      }
    },
    computed: {
      hasFile () {
        return this.file.length > 0
      },

      hasMedia () {
        return this.media && this.media.id
      },

      complete () {
        return this.hasFile && this.progress === 100
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
       * Set image preview.
       *
       * @return {void}
       */
      setPreview () {
        let reader = new FileReader()
        let preview = this.$el.querySelector('.media-preview .preview')

        reader.onloadend = () => {
          preview.style.backgroundImage = `url(${reader.result})`
        }

        reader.readAsDataURL(this.file[0])
      },

      /**
       * Send upload request.
       *
       * @return {void}
       */
      upload () {
        this.uploading = true
        let data = new FormData()
        let url = `galleries/${this.galleryId}/media`

        data.append('image', this.file[0])

        this.$axios.upload(url, data, this.onProgress).then(({ data }) => {
          this.media = data.data
          this.uploading = false
        }).catch(error => {
          console.log(error)
          this.progress = 1
          this.uploading = false
        })
      },

      /**
       * Update upload progress.
       *
       * @param  {ProgressEvent}  progress
       * @return {void}
       */
      onProgress (progress) {
        this.progress = Math.round((progress.loaded * 100) / progress.total)
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

      &.is-uploading
        opacity: .6

    .progress
      position: absolute
      width: 70%
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
</style>
