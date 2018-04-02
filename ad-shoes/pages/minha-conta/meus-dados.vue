<template>
  <div>
    <form @submit.prevent="update">
      <div class="row">
        <!-- Name -->
        <div class="col-sm-6">
          <ui-form-group
            field="name"
            label="Nome"
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
              placeholder="Data de nascimento"
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

      <div>
        <ui-btn
          state="success"
          :loading="loading"
        >
          Atualizar
        </ui-btn>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    head () {
      return {
        title: 'Minha conta'
      }
    },
    data () {
      return {
        form: this.$form({
          cpf: '',
          name: '',
          email: '',
          phone: '',
          password: '',
          birthdate: '',
          password_confirmation: ''
        }),
        customer: null
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('/customers/me')

      return {
        customer: data.data
      }
    },
    mounted () {
      this.form = this.$form(this.customer)
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
      update () {
        this.form.put('/customers/me').then(({ data }) => {
          this.$toast.open({
            message: `<b>Sucesso!</b> Seus dados foram atualizados com sucesso.`
          })
        })
      }
    }
  }
</script>
