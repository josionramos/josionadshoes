<template>
  <div>
    <ui-alert v-if="pagseguro.errors.length > 0 || errors.hasErrors()" state="danger">
      <p><b>Ups!</b> Houve algum problema com a API PagSeguro e retornou os seguintes errors:</p>
      <br>
      <ul>
        <li v-for="error in pagseguro.errors">
          [JS - <b>{{ Object.keys(error)[0] }}</b>]: {{ error[Object.keys(error)[0]] }}
        </li>
        <li v-for="(error, index) in errors.all()">
          [API - <b>{{ index }}</b>]: {{ error }}
        </li>
      </ul>
    </ui-alert>

    <div class="row">
      <!-- Name -->
      <div class="col-sm-6">
        <ui-form-group>
          <ui-input
            v-model="creditCard.holder"
            placeholder="Nome no cartão"
          />
        </ui-form-group>
      </div>

      <!-- Number -->
      <div class="col-sm-6">
        <ui-form-group>
          <ui-credit-card
            v-model="creditCard.number"
            placeholder="Número do cartão"
          />
        </ui-form-group>
      </div>
    </div>

    <div class="row">
      <!-- Expire -->
      <div class="col-sm-6">
        <ui-form-group>
          <ui-mask
            v-model="creditCard.expire"
            placeholder="Validade"
            :mask="'99/9999'"
          />
        </ui-form-group>
      </div>

      <!-- CVV -->
      <div class="col-sm-6">
        <ui-form-group>
          <ui-mask
            v-model="creditCard.cvv"
            placeholder="CVV"
            :mask="'999'"
          />
        </ui-form-group>
      </div>
    </div>

    <!-- Installments -->
    <ui-form-group v-if="installments.length > 0">
      <ui-select
        @input="setInstallment"
      >
        <option
          v-for="installment in installments"
          :value="installment"
        >
          {{ installment.quantity }}x de {{ installment.installmentAmount * 100 | money }}
        </option>
      </ui-select>
    </ui-form-group>

    <div class="checkbox">
      <label>
        <input
          type="checkbox"
          v-model="isOwner"
          @change="$store.commit('checkout/SET_CREDIT_CARD_OWNER', isOwner)"
        >
        Sou o titular do cartão de credito
      </label>
    </div>

    <div v-if="!isOwner">

      <br>

      <!-- Alert -->
      <ui-alert state="warning">
        <b>Atenção!</b> Caso não seja o titular do cartão de crédito você deve informar os dados do titular.
      </ui-alert>

      <br>

      <div class="row">
        <!-- Name -->
        <div class="col-sm-6">
          <ui-form-group
            field="creditCard.holder.name"
            :errors="errors"
          >
            <ui-input
              :value="holder.name"
              placeholder="Nome completo"
              @input="updateHolder('name', $event)"
            />
          </ui-form-group>
        </div>
        <!-- CPF -->
        <div class="col-sm-6">
          <ui-form-group
            field="creditCard.holder.cpf"
            :errors="errors"
          >
            <ui-cpf
              :value="holder.cpf"
              placeholder="CPF"
              @input="updateHolder('cpf', $event)"
            />
          </ui-form-group>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <ui-form-group
            field="creditCard.holder.phone"
            :errors="errors"
          >
            <ui-phone
              :value="holder.phone"
              placeholder="Telefone"
              @input="updateHolder('phone', $event)"
            />
          </ui-form-group>
        </div>
        <div class="col-sm-6">
          <ui-form-group
            field="creditCard.holder.birthdate"
            :errors="errors"
          >
            <ui-date
              :value="holder.birthdate"
              placeholder="Data de nascimento"
              @input="updateHolder('birthdate', $event)"
            />
          </ui-form-group>
        </div>
      </div>
    </div>
    <div class="text-right">
      <a
        href="#"
        class="btn btn-link"
        @click.prevent="setBoleto"
      >
        Trocar para Boleto
      </a>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    data () {
      return {
        pagseguro: {
          errors: []
        },
        creditCard: {
          cvv: '',
          brand: '',
          holder: '',
          number: '',
          expire: ''
        },
        isOwner: true,
        loading: false,
        installments: []
      }
    },
    mounted () {
      let hash = window.PagSeguroDirectPayment.getSenderHash()
      
      if (hash == null || typeof hash === "undefined"){
        hash = window.PagSeguroDirectPayment.getSenderHash()
      }
      
      if (hash == null || typeof hash === "undefined"){
        hash = window.PagSeguroDirectPayment.getSenderHash()
      }
      
      this.$store.commit('checkout/SET_HOLDER_HASH', hash)
    },
    watch: {
      cardNumber (value) {
        if (value.length >= 16) {
          this.getBrand()
        }
      },

      creditCard: {
        handler () {
          this.createCardToken()
        },
        deep: true
      }
    },
    computed: {
      ...mapGetters({
        total: 'checkout/total',
        errors: 'checkout/errors',
        holder: 'checkout/holder',
        isCompleted: 'checkout/isCompleted'
      }),

      cardNumber () {
        return this.creditCard.number
      }
    },
    methods: {
      getBrand () {
        window.PagSeguroDirectPayment.getBrand({
          cardBin: this.creditCard.number,
          success: response => {
            this.creditCard.brand = response.brand.name
            this.getInstallments()
          },
          error: response => {
            this.pagseguro.errors.push(response.errors)
          }
        })
      },

      getInstallments () {
        window.PagSeguroDirectPayment.getInstallments({
          brand: this.creditCard.brand,
          amount: this.total / 100,
          maxInstallmentNoInterest: 3,
          success: (response) => {
            this.installments = response.installments[this.creditCard.brand]
          },
          error: response => {
            this.pagseguro.errors.push(response.errors)
          }
        })
      },

      createCardToken () {
        if (this.creditCard.brand && this.creditCard.expire.length >= 7 && this.creditCard.cvv.length >= 3) {
          let expire = this.creditCard.expire.split('/')

          window.PagSeguroDirectPayment.createCardToken({
            cvv: this.creditCard.cvv,
            brand: this.creditCard.brand,
            cardNumber: this.creditCard.number,
            expirationMonth: expire[0],
            expirationYear: expire[1],
            success: ({ card }) => {
              this.$store.commit('checkout/SET_CREDIT_CARD_TOKEN', card.token)
            },
            error: response => {
              this.pagseguro.errors.push(response.errors)
            }
          })
        }
      },

      setInstallment ({ quantity, installmentAmount }) {
        this.$store.commit('checkout/SET_INSTALLMENT', {
          price: installmentAmount,
          amount: quantity
        })
      },

      updateHolder (key, value) {
        this.$store.commit('checkout/UPDATE_CREDIT_CARD_HOLDER', {
          key,
          value
        })
      },

      process () {
        let data = {
          holder: this.holder,
          method: 'credit_card',
          creditCard: this.creditCard
        }

        this.pagseguro.errors = []
        this.$emit('process', 'checkout/process', data)
      },

      ...mapActions({
        setBoleto: 'checkout/setBoleto'
      })
    }
  }
</script>
