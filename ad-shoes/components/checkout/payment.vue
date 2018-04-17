<template>
  <div>
    <ui-loading v-if="loading" message="Inicinado PagSeguro..."/>

    <!-- PAYMENT TYPE -->
    <div v-if="!loading && !isBoleto && !isCreditCard" class="text-center">
      <button
        class="btn btn-boleto"
        :class="{ 'active': isBoleto }"
        @click="setBoleto"
      >
        <ui-icon name="money"/> <span>Boleto bancário</span>
      </button>
      <button
        class="btn btn-credit-card"
        :class="{ 'active': isCreditCard }"
        @click="setCreditCard"
      >
        <ui-icon name="credit-card"/> <span>Cartão de crédito</span>
      </button>
    </div>

    <div v-if="!loading">
      <!-- BOLETO -->
      <transition name="fade">
        <boleto v-if="isBoleto"/>
      </transition>

      <!-- CREDIT CARD -->
      <transition name="fade">
        <credit-card v-if="isCreditCard"/>
      </transition>
    </div>

    <hr>

    <div class="row">
      <!-- PREV STEP -->
      <div class="col-xs-6">
        <ui-btn
          outlined
          @click="$store.commit('checkout/GO_TO_STEP', 'payment')"
        >
          Voltar
        </ui-btn>
      </div>

      <!-- NEXT STEP -->
      <div class="col-xs-6 text-right">
        <ui-btn
          v-if="!$store.state.checkout.completed && $store.state.checkout.payment.type !== 'boleto'"
          state="success"
          :loading="isLoading"
          :disabled="!canSubmit"
          @click="$store.dispatch('checkout/process')"
        >
          Finalizar
        </ui-btn>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  import Order from './order'
  import Boleto from './payments/boleto'
  import CreditCard from './payments/credit-card'

  const SCRIPT = {
    prod: 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',
    sandbox: 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js'
  }

  export default {
    components: {
      Order,
      Boleto,
      CreditCard
    },
    data () {
      return {
        loaded: false,
        loading: false
      }
    },
    computed: {
      ...mapGetters({
        isBoleto: 'checkout/isBoleto',
        isLoading: 'checkout/isLoading',
        isCreditCard: 'checkout/isCreditCard',
        hasInstallment: 'checkout/hasInstallment',
        hasCreditCardToken: 'checkout/hasCreditCardToken'
      }),

      canSubmit () {
        return this.hasCreditCardToken && this.hasInstallment
      }
    },
    mounted () {
      if (!this.loaded) {
        this.loadPagSeguroScript()
      }
    },
    methods: {
      /**
       * Set payment type as Boleto.
       */
      setBoleto () {
        this.$store.dispatch('checkout/setBoleto')
      },

      /**
       * Set payment type as credit card.
       */
      setCreditCard () {
        this.$store.dispatch('checkout/setCreditCard')
      },

      /**
       * Start PagSeguro session.
       */
      startPagSeguro () {
        this.$axios.get('/payments/pagseguro/session').then(({ data }) => {
          this.loaded = true
          this.loading = false
          window.PagSeguroDirectPayment.setSessionId(data.id)
        })
      },

      /**
       * Load PagSeguro script.
       */
      loadPagSeguroScript () {
        this.loading = true

        let script = document.createElement('script')
        script.src = SCRIPT.prod

        script.onload = () => {
          this.startPagSeguro()
        }

        document.head.appendChild(script)
      },

      finish () {
        this.$router.push('/minha-conta/pedidos')
        this.$store.commit('order/CLEAR')
        this.$store.commit('checkout/CLEAR')
      }
    }
  }
</script>

<style lang="sass">
  .btn-boleto,
  .btn-credit-card
    height: 5rem
    color: #999
    margin: 0 1rem
    background: transparent
    border: 1px solid #ddd

    .fa
      display: block
      margin-bottom: .5rem

    &.active
      color: #34495e
      box-shadow: none
      border-color: #34495e

  @media screen and (max-width: 768px)
    .btn-boleto,
    .btn-credit-card
      width: 100%
      display: block
      margin: 0 0 1rem
</style>
