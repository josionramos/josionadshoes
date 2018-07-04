<template>
  <nav class="navbar navbar-default">
    <div class="container">
      <!-- HEADER -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false" @click.prevent="toggleNav">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <nuxt-link to="/" class="hvr-pop navbar-brand">
          <img src="~/assets/img/adshoes.png" alt="AD Shoes">
        </nuxt-link>
      </div>

      <!-- NAV -->
      <transition name="fade">
        <div v-if="isNavActive" id="main-navbar" class="collapse navbar-collapse in">
          <ul class="nav navbar-nav navbar-right navbar-icons">
            <!--
            <li>
              <a href="#" class="hvr-push" @click.prevent="toggleSearch">
                <ui-icon name="search"/>
              </a>
            </li>
            -->
            <li>
              <nuxt-link class="hvr-push" :to="userLink">
                <ui-icon name="user"/>
              </nuxt-link>
            </li>
            <li>
              <a href="#" class="hvr-push" @click.prevent="openShoppingCart">
                <ui-icon name="shopping-bag"/>
              </a>
            </li>
            <li>
              <a href="https://www.facebook.com/AD-Shoes-171379423472319/" class="hvr-push" target="_blank">
                <ui-icon name="facebook-official"/>
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/loveadshoes/" class="hvr-push" v-tooltip="'basic one'" target="_blank">
                <ui-icon name="instagram"/>
              </a>
            </li>
          </ul>

          <!-- NAV -->
          <ul class="nav navbar-nav navbar-right">
            <li>
              <nuxt-link to="/colecao">Coleção</nuxt-link>
            </li>
            <li>
              <nuxt-link to="/institucional">Institucional</nuxt-link>
            </li>
            <li>
              <nuxt-link to="/contato">Fale conosco</nuxt-link>
            </li>
          </ul>
        </div>
      </transition>
    </div>
  </nav>
</template>

<script>
  import { debounce } from 'lodash'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    mounted () {
      this.resize()
      window.addEventListener('resize', debounce(this.resize, 500))
    },
    computed: {
      ...mapGetters({
        isNavActive: 'nav/isActive'
      }),

      userLink () {
        return this.$store.getters['auth/isLoggedIn'] ? '/minha-conta/meus-dados' : '/entrar'
      }
    },
    methods: {
      ...mapActions({
        openNav: 'nav/open',
        closeNav: 'nav/close',
        toggleNav: 'nav/toggle',
        toggleSearch: 'search/toggle',
        openShoppingCart: 'shopping-cart/open'
      }),

      resize () {
        if (document.body.clientWidth >= 768) {
          this.openNav()
        } else {
          this.closeNav()
        }
      }
    }
  }
</script>

<style lang="sass">
  .navbar
    min-height: 120px
    margin-bottom: 0
    border: none

  .navbar-default
    background: #fff
    border-radius: 0

  .navbar-brand
    height: 106.5px
    line-height: 1
    padding: 13.5px 0 13.5px 15px

  .navbar-toggle
    margin-top: 43px
    border-radius: 0

  .navbar-nav
    margin-top: 35px
    a
      text-transform: uppercase

  @media screen and (max-width: 992px) and (min-width: 768px)
    .nav > li > a
      font-size: 1.2rem
      padding-left: 10px
      padding-right: 10px

  @media screen and (max-width: 768px)
    .navbar-brand img
      height: 79.5px

    .navbar-nav
      margin-top: 1rem
      text-align: center

    .navbar-icons
      li
        display: inline-block
      a
        font-size: 2rem
</style>
