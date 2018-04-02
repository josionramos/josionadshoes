<template>
  <div>
    <div class="columns">
      <!-- Variants -->
      <div class="column is-4">
        <ui-field name="variant" label="Referência">
          <b-select
            v-model="currentType"
            expanded
            size="is-medium"
            placeholder="Variação"
            @input="changeType"
          >
            <option value="">Selecione</option>
            <option v-for="type in types" :value="type">{{ type.name }}</option>
          </b-select>
        </ui-field>
      </div>

      <!-- Variant values -->
      <div class="column is-8">
        <ui-field name="values" label="Valor">
          <b-taginput
            v-model="tags"
            icon="label"
            type="is-primary"
            placeholder="Adicionar variação"
            :disabled="!currentType"
            @add="add"
            @remove="remove"
          />
        </ui-field>
      </div>
    </div>

    <list
      v-if="showList"
      :types="types"
      :variants="variants"
      :product-id="product.id"
      @added="added"
    />
  </div>
</template>

<script>
  import List from './list'

  export default {
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    components: {
      List
    },
    data () {
      return {
        tags: [],
        types: [],
        loading: false,
        variants: [],
        currentType: null
      }
    },
    mounted () {
      this.fetchTypes()

      Object.keys(this.product.variants).forEach((item, index) => {
        this.variants.push(this.product.variants[item][0])
      })
    },
    computed: {
      showList () {
        return this.types.length > 0 && this.variants.length > 0
      }
    },
    methods: {
      /**
       * Add unsave variant.
       *
       * @param  {String}  value
       * @param  {void}
       */
      add (variant) {
        let item = {
          value: variant,
          price: this.product.price,
          active: false,
          type_id: this.currentType.id
        }

        this.variants.push(item)
      },

      /**
       * Remove unsave variant.
       *
       * @param  {String}  value
       * @param  {void}
       */
      remove (variant) {
        let index = this.variants.findIndex(item => {
          return this.currentType.id === item.type_id && item.value === variant && !item.id
        })

        if (index > -1) {
          this.variants.splice(index, 1)
        }
      },

      /**
       * Clear tags after variant has been added.
       *
       * @param  {Object}  variant
       * @return {void}
       */
      added (variant) {
        if (variant.type_id === this.currentType.id) {
          let index = this.tags.findIndex(val => val === variant.value)

          if (index > -1) {
            this.tags.splice(index, 1)
          }
        }
      },

      /**
       * Change variant type.
       *
       * @param  {void}
       */
      changeType () {
        let tags = []

        console.log(this.variants)

        this.variants.forEach(item => {
          if (item.type_id === this.currentType.id && !item.id) {
            tags.push(item.value)
          }
        })

        this.tags = tags
      },

      /**
       * Fetch variant types.
       *
       * @return {void}
       */
      fetchTypes () {
        this.loading = true
        this.$axios.get('/products/variants/types').then(({ data }) => {
          this.loading = false
          this.types = data.data
        })
      }
    }
  }
</script>
