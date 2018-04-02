<template>
  <aside class="sidebar">
    <div class="sidebar-header">
      Vertex
    </div>
    <div class="sidebar-nav">
      <div class="menu">
        <p class="menu-label">Produto</p>
        <ul class="menu-list">
          <!-- <li><nuxt-link to="/products/coupons">Cupons</nuxt-link></li> -->
          <li><nuxt-link to="/products" exact>Produtos</nuxt-link></li>
          <li><nuxt-link to="/products/variants">Variações</nuxt-link></li>
          <li><nuxt-link to="/products/categories">Categorias</nuxt-link></li>
        </ul>
        <p class="menu-label">Pedidos</p>
        <ul class="menu-list">
          <li><nuxt-link to="/orders">Pedidos</nuxt-link></li>
        </ul>
        <p class="menu-label">Newsletter</p>
        <ul class="menu-list">
          <li><nuxt-link to="/newsletter/leads">Leads</nuxt-link></li>
        </ul>
        <p class="menu-label">Usuários</p>
        <ul class="menu-list">
          <li><nuxt-link to="/users">Usuários</nuxt-link></li>
          <li><nuxt-link to="/customers">Clientes</nuxt-link></li>
        </ul>
        <p class="menu-label">Configurações</p>
        <ul class="menu-list">
          <li><nuxt-link to="/settings/instagram">Instagram</nuxt-link></li>
        </ul>
      </div>
    </div>
  </aside>
</template>

<style lang="sass">
  .sidebar
    width: 200px
    position: fixed
    top: 0
    left: 0
    overflow: hidden
    min-height: 100vh
    background: #363636

  .sidebar-header
    height: 52px
    line-height: 52px
    font-size: 1.8rem
    color: #fff
    text-transform: uppercase
    text-align: center
    background-color: rgba(#000, .05)

  .sidebar-nav
    padding: .75rem
    a
      color: #fff

  @media screen and (max-width: 768px)
    .sidebar
      transform: translateX(-100%)

    .sidebar-open .sidebar
      transform: translateX(0)

</style>
