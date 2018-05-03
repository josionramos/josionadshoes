<template>
  <div class="container checkout">
    <ui-page-header>
      <h1>Checkout</h1>
    </ui-page-header>

    <div class="row">
      <div class="col-sm-8 col-sm-push-2 steps">
        <!-- STEPS -->
        <nav class="step-navbar">
          <ul class="step-nav">
            <li
              class="step-nav-item"
              :class="{ active: step === 'checkout', disabled: isCompleted || loading }"
              @click="go('checkout')"
            >
              <div class="icon">
                <ui-icon name="list-alt"/>
              </div>
              <span>Pedido</span>
            </li>
            <li
              class="step-nav-item"
              :class="{ active: step === 'shipping', disabled: !hasItems || isCompleted || loading }"
              @click="go('shipping')"
            >
              <div class="icon">
                <ui-icon name="truck"/>
              </div>
              <span>Endereço</span>
            </li>
            <li
              class="step-nav-item"
              :class="{ active: step === 'payment', disabled: !hasItems || !hasShipping || isCompleted || loading }"
              @click="go('payment')"
            >
              <div class="icon">
                <ui-icon name="credit-card"/>
              </div>
              <span>Pagamento</span>
            </li>
            <li
              v-if="isCompleted"
              class="step-nav-item"
              :class="{ active: step === 'done' }"
              @click="go('payment')"
            >
              <div class="icon">
                <ui-icon name="check-circle-o"/>
              </div>
              <span>Feito</span>
            </li>
          </ul>
        </nav>

        <!-- CHECKOUT -->
        <div v-if="step === 'checkout'" class="step-content">
          <checkout/>
        </div>

        <!-- SHIPPING -->
        <div v-if="step === 'shipping'" class="step-content">
          <shipping/>
        </div>

        <!-- PAYMENT -->
        <div v-if="step === 'payment'" class="step-content">
          <payment/>
        </div>

        <!-- COMPLETED -->
        <div v-if="step === 'done'" class="step-content">
          <ui-alert state="success">
            <b>Parabéns!</b> Recebemos seus pedido e estamos aguardando o processamento do seu pagamento pelo PagSeguro. Você pode acompanhar o pedido por e-mail ou através dos seus <nuxt-link to="minha-conta/pedidos">pedidos</nuxt-link>.
          </ui-alert>
          <div v-if="isBoleto" class="text-center">
            <a :href="$store.state.checkout.payment.link" target="_blank" class="btn btn-success">
              <ui-icon name="print"/> Imprimir Boleto
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Payment from '@/components/checkout/payment'
  import Checkout from '@/components/checkout/checkout'
  import Shipping from '@/components/checkout/shipping'

  import { mapState, mapGetters } from 'vuex'

  export default {
    middleware: [
      'auth',
      'order'
    ],
    components: {
      Payment,
      Checkout,
      Shipping
    },
    head () {
      return {
        title: 'Checkout'
      }
    },
    computed: {
      ...mapGetters({
        isBoleto: 'checkout/isBoleto',
        hasAddress: 'checkout/hasAddress',
        hasPayment: 'checkout/hasPayment',
        hasShipping: 'checkout/hasShipping',
        isCompleted: 'checkout/isCompleted',
        hasItems: 'order/hasItems'
      }),

      ...mapState({
        step: state => state.checkout.currentStep
      }),

      loading () {
        return this.$store.getters['order/isLoading'] || this.$store.getters['checkout/isLoading']
      }
    },
    methods: {
      go (step) {
        this.$store.commit('checkout/GO_TO_STEP', step)
      }
    }
  }
</script>

<style lang="sass">
  .step-navbar
    text-align: center
    padding-top: 1rem
    padding-bottom: 1rem
    margin-bottom: 3rem
    border-bottom: 1px solid #ddd

  .step-nav
    margin: 0
    padding: 0
    list-style: none
    display: inline-block

  .step-nav-item
    color: #555
    padding: 0 2rem
    cursor: pointer
    display: inline-block
    position: relative
    text-transform: uppercase

    span
      font-size: 1.2rem

    &.disabled
      cursor: not-allowed
      opacity: .5

    .icon
      width: 3.5rem
      height: 3.5rem
      display: block;
      margin: 0 auto 1rem
      text-align: center
      line-height: 3.5rem
      border-radius: 50%
      background: #f4f4f4

    &.active
      span
        color: #000
      .icon
        background: #ddd
</style>
