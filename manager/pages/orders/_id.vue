<template>
  <div>
    <page-header
      title="Pedido"
      :subtitle="'Visualizando pedido #' + order.reference"
    >
      <button class="button is-info" disabled="">Alterar status</button>
    </page-header>

    <div class="columns">
      <div class="column table-section">
        <h1 class="title">Cliente</h1>

        <table class="table is-fullwidth is-bordered is-striped">
          <tbody>
            <tr>
              <td>Nome</td>
              <td class="has-text-right">{{ customer.name }}</td>
            </tr>
            <tr>
              <td>CPF</td>
              <td class="has-text-right">{{ customer.cpf }}</td>
            </tr>
            <tr>
              <td>Celular</td>
              <td class="has-text-right">{{ customer.phone }}</td>
            </tr>
            <tr>
              <td>E-mail</td>
              <td class="has-text-right">{{ customer.email }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="column table-section">
        <h1 class="title">Frete</h1>

        <table class="table is-fullwidth is-bordered is-striped">
          <tbody>
            <tr>
              <td>Endereço</td>
              <td class="has-text-right">
                {{ shipping.address.street }}, {{ shipping.address.number }}, {{ shipping.address.district }}, {{ shipping.address.city.name }}/{{ shipping.address.city.state.uf }}
              </td>
            </tr>
            <tr>
              <td>CEP</td>
              <td class="has-text-right">{{ shipping.address.zipcode }}</td>
            </tr>
            <tr>
              <td>Valor</td>
              <td class="has-text-right">{{ shipping.price | money }}</td>
            </tr>
            <tr>
              <td>Rastreamento</td>
              <td class="has-text-right">
                <a href="#" v-if="shipping.tracker" @click.prevent="openModal">{{ shipping.tracker }}</a>
                <a href="#" v-else @click.prevent="openModal">Adicionar código de rastreamento</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="columns">
      <div class="column table-section">
        <h1 class="title">Fatura</h1>

        <table class="table is-fullwidth is-bordered is-striped">
          <tbody>
            <tr>
              <td>Valor bruto</td>
              <td class="has-text-right has-text-info">{{ payment.price | money }}</td>
            </tr>
            <tr>
              <td>Taxa PagSeguro</td>
              <td class="has-text-right has-text-danger">{{ - payment.tax | money }}</td>
            </tr>
            <tr>
              <td>Frete Correios</td>
              <td class="has-text-right has-text-danger">{{ - shipping.price | money }}</td>
            </tr>
            <tr>
              <td>Valor Líquido</td>
              <td class="has-text-right has-text-info">
                <b>{{ payment.price - (payment.tax + shipping.price) | money }}</b>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="column table-section">
        <h1 class="title">PagSeguro</h1>

        <table class="table is-fullwidth is-bordered is-striped">
          <tbody>
            <tr>
              <td>Método</td>
              <td class="has-text-right">{{ payment.type.name }}</td>
            </tr>
            <tr>
              <td>Referência</td>
              <td class="has-text-right">{{ payment.reference }}</td>
            </tr>
            <tr v-for="event in payment.events">
              <td>
                <span class="tag is-default">
                  {{ event.status.name }}
                </span>
              </td>
              <td class="has-text-right">{{ event.created_at | datetime }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="table-section">
      <h1 class="title">Itens</h1>

      <b-table
        bordered
        :data="order.items"
      >
        <template slot-scope="props">
          <b-table-column label="ID">
            {{ props.row.amount }}
          </b-table-column>

          <b-table-column label="Produto">
            <div class="media">
              <figure class="media-left">
                <p class="image is-64x64">
                  <img :src="props.row.product.thumbnail" alt="">
                </p>
              </figure>
              <div class="media-content">
                <p><strong>{{ props.row.product.name }}</strong></p>
                <p v-for="variant in props.row.variants">
                  {{ variant.type.name }}: {{ variant.value }}
                </p>
              </div>
            </div>
          </b-table-column>

          <b-table-column numeric label="Qtd">
            {{ props.row.amount }}
          </b-table-column>

          <b-table-column numeric label="Preço">
            {{ props.row.price | money }}
          </b-table-column>

          <b-table-column numeric label="Total">
            {{ props.row.total | money }}
          </b-table-column>
        </template>
      </b-table>
    </div>

    <br>
    <hr>

    <div class="has-text-right">
      <button class="button is-info" disabled>Alterar status</button>
      <button class="button is-default">Voltar</button>
    </div>
  </div>
</template>

<script>
  import TrackerModal from '@/components/order/tracker'

  export default {
    data () {
      return {
        order: []
      }
    },
    head () {
      return {
        title: 'Pedidos'
      }
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get(`orders/${params.id}?includes=customer,shipping,items,payment`)

      return {
        order: data.data
      }
    },
    computed: {
      customer () {
        return this.order.customer
      },

      shipping () {
        return this.order.shipping
      },

      payment () {
        return this.order.payment
      }
    },
    methods: {
      openModal () {
        this.$modal.open({
          parent: this,
          component: TrackerModal,
          props: {
            order: this.order
          },
          hasModalCard: true
        })
      }
    }
  }
</script>

<style lang="sass" scoped>
  .table-section
    text-transform: uppercase
    font-size: 1rem;

  .table-section
    .title
      font-size: 1rem;
</style>
