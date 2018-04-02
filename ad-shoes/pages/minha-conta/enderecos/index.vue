<template>
  <div>
    <div class="text-right">
      <nuxt-link to="/minha-conta/enderecos/novo" class="btn btn-success">
        <ui-icon name="plus-circle"/>  Novo
      </nuxt-link>
    </div>

    <br>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>CEP</th>
            <th>Logradouro</th>
            <th class="text-right">Nº</th>
            <th>Bairro</th>
            <th>Cidade/UF</th>
            <th> </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(address, index) in addresses">
            <td>{{ address.zipcode | zipcode }}</td>
            <td>{{ address.street }}</td>
            <td class="text-right">{{ address.number }}</td>
            <td>{{ address.district }}</td>
            <td>{{ address.city.name }}/{{ address.city.state.uf }}</td>
            <td class="text-right">
              <nuxt-link :to="edit(address.id)" class="btn btn-primary btn-outlined btn-sm">
                <ui-icon name="pencil"/>
              </nuxt-link>
              <button class="btn btn-danger btn-outlined btn-sm" @click="destroy(index)">
                <ui-icon name="trash"/>
              </button>
            </td>
          </tr>
          <tr v-if="addresses.length === 0">
            <td colspan="6" class="text-center">Nenhum endereço cadastrado.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        addresses: []
      }
    },
    head () {
      return {
        title: 'Meus endereços'
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('/customers/me/addresses')

      return {
        addresses: data.data
      }
    },
    methods: {
      edit (id) {
        return {
          name: 'minha-conta-enderecos-id',
          params: {
            id
          }
        }
      },
      destroy (index) {
        let confirm = window.confirm('Deseja realmente deletar esse endereço?')

        if (confirm) {
          let address = this.addresses[index]

          this.$axios.delete(`/customers/me/addresses/${address.id}/`).then(() => {
            this.addresses.splice(index, 1)
            this.$toast.open({
              message: 'Endereço removido com sucesso!'
            })
          })
        }
      }
    }
  }
</script>
