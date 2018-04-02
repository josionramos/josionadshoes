<template>
  <div>
    <page-header
      title="Usuários"
      subtitle="Exbindo todos os usuários do sistema"
    />
    <ui-data-grid
      :data="users"
      :total="meta.total"
      :loading="loading"
      :per-page="meta.per_page"
      :current-page="meta.current_page"
      @page-change="fetch"
    >
      <template slot-scope="data">
        <b-table-column label="Nome">
          {{ data.props.row.name }}
        </b-table-column>

        <b-table-column label="E-mail">
          {{ data.props.row.email }}
        </b-table-column>

        <b-table-column label="Data de criação">
          {{ data.props.row.created_at | datetime }}
        </b-table-column>
      </template>

      <p slot="footer">
        Exbindo {{ users.length }} de {{ meta.total }} registros.
      </p>
    </ui-data-grid>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        meta: null,
        users: [],
        loading: false
      }
    },
    head () {
      return {
        title: 'Usuários'
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('/users')

      return {
        meta: data.meta,
        users: data.data
      }
    },
    methods: {
      fetch (page) {
        this.loading = true

        this.$axios.get(`users?page=${page}`).then(({ data }) => {
          this.meta = data.meta
          this.users = data.data
          this.loading = false
        })
      }
    }
  }
</script>
