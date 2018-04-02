<template>
  <div class="container">
    <section class="newsletter">
      <!-- PAGE HEAD -->
      <ui-page-header>
        Newsletter
      </ui-page-header>

      <p class="text-center">
        Inscreva-se abaixo e fique por dentro de todas novidades.
      </p>

      <br>
      <br>

      <div class="row">
        <div class="col-sm-8 col-xs-12 col-sm-push-2">
          <!-- SUCCESS -->
          <ui-alert v-if="success" state="success">
            <p class="text-center">
              <b>Feito!</b> {{ form.fields.name }} você está participando do newsletter.
            </p>
          </ui-alert>

          <!-- FAIL -->
          <ui-alert v-if="errors.has('email')" state="danger">
            <p class="text-center">
              <b>Ups!</b> {{ errors.get('email') }}
            </p>
          </ui-alert>

          <form @submit.prevent="sign" class="row">
            <!-- Name -->
            <div class="col-sm-4 col-xs-12">
              <ui-form-group>
                <ui-input
                  v-model="form.fields.name"
                  required
                  size="lg"
                  placeholder="Nome"
                  :disabled="success"
                />
              </ui-form-group>
            </div>

            <!-- E-mail -->
            <div class="col-sm-4 col-xs-12">
              <ui-form-group>
                <ui-input
                  v-model="form.fields.email"
                  required
                  size="lg"
                  type="email"
                  placeholder="E-mail"
                  :disabled="success"
                />
              </ui-form-group>
            </div>

            <div class="col-sm-4 col-xs-12">
              <ui-btn
                block
                outlined
                size="lg"
                type="submit"
                :loading="loading"
                :disabled="success"
              >
                Descubra
              </ui-btn>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        form: this.$form({
          name: '',
          email: ''
        }),
        success: false
      }
    },
    computed: {
      errors () {
        return this.form.errors
      },

      loading () {
        return this.form.isBusy()
      }
    },
    methods: {
      sign () {
        this.form.post('/newsletter/signin').then(({ data }) => {
          this.success = true
        })
      }
    }
  }
</script>

<style lang="sass">
  .newsletter
    position: relative
    padding: 12rem 0 10rem
    margin-top: 4rem
    background: #e1eee4

    &::before
      content: ''
      width: calc(100% - 30px)
      height: calc(100% - 30px)
      position: absolute
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
      border: 2px solid #fff

    .page-header
      margin-bottom: 2rem

    @media screen and (max-width: 768px)
      padding: 4rem 1.5rem 6rem
      &::before
        display: none
</style>
