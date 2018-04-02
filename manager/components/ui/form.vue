<template>
  <form @submit.prevent="submit" class="form-box">
    <div>
      <slot></slot>
    </div>
    <div v-if="showActions">
      <br>
      <hr>
      <div class="field is-grouped">
        <p class="control">
          <button type="submit" class="button is-primary" :disabled="loading">{{ submitLabel }}</button>
        </p>
        <p class="control">
          <button type="button" class="button" @click="back" :disabled="loading">Voltar</button>
        </p>
      </div>
    </div>
  </form>
</template>

<script>
  export default {
    props: {
      submitLabel: {
        type: String,
        default: 'Salvar'
      },
      showActions: {
        type: Boolean,
        default: true
      },
      loading: Boolean
    },
    methods: {
      submit () {
        this.$emit('submit')
      },

      back () {
        this.$router.go(-1)
      }
    }
  }
</script>

<style lang="sass">
  .form-box
    padding: .75rem
    background: #fff

    .tab-item
      padding-top: .75rem
</style>
