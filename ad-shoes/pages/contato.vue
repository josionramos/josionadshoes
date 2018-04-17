<template>
  <div class="contact">
    <ui-page-header>
      <h1>Fale conosco</h1>
    </ui-page-header>

    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-push-2">
          <p class="text-center">Entre em contato conosco para obter mais informações, dar sugestões ou tirar dúvidas. Novas opiniões são sempre bem vindas.</p>
        </div>
      </div>

      <br>
      <br>
      <br>

      <div class="row">
        <div class="col-sm-4 col-sm-offset-1">
          <contact-form/>
        </div>
        <div class="col-sm-4 col-sm-offset-1 info text-center">
          <div class="contact-item">
            <div class="icon">
              <i class="fa fa-whatsapp" aria-hidden="true"></i>
            </div>
            <div class="content">
              <span>WHATSAPP</span>
              <p>(54) 99988-2018</p>
            </div>
          </div>

          <p>
            Segunda à sexta das 09:00 até às 19:30<br>
            Sábado das 09:00 até às 19:00
          </p>

          <br>
          <br>

          <div class="contact-item">
            <div class="icon">
              <i class="fa fa-whatsapp" aria-hidden="true"></i>
            </div>
            <div class="content">
              <span>TELEFONE</span>
              <p>(54) 99988-2018</p>
            </div>
          </div>

          <address>Rua Waldemar Wasen 235 Bairro - Caracol, Canela/RS</address>

          <p><a href="mailto:contato@adshoes.com.br">contato@adshoes.com.br</a></p>

          <br>

          <ul class="social-medias list-unstyled">
            <li>
              <a href="https://www.facebook.com/AD-Shoes-171379423472319/" class="btn btn-light btn-circle" target="_blank">
                <ui-icon name="facebook-official"/>
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/loveadshoes/" class="btn btn-light btn-circle" target="_blank">
                <ui-icon name="instagram"/>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <google-maps/>
   </div>
</template>

<script>
  import GoogleMaps from '@/components/google-maps'
  import ContactForm from '@/components/contact/form'

  export default {
    components: {
      GoogleMaps,
      ContactForm
    },
    head () {
      return {
        title: 'Contato'
      }
    }
  }
</script>

<style lang="sass">
  .contact
    .info
      padding-top: 15px
      padding-bottom: 15px
      background: #f8f8f8

  .social-medias
    text-align: center
    margin-bottom: 0

  .contact-item
    margin-bottom: 15px
    .icon
      margin-right: 5px
      font-size: 2.5rem
      display: inline-block
    .content
      text-align: left
      line-height: 1
      display: inline-block
      span
        font-size: 1.2rem
      p
        font-size: 1.75rem
        font-weight: bold
        color: #000
</style>
