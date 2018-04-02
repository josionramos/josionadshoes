<template>
  <div>
    <!-- CREATING ORDER -->
    <ui-loading v-if="isCreating" message="Inicinado checkout..."/>

    <!-- ORDER TABLE -->
    <table v-else class="table checkout-items">
      <tbody>
        <tr v-for="(item, index) in items">
          <!-- INFO -->
          <td>
            <div class="checkout-item-thumb">
              <img
                width="70"
                class="img-thumbnail"
                :src="item.product.thumbnail"
              >
            </div>
            {{ item.product.name }}<br>
            <p v-for="variant in item.variants">
              {{ variant.type.name }}: {{ variant.value }}
            </p>
          </td>

          <!-- CHANGE AMOUNT -->
          <td width="70" class="text-center">
            <input
              type="number"
              min="1"
              class="form-control text-center"
              :value="item.amount"
              :disabled="loading"
              @input="changeAmount(index, $event)"
            />
          </td>

          <!-- UNIT -->
          <td class="text-right">
            {{ item.price | money }}
          </td>

          <!-- SUB TOTAL -->
          <td class="text-right">
            {{ item.amount * item.price | money }}
          </td>

          <!-- REMOVE -->
          <td class="text-right">
            <button class="btn btn-primary btn-outlined" @click="remove(item)" :disabled="loading">
              <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
          </td>
        </tr>

        <tr v-if="!hasItems">
          <td colspan="5" class="text-center">Nenhum item adicionado ao carrinho!</td>
        </tr>
      </tbody>

      <tfoot>
        <!-- TOTAL -->
        <tr class="total">
          <td colspan="3">
            <b>Total</b>
          </td>
          <td colspan="2" class="text-right">
            {{ subTotal | money }}
          </td>
        </tr>
      </tfoot>
    </table>

    <hr>

    <div class="text-right">
      <!-- NEXT STEP -->
      <ui-btn
        state="success"
        :disabled="loading"
        @click="$store.commit('checkout/GO_TO_STEP', 'shipping')"
      >
        Prosseguir
      </ui-btn>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    data () {
      return {
        isCreating: false
      }
    },
    computed: {
      ...mapGetters({
        items: 'order/items',
        isSaved: 'order/isSaved',
        subTotal: 'order/total',
        hasItems: 'order/hasItems',
        loading: 'order/isLoading'
      })
    },
    mounted () {
      if (this.hasItems && !this.isSaved) {
        this.isCreating = true
        this.$store.dispatch('order/create').then(() => {
          this.isCreating = false
        })
      }
    },
    methods: {
      changeAmount (index, e) {
        let item = this.items[index]

        let payload = {
          id: item.id,
          amount: e.target.value,
          product: { id: item.product.id },
          variants: item.variants
        }

        this.$store.dispatch('order/setAmount', payload)
      },

      ...mapActions({
        remove: 'order/remove'
      })
    }
  }
</script>

<style lang="sass">
  .checkout-items
    tbody > tr > td
      vertical-align: middle

    .total
      font-weight: bold
      text-transform: uppercase
      border: 1px solid #ddd

      td
        padding-top: 2rem
        padding-bottom: 2rem
        background: #f4f4f4

  .checkout-item-thumb
    float: left
    margin-right: 1rem
</style>
