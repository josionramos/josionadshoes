<template>
  <div>
    <ui-search/>
    <ui-shopping-cart/>
    <ui-header/>
    <nuxt/>
    <ui-footer/>
  </div>
</template>

<script>
  import UiSearch from '@/components/layout/search'
  import UiHeader from '@/components/layout/header'
  import UiFooter from '@/components/layout/footer'
  import UiShoppingCart from '@/components/layout/shopping-cart'

  export default {
    components: {
      UiSearch,
      UiHeader,
      UiFooter,
      UiShoppingCart
    }
  }
</script>

<style lang="sass">
  body
    font-family: 'Montserrat', sans-serif
    font-weight: 300
    color: #898989
</style>
