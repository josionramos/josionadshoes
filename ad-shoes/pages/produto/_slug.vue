<template>
  <div class="container">
    <!-- Page header -->
    <ui-page-header>
      <h1>Shop</h1>
    </ui-page-header>

    <div class="row">
      <!-- Gallery -->
      <div class="col-sm-6">
        <gallery v-model="currentImage" :images="product.images"/>
      </div>

      <!-- Info -->
      <div class="col-sm-6 info">
        <p v-if="product.sku" class="ref">REF {{ product.sku }}</p>

        <!-- Price -->
        <div class="row">
          <div class="col-xs-6">
            <div class="price">
              <template v-if="product.price_sale">
                <p class="old">De <strike>{{ product.price | money }}</strike> por</p>
                <p class="new">{{ product.price_sale | money }}</p>
              </template>
              <template v-else>
                <p class="new">{{ product.price | money }}</p>
              </template>
              <p class="installments">Ou <b>3X de {{ product.price / 3 | money }}</b> sem juros</p>
            </div>
          </div>

          <!-- Buy button -->
          <div class="col-xs-6">
            <button
              class="btn btn-primary btn-outlined btn-block btn-lg"
              :disabled="!canBuy"
              @click="addToCart"
            >
              <ui-icon name="shopping-bag"/> Comprar
            </button>
          </div>
        </div>

        <br>
        <br>

        <div class="row">
          <!-- Sizes -->
          <div v-if="sizes" class="col-sm-3">
            <div class="form-group">
              <label>Tamanhos</label>
              <select
                v-model="variants.size"
                class="form-control"
                @change="changeVariant"
              >
                <option value="">Selecione</option>
                <option v-for="size in sizes" :value="size.id">{{ size.value }}</option>
              </select>
            </div>
          </div>

          <!-- Colors -->
          <div v-if="colors" class="col-sm-8">
            <div class="form-group">
              <label>Cores</label>
              <div>
                <ui-color
                  v-for="color in colors"
                  v-model="variants.color"
                  :key="color.id"
                  :color="color"
                  @changeButton="changeValue"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Description -->
        <div>
          <p class="title">Sobre a peça</p>
          <div v-html="product.content"></div>
        </div>
      </div>
    </div>

    <div class="row product-relateds">
      <ui-page-header>
        <h3>Combina com</h3>
      </ui-page-header>
      <ui-loading v-if="loading" message="Carregando relacionados..."/>
      <div v-for="item in relateds" class="col-sm-3">
        <product :product="item"/>
      </div>
    </div>
  </div>
</template>

<script>
  import Product from '@/components/product'
  import Gallery from '@/components/product/gallery'

  export default {
    components: {
      Product,
      Gallery
    },
    head () {
      return {
        title: this.product.seo.title,
        meta: [
          { hid: 'description', name: 'description', content: this.product.seo.description }
        ]
      }
    },
    data () {
      return {
        item: {
          color: null
        },
        product: null,
        relateds: [],
        variants: {
          size: '',
          color: null
        },
        loading: false,
        currentImage: null
      }
    },
    async asyncData ({ params, app: { $axios } }) {
      console.log('asyncData')
      let { data } = await $axios.get(`/products/slug/${params.slug}?includes=seo,variants,images`)

      return {
        product: data.data
      }
    },
    mounted () {
      console.log('mounted')
      this.fetchRelateds()
      this.currentImage = this.product.images[0]
    },

    computed: {
      colors () {
        let colors = this.product.variants['cor']
        console.log('computed colors 1: ' + [colors])
        if (colors) {
          console.log('computed colors 2: ' + [colors.filter(item => item.extra)])
          return colors.filter(item => item.extra)
        }
        return null
      },

      sizes () {
        console.log('computed sizes: ' + this.product.variants['tamanho'])
        return this.product.variants['tamanho']
      },

      price () {
        // console.log('computed price')
        return this.product.price_sale ? this.product.price_sale : this.product.sale
      },

      canBuy () {
        console.log('computed canBuy')
        if (this.sizes) {
          console.log('canBuy s1: ' + [this.sizes])
          if (this.variants.size) {
            console.log('canBuy s2: ' + [this.variants.size])
          }
        }
        if (this.colors) {
          console.log('canBuy c1: ' + [this.colors])
          if (this.variants.color) {
            console.log('canBuy c2: ' + [this.variants.color])
          }
        }

        if (this.colors && this.sizes) {
          console.log('computed canBuy if (this.colors && this.sizes) {')
          return this.variants.color && this.variants.size
        } else if (this.colors) {
          console.log('computed canBuy if (this.colors) {')
          return this.variants.color
        } else if (this.sizes) {
          console.log('computed canBuy if (this.sizes) {')
          return this.variants.size
        } else {
          console.log('computed canBuy else without variants to be select')
          return true
        }
        // return (this.colors && this.variants.color) || (this.sizes && this.variants.size)
      }
    },
    methods: {
      addToCart () {
        console.log('methods addToCart')
        let data = {
          product: this.product,
          variants: {}
        }

        if (this.variants.size) {
          console.log('addToCart size: ' + [this.variants.size.value])
          data['variants']['size'] = this.variants.size
        }

        if (this.variants.color) {
          console.log('addToCart color: ' + [this.variants.color.value])
          data['variants']['color'] = this.variants.color
        }
        console.log('addToCart finalizar')

        this.$store.dispatch('order/add', data).then(() => {
          this.$store.dispatch('shopping-cart/open')
        })
      },

      changeVariant (e) {
        console.log(e.target.value)
        let value = parseInt(e.target.value)
        let variant = this.sizes.find(item => item.id === value)
        if (variant.media) {
          this.currentImage = variant.media
        }
      },

      changeValue (e) {
        console.log('methods changeValue: ' + [e.value])
        this.variants.color = e
      },

      fetchRelateds () {
        console.log('methods fetchRelateds')
        this.loading = true

        this.$axios.get(`products/${this.product.id}/relateds?includes=seo&limit=4`).then(({ data }) => {
          this.relateds = data.data
          this.loading = false
        })
      }
    }
  }
</script>

<style lang="sass" scoped>
  .info
    .title
      margin: 15px 0 10px
      color: #000
      font-weight: bold
      text-transform: uppercase

  .price
    p
      margin: 0
    .new
      font-size: 2.5rem
      font-weight: bold
      color: #000
    .installments
      text-transform: uppercase

  .ref
    font-size: 1.75rem
    color: #000
    margin-bottom: 25px

  .product-relateds
    margin-top: 5rem
</style>
