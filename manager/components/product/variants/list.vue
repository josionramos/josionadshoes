<template>
  <div>
    <b-table
      bordered
      checkable
      :data="variants"
      :loading="loading"
      :checked-rows.sync="selected"
    >
      <template slot-scope="props">
        <!-- Type -->
        <b-table-column label="Referência">
          {{ getType(props.row.type_id).name }}
        </b-table-column>

        <!-- Value -->
        <b-table-column label="Variação">
          {{ props.row.value }}
        </b-table-column>

        <!-- Price -->
        <b-table-column width="180" label="Preço">
          <ui-money v-model="props.row.price" size="is-small" :disabled="props.row.hasOwnProperty('id')"/>
        </b-table-column>

        <!-- Extra -->
        <b-table-column width="180" label="Extra">
          <b-input v-model="props.row.extra" size="is-small"/>
        </b-table-column>

        <!-- Image -->
        <b-table-column width="110" centered label="Imagem">
          <button
            class="button is-primary is-small"
            :disabled="!props.row.hasOwnProperty('id')"
            @click="openMedia(props.row)"
          >
            <b-icon icon="image-area"/>
            <!-- @click="mediaShowId = props.row.id" -->
          </button>
        </b-table-column>

        <!-- Active -->
        <b-table-column width="110" centered label="Ativo">
          <div class="field">
            <b-switch
              v-model="props.row.active"
              :disabled="!props.row.hasOwnProperty('id')"
              @input="toggleActive(props.row, $event)"
            />
          </div>
        </b-table-column>

        <!-- Actions -->
        <b-table-column width="80" centered label="Ações">
          <div class="field is-grouped" style="justify-content: center;">
            <p v-if="!props.row.id" class="control">
              <button class="button is-success is-small" @click="store(props.row, props.index)">
                <b-icon icon="check-circle"/>
              </button>
            </p>
            <p v-if="props.row.id" class="control">
              <button class="button is-success is-small" @click="update(props.row)" style="margin-right: .25rem;">
                <b-icon icon="check-circle"/>
              </button>
              <button class="button is-danger is-small" @click="destroy(props.index)">
                <b-icon icon="delete"/>
              </button>
            </p>
          </div>
        </b-table-column>
      </template>
    </b-table>
  </div>
</template>

<script>
  import Media from './media'

  export default {
    props: {
      types: {
        type: Array,
        default: []
      },
      variants: {
        type: Array,
        default: []
      },
      productId: {
        type: Number,
        required: true
      }
    },
    components: {
      Media
    },
    data () {
      return {
        loading: false,
        selected: [],
        hasChanged: [],
        mediaShowId: null
      }
    },
    methods: {
      store (variant, index) {
        this.loading = true
        let url = `/products/${this.productId}/variants`

        this.$axios.post(url, variant).then(({ data }) => {
          this.variants.splice(index, 1, data.data)
          this.$emit('update:variants', this.variants)
          this.$emit('added', data.data)
          this.loading = false
        })
      },

      openMedia (variant) {
        this.$modal.open({
          parent: this,
          component: Media,
          props: {
            variant,
            galleryId: 1
          }
        })
      },

      destroy (index) {
        let variant = this.variants[index]

        this.$dialog.confirm({
          message: `Deseja remover a variação <b>${variant.value}</b>?`,
          onConfirm: () => {
            this.delete(index, variant)
          }
        })
      },

      delete (index, variant) {
        this.loading = true
        let url = `/products/${this.productId}/variants/${variant.id}`

        this.$axios.delete(url, variant).then(() => {
          this.variants.splice(index, 1)
          this.$emit('update:variants', this.variants)
          this.loading = false
        })
      },

      update ({ id, extra }) {
        console.log(extra)
        this.loading = true
        let url = `/products/${this.productId}/variants/${id}`

        this.$axios.put(url, { extra }).then(() => {
          this.$toast.open({
            type: 'is-success',
            message: 'Variação atualizada com sucesso!'
          })
          this.loading = false
        })
      },

      toggleActive (variant, active) {
        this.loading = true
        let url = `/products/${this.productId}/variants/${variant.id}`

        this.$axios.put(url, { active }).then(() => {
          this.$toast.open({
            type: 'is-success',
            message: `Variação ${ active ? 'ativada' : 'desativada' } com sucesso!`
          })
          this.loading = false
        })
      },

      getType (typeId) {
        return this.types.find(item => item.id === typeId)
      }
    }
  }
</script>
