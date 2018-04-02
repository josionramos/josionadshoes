<template>
  <div>
    <variants :product="product"/>
  </div>
</template>

<script>
  import Variants from '../variants/variants'

  export default {
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    components: {
      Variants
    }
  }
</script>
