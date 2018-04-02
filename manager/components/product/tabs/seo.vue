<template>
  <div>
    <!-- Title -->
    <ui-field
      name="title"
      label="Título"
      :errors="errors"
    >
      <b-input
        required
        v-model="seo.title"
        placeholder="Nome"
        @input="setSlug"
      />
    </ui-field>

    <!-- Slug -->
    <ui-field
      name="slug"
      label="Slug"
      :errors="errors"
    >
      <b-input
        disabled
        :value="seo.slug"
      />
    </ui-field>

    <!-- Description -->
    <ui-field
      name="description"
      label="Descrição"
      :errors="errors"
    >
      <b-input
        required
        type="textarea"
        v-model="seo.description"
        maxlengt="160"
        placeholder="Breve descrição do produto"
      />
    </ui-field>
  </div>
</template>

<script>
  import slugify from 'slugify'
  import { mapGetters } from 'vuex'

  export default {
    props: {
      seo: {
        type: Object,
        required: true
      }
    },
    computed: {
      ...mapGetters({
        errors: 'product/errors'
      })
    },
    methods: {
      setSlug (value) {
        if (this.seo.title) {
          this.seo.slug = slugify(this.seo.title, '-').toLocaleLowerCase()
        }
      }
    }
  }
</script>
