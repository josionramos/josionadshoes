<template>
  <ui-form
    :loading="loading"
    @submit="submit"
  >
    <!-- Name -->
    <b-field
      label="Name"
      name="name"
      :errors="errors"
    >
      <b-input
        required
        v-model="form.name"
        placeholder="Nome"
      />
    </b-field>

    <div class="columns">
      <!-- Category parent -->
      <div class="column is-6">
        <ui-field
            name="parent_id"
            label="Categoria"
            :errors="errors"
          >
            <ui-autocomplete
              field="name"
              placeholder="Categoria"
              :data="categories"
              :value="parent"
              :loading="loadingCategories"
              @input="setCategory"
              @query="fetchCategories"
            />
          </ui-field>
      </div>

      <!-- Status -->
      <div class="column is-6">
        <b-field label="Status">
          <div class="field">
            <b-switch v-model="form.active">
              Categoria {{ form.active ? 'ativada' : 'desativada' }}
            </b-switch>
          </div>
        </b-field>
      </div>
    </div>

    <ui-field name="values" label="Variações padrões">
      <b-taginput
        v-model="form.variants"
        autocomplete
        icon="label"
        type="is-success"
        field="name"
        placeholder="Digite o nome de um tipo variação"
        :data="types"
        :allowNew="true"
      />
    </ui-field>
  </ui-form>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      category: Object
    },
    data () {
      return {
        form: {},
        types: [],
        categories: [],
        loadingTypes: false,
        loadingCategories: false
      }
    },
    created () {
      this.form = this.category
    },
    computed: {
      ...mapGetters({
        errors: 'product/category/errors',
        loading: 'product/category/loading'
      }),

      parent () {
        return this.category.parent ? this.category.parent : {}
      }
    },
    mounted () {
      this.fetchTypes()
    },
    methods: {
      submit () {
        this.$emit('submit', this.form)
      },

      setCategory (category) {
        let id = null

        if (category) {
          id = category.id
        }

        this.form.parent_id = id
      },

      fetchTypes () {
        this.loadingTypes = true

        this.$axios.get('products/variants/types').then(({ data }) => {
          this.types = data.data
          this.loadingTypes = false
        })
      },

      fetchCategories (query) {
        this.loadingCategories = true
        let url = `/products/categories?filter[name]=${query}`

        this.$axios.get(url).then(({ data }) => {
          this.categories = data.data
          this.loadingCategories = false
        })
      }
    }
  }
</script>
