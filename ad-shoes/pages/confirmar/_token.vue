<template>
  <div class="container">
    <ui-page-header>Confirmação</ui-page-header>
    <div class="row">
      <div class="col-sm-8 col-sm-push-2">
        <ui-alert v-if="success" state="success">
          <p class="text-center"><b>Parabéns!</b> Seu e-mail foi confirmado com sucesso. Acesse sua conta e boas compras.</p>
          <br>
          <div class="text-center">
            <nuxt-link to="/entrar" class="btn btn-success">Entrar</nuxt-link>
          </div>
        </ui-alert>
        <ui-loading v-else message="Confirmando seu e-mail"/>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        success: false
      }
    },
    head () {
      return {
        title: 'Confirmar e-mail'
      }
    },
    mounted () {
      this.confirm()
    },
    methods: {
      confirm () {
        let token = this.$route.params.token

        this.$axios.get(`/customers/confirmation/${token}`).then(() => {
          this.success = true
        })
      }
    }
  }
</script>
