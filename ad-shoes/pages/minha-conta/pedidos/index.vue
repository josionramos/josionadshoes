<template>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th class="text-right">Valor</th>
          <th class="text-right">Status</th>
          <th class="text-right">Data</th>
          <th> </th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(order, index) in orders">
          <tr>
            <td>{{ order.reference }}</td>
            <td class="text-right">
              <b>{{ order.subTotal | money }}</b>
            </td>
            <td class="text-right">
              <span class="label" :class="statusClass(order.status)">
                {{ order.status.name }}
              </span>
            </td>
            <td class="text-right">{{ order.created_at | datetime }}</td>
            <td class="text-right">
              <nuxt-link :to="{ name: 'minha-conta-pedidos-id', params: { id: order.id } }" class="btn btn-primary btn-outlined">Ver</nuxt-link>
            </td>
          </tr>
        </template>
        <tr v-if="orders.length === 0">
          <td colspan="4" class="text-center">Nenhum pedido realizado ainda.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    head () {
      return {
        title: 'Pedidos'
      }
    },
    data () {
      return {
        orders: []
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('/customers/me/orders?includes=status')

      return {
        orders: data.data
      }
    },
    methods: {
      statusClass (status) {
        return {
          'label-info': status.id === 3,
          'label-default': status.id === 1,
          'label-primary': status.id === 4,
          'label-success': status.id === 5
        }
      }
    }
  }
</script>
