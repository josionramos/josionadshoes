<template>
  <aside class="shopping-cart" :class="{ 'is-open': open }">
    <!-- PAGE HEADER -->
    <ui-page-header size="is-small">
      Carrinho
      <button class="btn btn-primary btn-outlined" @click="close">
        <ui-icon name="close"/>
      </button>
    </ui-page-header>

    <!-- ITEMS -->
    <table v-if="hasItems" class="table shopping-cart-items">
      <thead>
        <tr>
          <th></th>
          <th class="text-center">Qtd.</th>
          <th width="85" class="text-right">Total</th>
          <th width="50"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items">
          <!-- Details -->
          <td>
            <div class="item-thumb">
              <img :src="item.product.thumbnail" alt="">
            </div>
            <p>{{ item.product.name }}</p>
            <p v-for="variant in item.variants">
              {{ variant.type.name }}: {{ variant.value }}
            </p>
          </td>

          <!-- Amount -->
          <td width="85" class="text-center">
            <input type="number" class="form-control text-center" min="1" :value="item.amount" @input="changeAmount(index, $event)" :disabled="loading">
          </td>

          <!-- Total -->
          <td class="text-right">
            {{ item.amount * item.price | money }}
          </td>

          <!-- Remove item -->
          <td width="50" class="text-right">
            <button class="btn btn-primary btn-outlined btn-sm" @click="remove(item)" :disabled="loading">
              <ui-icon name="trash"/>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-else class="text-center">Nenhum produto adicionado ainda!</p>

    <!-- FOOTER -->
    <footer>
      <!-- Signin or login -->
      <div v-if="!loggedIn" class="text-center">
        <button class="btn btn-primary btn-outlined btn-lg">Criar conta</button>
        <br>
        <br>
        <p>ou <nuxt-link to="/entrar" @click.native="close">entrar</nuxt-link></p>
      </div>

      <!-- Checkout -->
      <div v-if="loggedIn && hasItems" class="text-center">
        <nuxt-link to="/checkout" @click.native="close" class="btn btn-primary btn-outlined btn-lg" :disabled="loading">Finalizar</nuxt-link>
      </div>
    </footer>
  </aside>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    computed: {
      ...mapGetters({
        open: 'shopping-cart/isOpen',
        items: 'order/items',
        loading: 'order/isLoading',
        hasItems: 'order/hasItems',
        loggedIn: 'auth/isLoggedIn'
      })
    },
    methods: {
      ...mapActions({
        close: 'shopping-cart/close',
        remove: 'order/remove'
      }),

      changeAmount (index, event) {
        let item = this.items[index]

        let payload = {
          amount: event.target.value,
          product: { id: item.product.id },
          variants: item.variants
        }

        this.$store.dispatch('order/setAmount', payload)
      }
    }
  }
</script>

<style lang="sass">
  .shopping-cart
    position: fixed
    top: 0
    right: 0
    width: 40%
    height: 100%
    padding: .75rem
    z-index: 100
    background: #fff
    box-shadow: 1px 0 8px rgba(#000, .3)
    border-left: 1px solid #ececeb
    transition: .5s ease
    transform: translateX(120%)

    &.is-open
      transform: translateX(0)

    footer
      position: absolute
      width: 100%
      padding: 1.5rem .75rem
      left: 0
      bottom: 0
      background: #f4f4f4
      border-top: 1px solid #ececeb

    @media screen and (max-width: 992px)
      width: 50%
    @media screen and (max-width: 768px)
      width: 100%

  .shopping-cart-items
    &.table > tbody > tr > td
      vertical-align: middle !important
    .item-thumb
      float: left
      margin-right: .75rem
      img
        width: 65px
</style>
