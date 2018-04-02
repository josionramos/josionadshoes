<template>
  <div>
    <!-- Page Header -->
    <page-header
      title="Editar categoria"
      subtitle="Editar categoria de produto"
    >
      <nuxt-link to="categories" class="button is-primary">Listar</nuxt-link>
    </page-header>

    <!-- Form -->
    <ui-form @submit="update" :category="category"/>
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
        category: {}
      }
    },
    head () {
      return {
        title: 'Editar categoria'
      }
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get(`/products/categories/${params.id}?includes=variants`)

      return {
        category: data.data
      }
    },
    mounted () {
      this.$store.dispatch('product/category/clear')
    },
    methods: {
      update (data) {
        this.$store.dispatch('product/category/update', data).then(() => {
          this.$toast.open({
            message: 'Categoria atualizada com sucesso!',
            type: 'is-success'
          })
        })
      }
    }
  }
</script>
