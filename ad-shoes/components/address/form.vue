<template>
  <form @submit.prevent="$emit('submit')">
    <div class="row">
      <!-- CEP -->
      <div class="col-sm-6">
        <ui-form-group
          label="CEP"
          field="zipcode"
          :errors="errors"
        >
          <ui-zipcode
            v-model="form.fields.zipcode"
            required
            placeholder="95901-610"
          />
        </ui-form-group>
      </div>

      <!-- Street -->
      <div class="col-sm-6">
        <ui-form-group
          label="Logradouro"
          field="street"
          :errors="errors"
        >
          <ui-input
            v-model="form.fields.street"
            required
            placeholder="Rua João da Silva"
          />
        </ui-form-group>
      </div>

      <!-- Street -->
      <div class="col-sm-6">
        <ui-form-group
          label="Número"
          field="number"
          :errors="errors"
        >
          <ui-input
            v-model="form.fields.number"
            required
            placeholder="421"
          />
        </ui-form-group>
      </div>

      <!-- Distric -->
      <div class="col-sm-6">
        <ui-form-group
          label="Bairro"
          field="district"
          :errors="errors"
        >
          <ui-input
            v-model="form.fields.district"
            required
            placeholder="Jardim das Flores"
          />
        </ui-form-group>
      </div>

      <!-- State -->
      <div class="col-sm-6">
        <ui-form-group
          label="Estado"
          field="state_id"
          :errors="errors"
        >
          <ui-select
            v-model="uf"
            placeholder="Estado"
            :disabled="cities.states === 0"
            @input="fetchCities"
          >
            <option
              v-for="state in states"
              :key="state.uf"
              :value="state.uf"
            >
              {{ state.name }}
            </option>
          </ui-select>
        </ui-form-group>
      </div>

      <!-- City -->
      <div class="col-sm-6">
        <ui-form-group
          label="Cidade"
          field="city_id"
          :errors="errors"
        >
          <ui-select
            v-model="form.fields.city_id"
            required
            placeholder="Cidade"
            :disabled="cities.length === 0"
          >
            <option
              v-for="city in cities"
              :key="city.id"
              :value="city.id"
            >
              {{ city.name }}
            </option>
          </ui-select>
        </ui-form-group>
      </div>
    </div>

    <hr>

    <div>
      <slot/>
    </div>
  </form>
</template>

<script>
  export default {
    props: {
      form: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        uf: null,
        cities: [],
        states: []
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
    mounted () {
      this.fetchStates()
    },
    methods: {
      fetchStates () {
        this.cities = []

        this.$axios.get('/addresses/states').then(({ data }) => {
          this.states = data.data

          if (this.form.fields.city) {
            this.uf = this.form.fields.city.state.uf
            this.fetchCities()
          }
        })
      },

      fetchCities () {
        let url = `/addresses/states/${this.uf}/cities`
        this.cities = []

        this.$axios.get(url).then(({ data }) => {
          this.cities = data.data
        })
      }
    }
  }
</script>
