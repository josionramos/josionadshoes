<template>
  <table class="table order">
    <thead>
      <tr>
        <th>Qtd.</th>
        <th>Produto</th>
        <th class="text-right">Preço</th>
      </tr>
    </thead>
    <tbody>
      <!-- INFO -->
      <tr v-for="(item, index) in items">
        <td>{{ item.amount }}</td>
        <td>{{ item.name }}</td>
        <td class="text-right">{{ item.price | money }}</td>
      </tr>
    </tbody>
    <tfoot>
      <!-- SUB TOTAL -->
      <tr>
        <td colspan="2">Sub total</td>
        <td class="text-right">{{ subTotal | money }}</td>
      </tr>

      <!-- SHIPPING -->
      <tr v-if="shippingPrice">
        <td colspan="2">Frete</td>
        <td class="text-right">{{ shippingPrice | money }}</td>
      </tr>

      <!-- TOTAL -->
      <tr class="total">
        <td colspan="2">Total</td>
        <td class="text-right">{{ total | money }}</td>
      </tr>
    </tfoot>
  </table>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters({
        items: 'order/items',
        total: 'checkout/total',
        subTotal: 'order/total',
        shippingPrice: 'checkout/shippingPrice'
      })
    }
  }
</script>

<style lang="sass">
  .order
    border: 1px solid #ddd

    &.table > thead > tr > th
      border-bottom: 1px solid #ddd

    .total
      font-weight: bold
      text-transform: uppercase
      border: 1px solid #ddd

      td
        padding-top: 2rem
        padding-bottom: 2rem
        background: #f4f4f4
</style>
