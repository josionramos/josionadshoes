<template>
  <div class="container">
    <ui-page-header>
      <h1>Minha conta</h1>
    </ui-page-header>
    <div class="row">
      <div class="col-sm-3">
        <div class="list-group">
          <nuxt-link class="list-group-item" to="/minha-conta/meus-dados">Meus dados</nuxt-link>
          <nuxt-link class="list-group-item" to="/minha-conta/pedidos">Meus pedidos</nuxt-link>
          <nuxt-link class="list-group-item" to="/minha-conta/enderecos">Meus endereços</nuxt-link>
        </div>
        <a href="#" class="btn btn-link" @click.prevent="logout">Sair</a>
      </div>
      <div class="col-sm-9">
        <nuxt-child/>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    middleware: 'auth',
    methods: {
      logout () {
        this.$store.dispatch('auth/logout').then(() => {
          this.$toast.open({
            message: 'Sua sessão foi encerrada com sucesso!'
          })

          this.$router.push('/entrar')
        })
      }
    }
  }
</script>

<style lang="sass">
  .list-group-item
    text-transform: uppercase
    &.active
      background: #000
      border-color: #000
      &:hover,
      &:focus
        background: #444
        border-color: #444
    &:last-child,
    &:first-child
      border-radius: 0
</style>
