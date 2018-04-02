<template>
  <div :class="{ 'sidebar-open': $store.state.preferences.sidebarOpen }">
    <ui-sidebar></ui-sidebar>
    <main class="main">
      <ui-header></ui-header>
      <div class="columns is-marginless">
        <div class="column">
          <nuxt/>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import UiHeader from '~/components/header'
import UiSidebar from '~/components/sidebar'

export default {
  middleware: 'auth',
  components: {
    UiHeader,
    UiSidebar
  }
}
</script>

<style lang="sass">
  html
    background-color: #fff

  .main
    width: calc(100% - 200px)
    transform: translateX(200px)

  @media screen and (max-width: 768px)
    .main
      width: 100%
      transform: translateX(0)

    .sidebar-open .main
      width: calc(100% - 200px)
      transform: translateX(200px)
</style>
