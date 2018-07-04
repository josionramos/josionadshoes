<template>
  <div class="container">
    <!-- Page header -->
    <ui-page-header>
      <h1>Coleção</h1>
    </ui-page-header>

    <!-- Filter -->
    <!--
    <div class="form-inline text-right">
      <ui-form-group label="Filtrar por">
        <ui-select
          v-model="category"
          @input="fetch"
          placeholder="Categoria"
        >
          <option value="">Todas</option>
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </ui-select>
      </ui-form-group>
    </div>
    -->

    <br>

    <ui-loading v-if="loading"/>

    <p v-if="data.length === 0 && !loading" class="text-center">
      Ups! Nenhum produto encontrado :/
    </p>

    <products-grid :data="data"/>

    <!-- Load more -->
    <div v-if="meta.current_page !== meta.last_page" class="text-center">
      <a href="#" class="btn btn-primary btn-outlined btn-lg" @click="loadMore">Veja mais</a>
    </div>
  </div>
</template>

<script>
  import ProductsGrid from '@/components/products-grid'

  function queryStringBuilder (obj) {
    let str = []

    for (let p in obj) {
      if (obj.hasOwnProperty(p)) {
        str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]))
      }
    }

    return str.join('&')
  }

  export default {
    components: {
      ProductsGrid
    },
    data () {
      return {
        page: 1,
        meta: [],
        data: [],
        loading: false,
        category: null,
        categories: []
      }
    },
    head () {
      return {
        title: 'Coleção'
      }
    },
    mounted () {
      this.fetchCategories()
    },
    async asyncData ({ params, app: { $axios } }) {
      let { data } = await $axios.get('/products/list?includes=seo')

      return {
        meta: data.meta,
        data: data.data
      }
    },
    methods: {
      fetch () {
        let url = '/products/list?includes=seo'
        let query = {
          page: this.page
        }

        if (this.category) {
          query['filter[category_id]'] = this.category
        }

        this.data = []
        this.loading = true

        this.$axios.get(url + '&' + queryStringBuilder(query)).then(({ data }) => {
          this.data = data.data
          this.loading = false
        })
      },

      loadMore () {
        this.page++
        this.fetch()
      },

      fetchCategories () {
        this.$axios.get('/products/categories/list').then(({ data }) => {
          this.categories = data.data
        })
      }
    }
  }
</script>
