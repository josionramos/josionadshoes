<template>
  <div>
    <page-header
      title="Pedidos"
      subtitle="Exibindo todos os pedidos"
    />

    <ui-data-grid
      view
      :data="orders"
      :total="meta.total"
      :loading="loading"
      :per-page="meta.per_page"
      :current-page="meta.current_page"
      @view="view"
      @page-change="fetch"
    >
      <template slot="filter">
        <p class="control is-expanded">
          <b-input v-model="reference" placeholder="Número do pedido"/>
        </p>
        <p class="control">
          <a class="button is-info" @click.prevent="filter">
            <b-icon icon="filter" size="is-small"/>
          </a>
        </p>
      </template>

      <template slot-scope="data">
        <!-- REF -->
        <b-table-column label="ID">
          {{ data.props.row.reference }}
        </b-table-column>

        <!-- CUSTOMER -->
        <b-table-column label="Cliente">
          {{ data.props.row.customer.name }}
        </b-table-column>

        <!-- STATUS -->
        <b-table-column centered label="Status">
          <span class="tag" :class="statusClass(data.props.row.status.id)">
            {{ data.props.row.status.name }}
          </span>
        </b-table-column>

        <!-- TOTAL -->
        <b-table-column numeric label="Total">
          {{ data.props.row.total | money }}
        </b-table-column>

        <!-- CREATED AT -->
        <b-table-column numeric label="Emissão">
          {{ data.props.row.created_at | datetime }}
        </b-table-column>
      </template>

      <p slot="footer">
        Exbindo {{ orders.length }} de {{ meta.total }} registros.
      </p>

      <template slot="empty">
        Nenhuma pedido foi realizado ainda :/
      </template>
    </ui-data-grid>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        meta: {},
        orders: [],
        loading: false,
        reference: ''
      }
    },
    head () {
      return {
        title: 'Pedidos'
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('/orders?includes=status,customer')

      return {
        meta: data.meta,
        orders: data.data
      }
    },
    methods: {
      fetch (page) {
        this.loading = true

        this.$axios.get(`orders?includes=status,customer&page=${page}`).then(({ data }) => {
          this.meta = data.meta
          this.orders = data.data
          this.loading = false
        })
      },

      view (index) {
        let order = this.orders[index]

        this.$router.push({
          name: 'orders-id',
          params: {
            id: order.id
          }
        })
      },

      filter () {
        this.loading = true

        this.$axios.get(`orders?includes=status,customer&filter[reference]=${this.reference}`).then(({ data }) => {
          this.meta = data.meta
          this.orders = data.data
          this.loading = false
        })
      },

      statusClass (id) {
        let className

        switch (id) {
          case 3:
            className = 'is-warning'
            break
          case 4:
            className = 'is-info'
            break
          case 5:
            className = 'is-success'
            break
          default:
            className = 'is-light'
        }

        return className
      }
    }
  }
</script>
