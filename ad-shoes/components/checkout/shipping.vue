<template>
  <div>
    <div class="row">
      <div class="col-sm-7">
        <!-- ADDRESSES -->
        <div>
          <addresses/>
        </div>

        <br>
        <br>

        <!-- SHIPPING -->
        <div v-if="hasAddress">
          <p class="h4 text-uppercase">Correios</p>

          <!-- Loading -->
          <div v-if="loading">
            <p><ui-icon name="circle-o-notch" :spin="true"/> Calculando frete...</p>
          </div>

          <!-- Recalculate -->
          <ui-alert v-if="fail" state="warning">
            <b>Ups!</b> Não foi possível calcular o frete pelos Correios. <a href="#" @click.prevent="calc">Tente novamente</a>
          </ui-alert>

          <!-- Shipping options -->
          <div v-for="shipping in shippings" class="radio">
            <label>
              <input
                v-model="current"
                type="radio"
                :value="shipping"
                @change="selected"
              >
              <b>{{ shipping.price | money }}</b> ({{ shippingTypes[shipping.code] }}, até {{ shipping.time }} dias)
            </label>
          </div>
        </div>
      </div>

      <!-- ORDER -->
      <div class="col-sm-5">
        <order/>
      </div>
    </div>

    <hr>

    <div class="row">
      <!-- PREV STEP -->
      <div class="col-xs-6">
        <ui-btn
          outlined
          @click="$store.commit('checkout/GO_TO_STEP', 'shipping')"
        >
          Voltar
        </ui-btn>
      </div>

      <!-- NEXT STEP -->
      <div class="col-xs-6 text-right">
        <ui-btn
          state="success"
          :disabled="!hasShipping"
          @click="$store.commit('checkout/GO_TO_STEP', 'payment')"
        >
          Proseguir
        </ui-btn>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapGetters } from 'vuex'

  import Order from './order'
  import Addresses from './addresses'

  export default {
    components: {
      Order,
      Addresses
    },
    data () {
      return {
        fail: false,
        current: null,
        loading: false,
        shippings: [],
        shippingTypes: {
          4014: 'PAC',
          4510: 'SEDEX'
        }
      }
    },
    mounted () {
      this.current = this.currentShipping

      if (this.hasAddress) {
        this.calc()
      }
    },
    computed: {
      ...mapState({
        currentShipping: state => state.checkout.shipping
      }),

      ...mapGetters({
        hasAddress: 'checkout/hasAddress',
        hasShipping: 'checkout/hasShipping'
      })
    },
    watch: {
      hasAddress () {
        this.calc()
      }
    },
    methods: {
      calc () {
        this.fail = false
        this.loading = true

        let orderId = this.$store.state.order.id
        let url = `/customers/me/orders/${orderId}/shipping`
        let data = {
          address_id: this.$store.state.checkout.address.id
        }

        this.$axios.post(url, data).then(({ data }) => {
          this.loading = false
          this.shippings = data
        }).catch(error => {
          if (error.response.status >= 400) {
            this.fail = true
            this.loading = false
          }
        })
      },

      selected () {
        this.$store.commit('checkout/SET_SHIPPING', this.current)
      }
    }
  }
</script>
