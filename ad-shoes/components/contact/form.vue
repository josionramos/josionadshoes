<template>
  <form @submit.prevent="send">

    <ui-alert v-if="success" state="success">
      <p><b>Deu certo!</b> {{ form.fields.name }} nós recebemos seu contato e iremos responder o mais breve possível.</p>
    </ui-alert>

    <!-- Name -->
    <ui-form-group
      field="name"
      :errors="errors"
    >
      <ui-input
        v-model="form.fields.name"
        required
        placeholder="Nome"
      />
    </ui-form-group>

    <!-- E-mail -->
    <ui-form-group
      field="email"
      :errors="errors"
    >
      <ui-input
        type="email"
        required
        v-model="form.fields.email"
        placeholder="E-mail"
      />
    </ui-form-group>

    <div class="row">
      <!-- Fone -->
      <div class="col-sm-6">
        <ui-form-group
          field="phone"
          :errors="errors"
        >
          <ui-phone
            v-model="form.fields.phone"
            required
            placeholder="Fone"
          />
        </ui-form-group>
      </div>

      <!-- City -->
      <div class="col-sm-6">
        <ui-form-group
          field="city"
          :errors="errors"
        >
          <ui-input
            v-model="form.fields.city"
            required
            placeholder="Cidade/UF"
          />
        </ui-form-group>
      </div>
    </div>

    <!-- Message -->
    <ui-form-group
      field="message"
      :errors="errors"
    >
      <textarea
        v-model="form.fields.message"
        required
        rows="7"
        class="form-control"
        placeholder="Mensagem"
      >
      </textarea>
    </ui-form-group>

    <div class="text-center">
      <ui-btn
        outlined
        :loading="loading"
        :disabled="success"
      >
        Enviar
      </ui-btn>
    </div>
  </form>
</template>

<script>
  export default {
    data () {
      return {
        form: this.$form({
          name: '',
          email: '',
          city: '',
          phone: '',
          message: ''
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
      send () {
        this.form.post('/site/contact', this.form).then(({ data }) => {
          this.success = true
        })
      }
    }
  }
</script>
