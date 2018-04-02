<template>
  <div>
    <page-header
      title="Categorias"
      subtitle="Todas as categorias de produto"
    >
      <nuxt-link to="categories/create" class="button is-primary">Novo</nuxt-link>
    </page-header>

    <ui-data-grid
      edit
      destroy
      :data="categories"
      :total="meta.total"
      :loading="loading"
      :per-page="meta.per_page"
      :current-page="meta.current_page"
      @edit="edit"
      @destroy="destroy"
      @page-change="fetch"
    >
      <template slot-scope="data">
        <!-- Name -->
        <b-table-column label="Nome">
          {{ data.props.row.name }}
        </b-table-column>

        <!-- Parent -->
        <b-table-column label="Mãe">
          <nuxt-link
            v-if="data.props.row.parent"
            :to="{ name: 'products-categories-id', params: { id: data.props.row.parent.id } }"
          >
            {{ data.props.row.parent.name }}
          </nuxt-link>
          <p v-else>-</p>
        </b-table-column>

        <!-- Active -->
        <b-table-column label="Ativo" centered>
          <span v-if="data.props.row.active" class="tag is-success">Ativo</span>
          <span v-else class="tag is-danger">Desativado</span>
        </b-table-column>

        <!-- Created at -->
        <b-table-column label="Data de criação">
          {{ data.props.row.created_at | datetime }}
        </b-table-column>
      </template>

      <p slot="footer">
        Exbindo {{ categories.length }} de {{ meta.total }} registros.
      </p>

      <template slot="empty">
        Nenhuma categoria cadastrada ainda :/
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
      categories: []
    }
  },
  async asyncData ({ app: { $axios } }) {
    let { data } = await $axios.get('/products/categories?includes=parent')

    return {
      meta: data.meta,
      categories: data.data
    }
  },
  head () {
    return {
      title: 'Listar categorias'
    }
  },
  methods: {
    fetch (page) {
      this.loading = true
      let url = `/products/categories?includes=parent&page=${page}`

      this.$axios.get(url).then(({ data }) => {
        this.meta = data.meta
        this.categories = data.data

        this.loading = false
      })
    },

    edit (index) {
      let category = this.categories[index]

      this.$router.push({
        name: 'products-categories-id',
        params: {
          id: category.id
        }
      })
    },

    destroy (index) {
      let category = this.categories[index]

      this.$dialog.confirm({
        message: `Deseja remover a categoria <b>${category.name}</b>?`,
        onConfirm: () => {
          this.delete(index, category)
        }
      })
    },

    delete (index, category) {
      this.$axios.delete(`/products/categories/${category.id}`).then(() => {
        this.$toast.open({
          message: `Categoria <b>${category.name}</b> removida com sucesso!`,
          type: 'is-success'
        })

        this.categories.splice(index, 1)
      })
    }
  }
}
</script>
