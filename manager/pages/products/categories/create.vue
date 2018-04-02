<template>
  <div>
    <!-- Page Header -->
    <page-header
      title="Nova categoria"
      subtitle="Adicionar nova categoria de produto"
    >
      <nuxt-link to="/products/categories" class="button is-primary">Listar</nuxt-link>
    </page-header>

    <!-- Form -->
    <ui-form @submit="store" :category="category"/>
  </div>
</template>


<script>
  import UiForm from '@/components/product/category/forms'

  export default {
    components: {
      UiForm
    },
    data () {
      return {
        category: {
          name: '',
          parent_id: null,
          active: false,
          variants: []
        }
      }
    },
    head () {
      return {
        title: 'Criar categoria'
      }
    },
    mounted () {
      this.$store.dispatch('product/category/clear')
    },
    methods: {
      store (form) {
        this.$store.dispatch('product/category/store', form).then(({ id }) => {
          this.toast()
          this.redirect(id)
        })
      },

      toast () {
        this.$toast.open({
          message: `Categoria criada com sucesso!`,
          type: 'is-success'
        })
      },

      redirect (id) {
        this.$router.push({
          name: 'products-categories-id',
          params: { id }
        })
      }
    }
  }
</script>
