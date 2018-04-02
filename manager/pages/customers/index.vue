<template>
  <div>
    <page-header
      title="Clientes"
      subtitle="Exbindo todos os clientes"
    />

    <ui-data-grid
      view
      :data="customers"
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

        <b-table-column label="CPF">
          {{ data.props.row.cpf }}
        </b-table-column>

        <b-table-column label="Data de nascimento">
          {{ data.props.row.birthdate }}
        </b-table-column>

        <b-table-column label="Celular">
          {{ data.props.row.phone }}
        </b-table-column>
      </template>

      <p slot="footer">
        Exbindo {{ customers.length }} de {{ meta.total }} registros.
      </p>
    </ui-data-grid>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        meta: null,
        customers: []
      }
    },
    head () {
      return {
        title: 'Clientes'
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('customers')

      return {
        meta: data.meta,
        customers: data.data
      }
    },
    methods: {
      fetch (page) {
        this.loading = true

        this.$axios.get(`customers?page=${page}`).then(({ data }) => {
          this.meta = data.meta
          this.customers = data.data
          this.loading = false
        })
      }
    }
  }
</script>
