<template>
  <b-autocomplete
    v-model="query"
    :data="data"
    :field="field"
    :loading="loading"
    :placeholder="placeholder"
    @blur="blur"
    @input="input"
    @select="select"
  >
  </b-autocomplete>
</template>

<script>
  import debounce from 'lodash/debounce'

  export default {
    props: {
      data: {
        type: Array,
        required: true
      },
      field: {
        type: String,
        required: true
      },
      loading: {
        type: Boolean,
        default: false
      },
      value: Object,
      placeholder: String
    },
    data () {
      return {
        query: '',
        selected: this.value[this.field]
      }
    },
    created () {
      if (this.selected) {
        this.query = this.selected
      }
    },
    methods: {
      blur () {
        if (!this.selected) {
          this.query = ''
        } else {
          this.query = this.selected
        }
      },

      select (option) {
        if (option) {
          this.$emit('input', option)
          this.selected = option[this.field]
        }
      },

      input: debounce(function () {
        if (this.query.length >= 2) {
          if (this.selected && this.selected === this.query) {
            return
          }

          this.$emit('query', this.query)
        }

        if (this.query === '' && this.selected) {
          this.selected = null
          this.$emit('input', null)
        }
      }, 500)
    }
  }
</script>
