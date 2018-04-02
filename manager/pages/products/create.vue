<template>
  <div>
    <page-header
      title="Novo produto"
      subtitle="Adicionar novo produto"
    >
      <nuxt-link to="products" class="button is-primary">Listar</nuxt-link>
    </page-header>

    <ui-form
      @save="store"
    />
  </div>
</template>

<script>
  import UiForm from '@/components/product/forms'

  export default {
    components: {
      UiForm
    },
    head () {
      return {
        title: 'Novo produto'
      }
    },
    methods: {
      toast () {
        this.$toast.open({
          type: 'is-success',
          message: 'Produto criado com sucesso!'
        })
      },

      store (form) {
        this.$store.dispatch('product/store', form).then(id => {
          this.toast()
          this.redirect(id)
        })
      },

      redirect (id) {
        this.$router.push({
          name: 'products-id',
          params: { id }
        })
      }
    }
  }
</script>
