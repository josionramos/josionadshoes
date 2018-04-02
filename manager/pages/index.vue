<template>
  <div class="container">
    <div class="columns">
      <div class="column is-4 is-offset-4 login-box">
        <h1 class="title">Entrar</h1>
        <b-notification
          v-if="error"
          type="is-danger"
          @close="error = null"
        >
          {{ error }}
        </b-notification>
        <form @submit.prevent="login">
          <b-field>
            <b-input type="email" v-model="user.email" placeholder="E-mail"></b-input>
          </b-field>
          <b-field>
            <b-input type="password" v-model="user.password" placeholder="Senha"></b-input>
          </b-field>
          <button
            type="submit"
            class="button is-primary"
            :disabled="!canLogin"
            :class="{ 'is-loading': loading }"
          >
            Entrar
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'guest',
  data () {
    return {
      error: null,
      loading: false,
      user: {
        email: '',
        password: ''
      }
    }
  },
  head () {
    return {
      title: 'Entrar'
    }
  },
  computed: {
    canLogin () {
      return this.user.email.length > 5 && this.user.password.length >= 6
    }
  },
  methods: {
    login () {
      this.error = null
      this.loading = true
      this.$store.dispatch('auth/login', this.user).then(() => {
        this.loading = false
        this.$router.push('/dashboard')
      }).catch(({ response }) => {
        this.loading = false
        this.error = response.data.message
      })
    }
  }
}
</script>

<style lang="sass">
  .login-box
    margin-top: 10vh
    background-color: #fff
</style>
