<template>
  <div class="text-center">
    <ui-alert v-if="fail" state="danger">
      <b>Ops!</b> Houve algum problema ao processar seu pagamento pelo PagSeguro, por favor, tente novamente.
    </ui-alert>

    <template v-else>
      <ui-btn
        state="success"
        :loading="loading"
        @click="create"
      >
        <ui-icon name="money"/> Gerar boleto
      </ui-btn>

      <br>
      <br>

      <p>
        ou<br>
        <a
          href="#"
          class="btn btn-link"
          @click.prevent="setCreditCard"
        >
          Cartão de Crédito
        </a>
      </p>
    </template>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    data () {
      return {
        fail: false,
        loading: false
      }
    },
    mounted () {
      let hash = null;
      if (hash == null || typeof hash === "undefined"){
        hash = window.PagSeguroDirectPayment.getSenderHash()
      }
      
      if (hash == null || typeof hash === "undefined"){
        hash = window.PagSeguroDirectPayment.getSenderHash()
      }
      
      if (hash == null || typeof hash === "undefined"){
        hash = window.PagSeguroDirectPayment.getSenderHash()
      }
      
      this.$store.commit('checkout/SET_HOLDER_HASH', hash)
    },
    computed: {
      ...mapGetters({
        holder: 'checkout/holder'
      }),
    },
    methods: {
      ...mapActions({
        setCreditCard: 'checkout/setCreditCard'
      }),

      create () {
        this.loading = true

        
        
        this.$store.dispatch('checkout/process').then(() => {
          this.fail = false
          this.loading = false
        }).catch(error => {
          this.fail = true
          this.loading = false
          console.log(error)
        })
      }
    }
  }
</script>
