<template>
  <div class="container">
    <!-- 404 -->
    <div v-if="isNotFound" class="text-center">
      <ui-page-header>
        <h1>404</h1>
      </ui-page-header>

      <h2 class="title">A página não foi encontrada!</h2>

      <p>Se você digitou a URL diretamente, por favor, tenha certeza que ela esteja digitada corretamente.<br>Se você clicou em algum link e chegou aqui, o link está desatualizado</p>

      <br>

      <nuxt-link to="/" class="btn btn-primary btn-outlined btn-lg">
        Voltar para a página inicial
      </nuxt-link>
    </div>

    <div v-else>
      <pre>{{ error }}</pre>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['error'],
    head () {
      return {
        title: this.isNotFound ? 'Página não encontrada' : 'Ups, algo deu errado'
      }
    },
    computed: {
      isNotFound () {
        return this.error.statusCode === 404
      }
    }
  }
</script>
