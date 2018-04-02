<template>
  <div>
    <div>
      <slot/>
    </div>
    <br>
    <hr>
    <div class="columns">
      <div v-if="save" class="column is-one-quarter">
        <button type="button" class="button is-success" :class="{ 'is-loading': loading }" @click="$emit('submit')">
          <b-icon icon="check-circle"/>
          <span>Salvar</span>
        </button>
      </div>
      <div class="column">
        <div class="field">
          <p class="control has-text-right">
            <a href="#" v-if="prev" class="button is-default" :disabled="loading" @click="goTab(prev)">
              Anterior
            </a>
            <a href="#" v-if="next" class="button is-primary" :disabled="loading" @click="goTab(next)">
              Próximo
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      prev: {
        type: [Number, Boolean]
      },
      next: {
        type: [Number, Boolean]
      },
      save: {
        type: Boolean
      }
    },
    computed: {
      ...mapGetters({
        loading: 'product/loading'
      })
    },
    methods: {
      goTab (index) {
        this.$store.commit('product/SET_TAB', index - 1)
      }
    }
  }
</script>
