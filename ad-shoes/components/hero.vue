<template>
  <div class="container">
    <section class="row hero">
      <nuxt-link to="institucional" class="col-sm-6 col-xs-12">
        <h2><span>Seu</span> sapato,<br>do <span>seu</span> jeito.</h2>
      </nuxt-link>
      <nuxt-link to="institucional" class="col-sm-6 col-xs-12">
        <p><slot></slot></p>
      </nuxt-link>
    </section>
  </div>
</template>

<style lang="sass">
  .hero
    padding: 100px 0
    a
      text-decoration: none
      p
        line-height: 2.5rem
        color: #898989
      
    h2
      font-weight: 100
      font-size: 5rem
      text-align: right
      margin: 0
      color: #d5b491
      text-transform: uppercase
      span
        font-weight: 300

    @media screen and (max-width: 768px)
        padding: 60px 0
        text-align: center
        h2
          text-align: center
          margin-bottom: 2rem
</style>
