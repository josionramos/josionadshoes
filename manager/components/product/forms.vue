<template>
  <ui-form
    :show-actions="false"
  >
    <b-tabs
      type="is-boxed"
      :value="tab"
      @input="goTab"
    >
      <!-- TAB: General -->
      <b-tab-item label="Geral">
        <tab :next="2" :save="form.id > 0" @submit="save">
          <general :product="form"/>
        </tab>
      </b-tab-item>

      <!-- TAB: SEO -->
      <b-tab-item label="SEO">
        <tab :next="3" :prev="1" :save="form.id > 0" @submit="save">
          <seo :seo="form.seo"/>
        </tab>
      </b-tab-item>

      <!-- TAB: Shipping -->
      <b-tab-item label="Frete">
        <tab :next="form.id > 0 ? 4 : 0" :prev="2" :save="true" @submit="save">
          <shipping :shipping="form.shipping"/>
        </tab>
      </b-tab-item>

      <!-- TAB: Editor -->
      <b-tab-item v-if="form.id" label="Conteúdo">
        <tab :next="5" :prev="3" :save="true" @submit="save">
          <editor :content.sync="form.content"/>
        </tab>
      </b-tab-item>

      <!-- TAB: Images -->
      <b-tab-item v-if="form.id" label="Imagens">
        <tab :next="6" :prev="4">
          <images :product="form"/>
        </tab>
      </b-tab-item>

      <!-- TAB: Variants -->
      <b-tab-item v-if="form.id" label="Variações">
        <tab :prev="5">
          <variants :product="form"/>
        </tab>
      </b-tab-item>
    </b-tabs>
  </ui-form>
</template>

<script>
  import Tab from './tab'
  import Seo from './tabs/seo'
  import Editor from './tabs/editor'
  import Images from './tabs/images'
  import General from './tabs/general'
  import Shipping from './tabs/shipping'
  import Variants from './tabs/variants'

  import { mapGetters } from 'vuex'

  export default {
    props: {
      product: Object
    },
    components: {
      Tab,
      Seo,
      Editor,
      Images,
      General,
      Shipping,
      Variants
    },
    data () {
      return {
        form: {
          id: null,
          name: '',
          sku: '',
          price: '',
          price_sale: '',
          content: '',
          category_id: null,
          active: false,
          featured: false,
          seo: {
            title: '',
            slug: '',
            description: ''
          },
          shipping: {
            width: '',
            height: '',
            length: '',
            weight: ''
          },
          variants: []
        }
      }
    },
    created () {
      if (this.product) {
        this.form = this.product
      }
    },
    computed: {
      ...mapGetters({
        tab: 'product/tab',
        errors: 'product/errors',
        loading: 'product/loading'
      })
    },
    methods: {
      goTab (index) {
        this.$store.commit('product/SET_TAB', index)
      },

      save () {
        this.$emit('save', this.form)
      }
    }
  }
</script>
