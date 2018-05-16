<template>
  <div>
    <!-- LOADING -->
    <div v-if="loading">
      <p><ui-icon name="circle-o-notch" :spin="true"/> Carregando endereços...</p>
    </div>

    <!-- LIST -->
    <div v-for="address in addresses" class="address">
      <label class="address-radioble">
        <input
          v-model="current"
          type="radio"
          :value="address"
          @change="selected"
        >
      </label>
      <div class="address-content">
        {{ address.street }}, {{ address.number }}<br>
        {{ address.district }}, {{ address.city.name }}/{{ address.city.state.uf }}
      </div>
    </div>

    <!-- EMPTY-->
    <div v-if="!loading && addresses.length === 0">
      <div class="alert alert-danger">
        <b>Ops!</b> Você não possui nenhum endereço de entrega cadastrado.
      </div>
      <div class="text-center">
        <nuxt-link class="btn btn-success" to="/minha-conta/enderecos/novo">Novo endereço</nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    data () {
      return {
        fail: false,
        current: null,
        loading: false,
        addresses: []
      }
    },
    mounted () {
      this.fetch()
      this.current = this.currentAddress
    },
    computed: {
      ...mapState({
        currentAddress: state => state.checkout.address
      })
    },
    methods: {
      /**
       * Fetch all customer address.
       */
      fetch () {
        this.loading = true
        this.$axios.get('/customers/me/addresses').then(({ data }) => {
          this.addresses = data.data
          this.loading = false
        })
      },

      /**
       * Set shipping address.
       */
      selected () {
        this.$store.commit('checkout/SET_ADDRESS', this.current)
      }
    }
  }
</script>

<style lang="sass" scoped>
  .address
    height: 3.8rem
    // border-bottom: 1px solid #ddd

  .address-content
    display: inline-block
    height: 100%
    padding-left: 1rem

  .address-radioble
    display: inline-block
    width: 3rem
    height: 100%
    margin: 0
    position: relative
    vertical-align: top
    background: #f4f4f4

    input
      position: absolute
      top: 50%
      left: 50%
      margin: 0
      transform: translate(-50%, -50%)
</style>
