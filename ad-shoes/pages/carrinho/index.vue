<template>
  <div class="container">
    <ui-page-header>
      <h1>Carrinho</h1>
    </ui-page-header>

    <div class="row">
      <div class="col-sm-8 col-sm-push-2 text-center">
        <ui-alert state="warning"><b>Hei!</b> Você não possui nenhum produto no carrinho.</ui-alert>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    head () {
      return {
        title: 'Carrinho'
      }
    }
  }
</script>
