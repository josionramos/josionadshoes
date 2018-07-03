<template>
  <div>
    <!-- Slider -->
    <slider/>

    <!-- Hero -->
    <hero>
      Personalize sua sandália ou rasteira com diversas cores de salto e tiras para deixar o seu look com o seu estilo e ainda leve acessórios para criar uma composição única e exclusiva.
    </hero>

    <!-- Products -->
    <div class="container">
      <ui-page-header>
        Shop
      </ui-page-header>
      <products-grid :data="products"/>
    </div>

    <!-- Instagram -->
    <instagram/>

    <!-- Newsletter -->
    <newsletter/>
  </div>
</template>

<script>
  import Hero from '@/components/hero'
  import Slider from '@/components/slider'
  import Instagram from '@/components/instagram'
  import Newsletter from '@/components/newsletter'
  import ProductsGrid from '@/components/products-grid'

  export default {
    components: {
      Hero,
      Slider,
      Instagram,
      Newsletter,
      ProductsGrid
    },
    data () {
      return {
        products: []
      }
    },
    head () {
      return {
        title: 'Página inicial'
      }
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get('/products/list?filter[featured]=true&includes=seo')

      return {
        products: data.data
      }
    }
  }
</script>
