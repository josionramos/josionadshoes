<template>
  <form @submit.prevent="store" class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Código de rastreamento</p>
    </header>

    <section class="modal-card-body">
      <b-notification type="is-warning" has-icon :closable="false">
        O cliente receberá esse código por e-mail para o acompanhamento da entrega, assim como o status do pedido será alterado para <i>"Em transporte".</i>
      </b-notification>

      <b-field label="Rastreamento">
        <b-input
          v-model="tracker"
          required
          placeholder="Código de rastreamento"
        />
      </b-field>
    </section>

    <footer class="modal-card-foot">
      <btn type="submit" state="success" :disabled="!canSubmit" :loading="loading">
        Salvar
      </btn>
      <button class="button">Cancelar</button>
    </footer>
  </form>
</template>

<script>
  export default {
    props: {
      order: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        tracker: this.order.shipping.tracker ? this.order.shipping.tracker : '',
        loading: false
      }
    },
    computed: {
      canSubmit () {
        return this.tracker.length > 5
      }
    },
    methods: {
      store () {
        if (this.tracker === this.order.shipping.tracker) {
          this.$emit('close')
          return
        }

        let data = {
          tracker: this.tracker
        }

        this.loading = true

        this.$axios.put(`orders/${this.order.id}/shipping/tracker`, data).then(({ data }) => {
          this.loading = false
          this.$emit('close')
          this.$toast.open({
            type: 'is-success',
            message: `Código de rastreamento adicionado com sucesso!`
          })
          this.order.shipping.tracker = this.tracker
        })
      }
    }
  }
</script>
