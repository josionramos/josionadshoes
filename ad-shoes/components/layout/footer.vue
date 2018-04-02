<template>
  <footer class="footer">
    <!-- LOGO -->
    <div class="logo">
      <nuxt-link to="/" class="hvr-pop">
        <img src="~/assets/img/logo.png" alt="AD Shoes">
      </nuxt-link>
    </div>

    <br>
    <br>

    <!-- SOCIAL MEDIAS -->
    <ul class="social-medias list-unstyled">
      <li>
        <a href="https://www.facebook.com/AD-Shoes-171379423472319/" class="btn btn-light btn-circle hvr-float" target="_blank">
          <ui-icon name="facebook-official"/>
        </a>
      </li>
      <li>
        <a href="https://www.instagram.com/loveadshoes/" class="btn btn-light btn-circle hvr-float" target="_blank">
          <ui-icon name="instagram"/>
        </a>
      </li>
    </ul>

    <br>

    <!-- NAV -->
    <ul class="footer-navbar">
      <li>
        <nuxt-link to="/">Home</nuxt-link>
      </li>
      <li>
        <nuxt-link to="/colecao">Coleção</nuxt-link>
      </li>
      <li>
        <nuxt-link to="/institucional">Institucional</nuxt-link>
      </li>
      <li>
        <nuxt-link to="/contatos">Fale conosco</nuxt-link>
      </li>
      <li>
        <nuxt-link to="/termos-e-politicas">Termos e políticas</nuxt-link>
      </li>
    </ul>

    <br>
    <br>

    <!-- PAYMENTS -->
    <img src="~/assets/img/payments.png" alt="O pagamento é realizado pelo PagSeguro, oferecendo boleto bancário pelo Santander e os seguintes cartões de créditos: Visa, MasterCard, Amex, Dinners, Hipercard e Elo" class="payments-brand">

    <br>
    <br>
    <br>

    <!-- COPYRIGHT -->
    <p class="copyright">Copyright &copy; 2018 ADSHOES. <span class="will-break">Todos os direitos reservados.</span></p>

    <br>
    <br>

    <!-- PARTNERS CO -->
    <a href="http://partnersco.com.br" target="_blank" class="partnersco">
      <img src="~/assets/img/partnersco.svg" alt="Partners CO">
    </a>
  </footer>
</template>

<script>
  export default {
    //
  }
</script>

<style lang="sass">
  .footer
    margin-top: 4rem
    padding-top: 6rem
    text-align: center
    background: #ececeb

  .footer-navbar
    list-style: none
    text-transform: uppercase
    li
      display: inline-block
      margin-right: 2rem
    a
      color: #898988

    @media screen and (max-width: 768px)
      li
        display: block
        padding: .5rem 0

  .social-medias
    li
      margin: 0 1rem
      display: inline-block

  .payments-brand
    max-width: 80%
    display: block
    margin: 0 auto

  .copyright
    font-weight: 300
    margin: 0
    color: #bbb
    @media screen and (max-width: 480px)
      .will-break
        display: block

  .partnersco
    display: inline-block
    img
      width: 50px
</style>
