<template>
  <div class="container">
    <ui-page-header>
      <h1>Entrar</h1>
    </ui-page-header>

    <br>
    <br>

    <form @submit.prevent="login" class="col-sm-4 col-sm-push-4 login-box">
      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <ui-form-group>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
          <ui-input type="text" required :disabled="loading" placeholder="Seu e-mail" v-model="form.email" />
        </div>
      </ui-form-group>

      <ui-form-group v-if="!forgetPassword">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
          <ui-input type="password" required :disabled="loading" placeholder="Sua senha" v-model="  form.password" />
        </div>
      </ui-form-group>

      <br>

      <div class="clearfix login-footer">
        <div class="pull-right">
          <ui-btn v-if="!forgetPassword" :loading="loading">Entrar</ui-btn>
          <ui-btn v-else :loading="loading">Recuperar</ui-btn>
        </div>
        <div class="pull-left">
          <a href="#" v-if="!forgetPassword" @click.prevent="forgetPassword = true">Esqueci minha senha</a>
          <a href="#" v-else @click.prevent="forgetPassword = false">Voltar</a>
        </div>
      </div>

      <hr>

      <div class="text-center">
        <nuxt-link to="registrar-se" class="btn btn-success">Criar uma conta</nuxt-link>
      </div>
    </form>

  </div>
</template>

<script>
  export default {
    layout: 'guest',
    head () {
      return {
        title: 'Entrar'
      }
    },
    data () {
      return {
        form: {
          email: '',
          password: ''
        },
        error: null,
        loading: false,
        forgetPassword: false
      }
    },
    computed: {
      canLogin () {
        return this.form.email.length > 3 && this.form.password.length > 3
      }
    },
    methods: {
      login () {
        this.loading = true

        this.$store.dispatch('auth/login', this.form).then(this.success).catch(({ response }) => {
          this.fail(response.data)
        })
      },

      success () {
        this.$router.push('/minha-conta/meus-dados')
      },

      fail (data) {
        this.loading = false
        this.error = data.message
      }
    }
  }
</script>

<style lang="sass">
  .login-box
    padding-top: 15px
    padding-bottom: 15px
    border: 1px solid #eee

  .login-footer a
    line-height: 34px
</style>
