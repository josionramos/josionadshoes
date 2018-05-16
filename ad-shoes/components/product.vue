<template>
  <nuxt-link :to="to" class="product" :class="productClasses">
    <div class="product-thumb" :style="{ backgroundImage: `url(${thumbnail})` }"></div>
    <div class="product-info">
      <h4>{{ product.name }}</h4>
      <p>{{ product.price | money }}</p>
      <button class="btn btn-circle btn-light">
        <ui-icon name="shopping-bag" />
      </button>
    </div>
  </nuxt-link>
</template>

<script>
  import imageNotAvailable from '~/assets/img/img-not-available.png'

  export default {
    props: {
      size: {
        type: String,
        default: 'default'
      },
      product: {
        type: Object,
        required: true
      }
    },

    computed: {
      to () {
        return `/produto/${this.product.seo.slug}`
      },

      thumbnail () {
        if (this.product.cover) {
          return this.product.cover.thumbnail
        }

        return imageNotAvailable
      },

      productClasses () {
        return {
          'is-big': this.size === 'big',
          'is-medium': this.size === 'medium'
        }
      }
    }
  }
</script>

<style lang="sass" scoped>
  .product
    height: 250px
    display: block
    margin-bottom: 3rem
    position: relative
    border: 1px solid #898989

    &:after
      content: ''
      position: absolute
      top: 0
      left: 0
      z-index: 10
      width: 100%
      height: 100%
      color: #fff
      transition: background .5s ease

    &:hover
      &:after
        background: rgba(#000, .6)
      .product-info
        display: block

    &.is-big
      height: 500px
      .product-thumb
        height: calc(500px - 2px)

  .product-thumb
    height: calc(250px - 2px)
    overflow: hidden
    background-size: contain
    background-repeat: no-repeat
    background-position: center

  .product-info
    display: none
    position: absolute
    z-index: 20
    top: 50%
    left: 0
    width: 100%
    color: #fff
    text-align: center
    transform: translateY(-50%)

    h4
      margin: 0
      text-transform: uppercase
    p
      font-weight: 100
</style>
