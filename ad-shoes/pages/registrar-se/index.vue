<template>
  <div class="container">
    <!-- Page header -->
    <ui-page-header>
      <h1>Criar conta</h1>
    </ui-page-header>

    <div class="row">
      <div class="col-sm-8 col-sm-push-2">
        <!-- Completed -->
        <ui-alert v-if="complete" state="success">
          <b>Parabéns!</b> Seu cadastro foi realizado com sucesso, verifique seu e-mail para confirmar o registro.
        </ui-alert>

        <!-- Form -->
        <form @submit.prevent="register">
          <div class="row">
            <!-- Name -->
            <div class="col-sm-6">
              <ui-form-group
                field="name"
                label="Nome Completo"
                :errors="errors"
              >
                <ui-input
                  v-model="form.fields.name"
                  type="text"
                  placeholder="Seu nome"
                />
              </ui-form-group>
            </div>

            <!-- E-mail -->
            <div class="col-sm-6">
               <ui-form-group
                field="email"
                label="E-mail"
                :errors="errors"
              >
                <ui-input
                  v-model="form.fields.email"
                  type="email"
                  placeholder="Seu e-mail"
                />
              </ui-form-group>
            </div>
          </div>

          <div class="row">
            <!-- CPF -->
            <div class="col-sm-6">
              <ui-form-group
                field="cpf"
                label="CPF"
                :errors="errors"
              >
                <ui-cpf
                  v-model="form.fields.cpf"
                  placeholder="Seu CPF"
                />
              </ui-form-group>
            </div>

            <!-- Phone -->
            <div class="col-sm-6">
              <ui-form-group
                field="phone"
                label="Telefone"
                :errors="errors"
              >
                <ui-phone
                  v-model="form.fields.phone"
                  placeholder="Seu telefone ou celular"
                />
              </ui-form-group>
            </div>

            <!-- Birthdate -->
            <div class="col-sm-6">
              <ui-form-group
                field="birthdate"
                label="Data de nascimento"
                :errors="errors"
              >
                <ui-date
                  v-model="form.fields.birthdate"
                  placeholder="DD/MM/YYYY"
                />
              </ui-form-group>
            </div>
          </div>

          <hr>

          <div class="row">
            <!-- Password -->
            <div class="col-sm-6">
              <ui-form-group
                field="password"
                label="Senha"
                :errors="errors"
              >
                <ui-input
                  v-model="form.fields.password"
                  type="password"
                  placeholder="Senha"
                />
              </ui-form-group>
            </div>

            <!-- Password confirmation -->
            <div class="col-sm-6">
              <ui-form-group
                field="password_confirmation"
                label="Confirmar senha"
                :errors="errors"
              >
                <ui-input
                  v-model="form.fields.password_confirmation"
                  type="password"
                  placeholder="Confirmar senha"
                />
              </ui-form-group>
            </div>
          </div>

          <br>
          <br>

          <div class="text-center">
            <ui-btn
              state="success"
              :loading="loading"
              :disabled="complete"
            >
              Criar conta
            </ui-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        form: this.$form({
          cpf: '',
          name: '',
          email: '',
          phone: '',
          password: '',
          password_confirmation: '',
          birthdate: ''
        }),
        complete: false
      }
    },
    head () {
      return {
        title: 'Criar conta'
      }
    },
    computed: {
      loading () {
        return this.form.isBusy()
      },

      errors () {
        return this.form.errors
      }
    },
    methods: {
      register () {
        this.form.post('/register').then(({ data }) => {
        //this.complete = true
        this.$router.push('/checkout')
        }).catch(error => {
          console.log(error)
        })
      }
    }
  }
</script>
