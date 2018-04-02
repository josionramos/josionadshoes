<template>
  <div>
    <ui-form
      :form="form"
      @submit="update"
    >
      <ui-btn
        type="submit"
        state="success"
        :loading="loading"
      >
        Salvar
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
        }),
        address: null
      }
    },
    head () {
      return {
        title: 'Editar endereços'
      }
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get(`/customers/me/addresses/${params.id}`)

      return {
        address: data.data
      }
    },
    mounted () {
      this.form = this.$form(this.address)
    },
    computed: {
      loading () {
        return this.form.isBusy()
      }
    },
    methods: {
      update () {
        let url = `/customers/me/addresses/${this.address.id}`

        this.form.put(url).then(({ data }) => {
          this.$toast.open({
            message: '<b>Sucesso!</b> Endereço atualizado com sucesso!'
          })
        })
      }
    }
  }
</script>
