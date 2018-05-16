<template>
  <div>
    <ui-form :form="form" @submit="store">
      <ui-btn
        type="submit"
        state="success"
        :loading="loading"
      >
        Criar
      </ui-btn>
    </ui-form>
  </div>
</template>

<script>
  import UiForm from '@/components/address/form'

  export default {
    components: {
      UiForm
    },
    data () {
      return {
        form: this.$form({
          street: '',
          number: '',
          zipcode: '',
          district: '',
          city_id: 0
        })
      }
    },
    head () {
      return {
        title: 'Criar novo endereço'
      }
    },
    computed: {
      loading () {
        return this.form.isBusy()
      }
    },
    methods: {
      store () {
        this.form.post('/customers/me/addresses').then(({ data }) => {
          this.$toast.open({
            message: '<b>Sucesso!</b> Endereço cadastrado com sucesso!'
          })

          if (this.$store.getters['order/hasItems']){
              this.$router.push('/checkout')
          } else {
              this.$router.push(`/minha-conta/enderecos/${data.id}`)
          }
        })
      }
    }
  }
</script>
