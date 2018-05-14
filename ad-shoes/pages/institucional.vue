<template>
  <div>
    <div class="container-fluid hero">
      <div class="container">
        <ui-page-header>
          <h1>Institucional</h1>
        </ui-page-header>
        <div class="row">
          <div class="col-md-5 col-md-push-6">
            <p>AD Shoes traz coleções inovadoras aliadas a versatilidade e exclusividade, fazendo com que as clientes sejam únicas. A inspiração vem das jóias sendo utilizadas como acessórios para os calçados.</p>
          </div>
        </div>
        <div class="title">
          <span>Faça do</span>
          <p>Seu jeito</p>
        </div>
        <div class="row">
          <div class="col-md-5 col-md-push-6">
            <p>As joias trazem na sua essência formatos e cores únicos fazendo um mineral que após lapidado ou polido é colecionável para adorno pessoal, sendo apreciada pela sua beleza, grande perfeição.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container text-center">
      <div class="video">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/_YRrjq3jhKM?showinfo=0&rel=0&autoplay" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    head () {
      return {
        title: 'Institucional'
      }
    }
  }
</script>

<style lang="sass" scoped>
  .hero
    padding-bottom: 5rem
    background: url('~/assets/img/institucional.jpg') no-repeat #f9ecde
    background-size: 50%
    background-position: left center

    .title
      font-size: 7rem
      font-weight: 100
      margin: 4rem 0 8rem
      color: #000
      text-align: center
      line-height: 10rem
      text-transform: uppercase
      span
        color: #898989
        display: block
      p
        font-size: 15rem

    @media screen and (max-width: 992px)
      background-image: none
      .title p
        line-height: 12rem

  .video
      margin-top: -2rem
      display: inline-block
</style>
