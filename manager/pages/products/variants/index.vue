<template>
  <div>
    <page-header
      title="Variações"
      subtitle="Todas as variações de produto"
    />

    <!-- Data Grid -->
    <ui-data-grid
      destroy
      :data="variants"
      :total="meta.total"
      :loading="loading"
      :per-page="meta.per_page"
      :current-page="meta.current_page"
      @destroy="destroy"
      @page-change="fetch"
    >
      <!-- Rows -->
      <template slot-scope="data">
        <!-- Name -->
        <b-table-column label="Nome">
          {{ data.props.row.name }}
        </b-table-column>

        <!-- Created at -->
        <b-table-column label="Data de criação">
          {{ data.props.row.created_at | datetime }}
        </b-table-column>
      </template>

      <p slot="footer">
        Exbindo {{ variants.length }} de {{ meta.total }} registros.
      </p>

      <!-- Empty -->
      <template slot="empty">
        Nenhuma variação cadastrada ainda :/
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
      variants: []
    }
  },
  head () {
    return {
      title: 'Listar variações'
    }
  },
  async asyncData ({ app: { $axios } }) {
    let { data } = await $axios.get('/products/variants/types')

    return {
      meta: data.meta,
      variants: data.data
    }
  },
  methods: {
    fetch (page) {
      this.loading = true

      this.$axios.get(`/products/variants/types?page=${page}`).then(({ data }) => {
        this.loading = false
        this.meta = data.meta
        this.variants = data.data
      })
    },

    /**
     * Confirm delete.
     *
     * @param  {int}  index
     */
    destroy (index) {
      let variant = this.variants[index]

      this.$dialog.confirm({
        message: `Deseja remover a variação <b>${variant.name}</b>?`,
        onConfirm: () => {
          this.delete(index, variant)
        }
      })
    },

    /**
     * Delete a category.
     *
     * @param  {int}     index
     * @param  {Object}  variant
     */
    delete (index, variant) {
      this.$axios.delete(`/products/categories/${variant.id}`).then(() => {
        this.$toast.open({
          message: `Variação <b>${variant.name}</b> removida com sucesso!`,
          type: 'is-success'
        })

        this.variants.splice(index, 1)
      })
    }
  }
}
</script>
