<template>
  <div>
    <div class="row" v-for="chunk in products">
      <div class="col-sm-6 col-xs-12">
        <div class="row">
          <div v-if="chunk[0]" class="col-sm-6 col-xs-12">
            <product :product="chunk[0]"/>
          </div>
          <div v-if="chunk[1]" class="col-sm-6 col-xs-12">
            <product :product="chunk[1]"/>
          </div>
        </div>
        <div v-if="chunk[2]">
          <product :product="chunk[2]" size="big"/>
        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div v-if="chunk[3]">
          <product :product="chunk[3]" size="big"/>
        </div>
        <div class="row">
          <div v-if="chunk[4]" class="col-sm-6 col-xs-12">
            <product :product="chunk[4]"/>
          </div>
          <div v-if="chunk[5]" class="col-sm-6 col-xs-12">
            <product :product="chunk[5]"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { chunk } from 'lodash'

  import Product from '@/components/product'

  export default {
    props: {
      data: {
        type: Array,
        required: true
      }
    },
    components: {
      Product
    },
    computed: {
      products () {
        return chunk(this.data, 6)
      }
    }
  }
</script>
