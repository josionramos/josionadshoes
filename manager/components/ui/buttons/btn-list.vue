<template>
  <nuxt-link
    class="button is-primary"
    :to="to"
  >
    <b-icon icon="format-list-bulleted"/>
      <span>Listar</span>
  </nuxt-link>
</template>

<script>
  export default {
    props: {
      to: {
        type: Object,
        required: true
      }
    }
  }
</script>
