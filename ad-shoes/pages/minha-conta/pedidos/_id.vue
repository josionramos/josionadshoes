<template>
  <div>
    <table class="table table-bordered order-header">
      <tbody>
        <tr>
          <td>
            <h4 class="h4 text-uppercase">
              Pedido #{{ order.reference }}
            </h4>
          </td>
          <td class="text-right">
            {{ order.created_at | datetime }}
          </td>
          <td class="text-right">
            <span class="label label-default">{{ order.status.name }}</span>
          </td>
        </tr>
      </tbody>
    </table>

    <br>

    <table class="table">
      <thead>
        <tr>
          <th>Produto</th>
          <th class="text-right">Quantidade</th>
          <th class="text-right">Preço unitário</th>
          <th class="text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in order.items">
          <td>
            <div class="pull-left">
              <img :src="item.product.thumbnail" width="90" alt="" class="img-thumbnail">
            </div>
            <p>{{ item.product.name }}</p>
            <p v-for="variant in item.variants">
              {{ variant.type.name }}: {{ variant.value }}
            </p>
          </td>
          <td class="text-right">{{ item.amount }}</td>
          <td class="text-right">{{ item.price | money }}</td>
          <td class="text-right">{{ item.total | money }}</td>
        </tr>
        <tr>
          <td colspan="2">
            <p><b>Entrega</b></p>
            <address>
              {{ address.street }}, {{ address.number }}<br>
              {{ address.district }}, {{ address.city.name }}/{{ address.city.state.uf }}
            </address>
          </td>
          <td colspan="2">
            <div class="row">
              <div class="col-xs-6 text-right">
                <p>Frete</p>
                <p class="h4">{{ order.shipping.price | money }}</p>
              </div>
              <div class="col-xs-6 text-right">
                <p><b>Total</b></p>
                <p class="h4"><b>{{ order.total | money }}</b></p>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <hr>
    <br>

    <div>
      <h4 class="h4 text-uppercase">Histórico de pagamento</h4>
      <br>
      <ul v-for="event in order.payment.events" class="list-unstyled">
        <li>{{ event.created_at | datetime }} - <span class="label label-default">{{ event.status.name }}</span></li>
      </ul>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        order: null
      }
    },
    head () {
      return {
        title: `Pedido ${this.order.reference}`
      }
    },
    computed: {
      address () {
        return this.order.shipping.address
      }
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get(`/customers/me/orders/${params.id}?includes=items,shipping,payment,status`)

      return {
        order: data.data
      }
    }
  }
</script>

<style lang="sass">
  .order-header
    tbody > tr > td
      vertical-align: middle
</style>
