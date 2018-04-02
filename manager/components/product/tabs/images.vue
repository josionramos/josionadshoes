<template>
  <div>
    <gallery :product="product"/>
  </div>
</template>

<script>
  import Gallery from '../gallery/gallery'

  export default {
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    components: {
      Gallery
    }
  }
</script>
