<template>
  <div :class="{ 'is-open': active }" class="search">
    <div class="container">
      <form>
        <a href="#" @click.prevent="toggle">
          <ui-icon name="times"/>
        </a>
        <input type="text" placeholder="Digite aqui o que você procura">
        <ui-icon name="search"/>
      </form>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    computed: {
      ...mapGetters({
        active: 'search/isActive'
      })
    },
    methods: {
      ...mapActions({
        toggle: 'search/toggle'
      })
    }
  }
</script>

<style lang="sass">
  .search
    position: fixed
    z-index: 1000
    width: 100%
    height: 100%
    padding-top: 40vh
    top: 0
    left: 0
    text-align: center
    transition: .5s ease
    transform: translateX(-100%)
    background: rgba(#000, .9)

    &.is-open
      transform: translateX(0)

    form
      display: inline-block

    input
      width: 300px
      padding: 6px 12px
      border: 1px solid #898989;
      background: transparent

    .fa
      padding: 0 1rem
      color: #fff
</style>
