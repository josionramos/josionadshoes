<template>
  <div>
    <div class="columns">
      <!-- NAME -->
      <div class="column is-half">
        <ui-field
          name="name"
          label="Nome"
          :errors="errors"
        >
          <b-input
            required
            v-model="product.name"
            placeholder="Nome"
          />
        </ui-field>
      </div>

      <!-- CATEGORY -->
      <div class="column is-half">
        <ui-field
          name="category_id"
          label="Categoria"
          :errors="errors"
        >
          <ui-autocomplete
            field="name"
            placeholder="Categoria"
            :data="categories"
            :value="category"
            :loading="loading"
            @input="setCategory"
            @query="fetchCategories"
          />
        </ui-field>
      </div>
    </div>

    <div class="columns">
      <!-- PRICE -->
      <div class="column is-half">
        <ui-field
          name="price"
          label="Preço"
          :errors="errors"
        >
          <ui-money
            v-model="product.price"
            placeholder="Preço"
          />
        </ui-field>
      </div>

      <!-- PROMOTION -->
      <div class="column is-half">
        <ui-field
          name="price_sale"
          label="Preço promocional"
          :errors="errors"
        >
          <ui-money
            v-model="product.price_sale"
            placeholder="Preço promocional"
          />
        </ui-field>
      </div>
    </div>

    <div class="columns">
      <div class="column is-half">
        <ui-field
          name="sku"
          label="SKU"
          :errors="errors"
        >
          <b-input
            required
            v-model="product.sku"
            placeholder="Código de referência"
          />
        </ui-field>
      </div>
      <div class="column is-half">
        <div class="columns">
          <!-- STATUS -->
          <div class="column is-half">
            <ui-field
              name="active"
              label="Visível"
              :errors="errors"
            >
              <div class="field">
                <b-switch v-model="product.active">
                  Produto {{ product.active ? 'visivel' : 'oculto' }}
                </b-switch>
              </div>
            </ui-field>
          </div>
          <!-- FEATURED -->
          <div class="column is-half">
            <ui-field
              name="featured"
              label="Destaque"
              :errors="errors"
            >
              <div class="field">
                <b-switch v-model="product.featured">
                  Produto em destaque
                </b-switch>
              </div>
            </ui-field>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        loading: false,
        categories: []
      }
    },
    computed: {
      ...mapGetters({
        errors: 'product/errors'
      }),

      category () {
        return this.product.category ? this.product.category : {}
      }
    },
    methods: {
      setCategory (category) {
        let id = null

        if (category) {
          id = category.id
        }

        this.product.category_id = id
      },

      fetchCategories (query) {
        this.loading = true
        let url = `/products/categories?filter[name]=${query}`

        this.$axios.get(url).then(({ data }) => {
          this.categories = data.data
          this.loading = false
        })
      }
    }
  }
</script>
