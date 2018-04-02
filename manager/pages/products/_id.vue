<template>
  <div>
    <page-header
      title="Editar produto"
      subtitle="Editar um produto"
    />
    <ui-form
      :product="product"
      @save="update"
    />
  </div>
</template>

<script>
  import UiForm from '@/components/product/forms'

  export default {
    components: {
      UiForm
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get(`/products/${params.id}?includes=seo,images,variants,shipping,category`)

      return {
        product: data.data
      }
    },
    data () {
      return {
        category: {}
      }
    },
    head () {
      return {
        title: `${this.product.seo.title}`
      }
    },
    methods: {
      toast () {
        this.$toast.open({
          message: 'Produto atualizado com sucesso!',
          type: 'is-success'
        })
      },

      update (form) {
        this.$store.dispatch('product/update', form).then(() => {
          this.toast()
        })
      }
    }
  }
</script>
