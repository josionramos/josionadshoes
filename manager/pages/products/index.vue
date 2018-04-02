<template>
  <div>
    <page-header
      title="Produtos"
      subtitle="Todos os produtos cadastrados"
    >
      <nuxt-link to="products/create" class="button is-primary">Novo</nuxt-link>
    </page-header>

    <ui-data-grid
      edit
      destroy
      :data="products"
      :total="meta.total"
      :loading="loading"
      :per-page="meta.per_page"
      :current-page="meta.current_page"
      @edit="edit"
      @destroy="destroy"
      @page-change="fetch"
    >
      <template slot-scope="data">
        <!-- NAME -->
        <b-table-column label="Nome">
          {{ data.props.row.name }}
        </b-table-column>

        <!-- NAME -->
        <b-table-column label="SKU">
          {{ data.props.row.sku }}
        </b-table-column>

        <!-- PRICE -->
        <b-table-column label="Preço" numeric>
          {{ data.props.row.price | money }}
        </b-table-column>

        <!-- ACTIVE -->
        <b-table-column label="Ativo" centered>
          <span v-if="data.props.row.active" class="tag is-success">Ativo</span>
          <span v-else class="tag is-danger">Desativado</span>
        </b-table-column>

        <!-- FEATURED -->
        <b-table-column label="Destaque" centered>
          <span v-if="data.props.row.featured" class="tag is-primary">Destaque</span>
        </b-table-column>

        <!-- CATEGORY -->
        <b-table-column label="Categoria">
          {{ data.props.row.category.name }}
        </b-table-column>

        <!-- CREATED AT -->
        <b-table-column label="Data de criação">
          {{ data.props.row.created_at | datetime }}
        </b-table-column>
      </template>

      <p slot="footer">
        Exbindo {{ products.length }} de {{ meta.total }} registros.
      </p>

      <template slot="empty">
        Nenhuma produto cadastrado ainda :/
      </template>
    </ui-data-grid>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        meta: {},
        loading: false,
        products: []
      }
    },
    head () {
      return {
        title: 'Produtos'
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('/products?includes=seo,images,variants,shipping,category')

      return {
        meta: data.meta,
        products: data.data
      }
    },
    methods: {
      fetch (page) {
        let url = `/products?includes=seo,images,variants,shipping,category&page=${page}`
        this.loading = true

        this.$axios.get(url).then(({ data }) => {
          this.meta = data.meta
          this.products = data.data
          this.loading = false
        })
      },

      edit (index) {
        let product = this.products[index]

        this.$router.push({
          name: 'products-id',
          params: { id: product.id }
        })
      },

      destroy (index) {
        let product = this.products[index]

        this.$dialog.confirm({
          message: `Deseja remover o produto <b>${product.name}</b>?`,
          onConfirm: () => {
            this.delete(index, product)
          }
        })
      },

      delete (index, product) {
        this.$axios.delete(`/products/${product.id}`).then(() => {
          this.$toast.open({
            type: 'is-success',
            message: `Produto <b>${product.name}</b> removido com sucesso!`
          })

          this.products.splice(index, 1)
        }).catch(() => {
          this.$toast.open({
            type: 'is-danger',
            message: `Não é mais possível remover o produto <b>${product.name}</b>!`
          })
        })
      }
    }
  }
</script>
