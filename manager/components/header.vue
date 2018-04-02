<template>
  <header class="header">
    <nav class="nav">
      <div class="sidebar-trigger" @click="$store.commit('TOGGLE_SIDEBAR')">
        <b-icon icon="menu"/>
      </div>
      <div class="nav-menu">
        <b-dropdown position="is-bottom-left">
          <a class="navbar-item" slot="trigger">
            <span>{{ $store.state.auth.user.name }}</span>
            <b-icon icon="menu-down"></b-icon>
          </a>
          <b-dropdown-item @click="logout" value="logout">
            <b-icon icon="logout"></b-icon>
            Sair
          </b-dropdown-item>
        </b-dropdown>
      </div>
    </nav>
  </header>
</template>

<script>
  export default {
    methods: {
      logout () {
        this.$store.dispatch('auth/logout').then(() => {
          this.$router.push('/')
        })
      }
    }
  }
</script>

<style lang="sass">
  .header
    height: 52px
    background: #fff
    border-bottom: 1px solid #eee

  .nav
    display: flex
    align-items: center
    justify-content: flex-end
    .navbar-item
      padding: 14px .75rem 13px .75rem

  .sidebar-trigger
    width: 2rem
    height: 2rem
    display: none
    background: #eee
    align-items: center
    margin-left: .75rem
    justify-content: center
    .icon .mdi
      font-size: 24px

  @media screen and (max-width: 768px)
    .nav
      justify-content: space-between
      .navbar-item
        padding: 11px .75rem 13px .75rem
    .sidebar-trigger
      display: flex
</style>
