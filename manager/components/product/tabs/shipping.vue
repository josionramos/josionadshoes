<template>
  <div>
    <div class="columns">
      <!-- Width -->
      <div class="column is-half">
        <b-field label="Comprimento"/>
        <ui-field
          name="width"
          :errors="errors"
        >
          <ui-numeric
            expanded
            v-model="shipping.width"
            delimiter=""
            :min="16"
            :max="105"
            :maxlength="3"
            :precision="0"
          />
          <p class="control">
            <a class="button is-static">cm</a>
          </p>
        </ui-field>
      </div>

      <!-- Height -->
      <div class="column is-half">
        <b-field label="Altura"/>
        <ui-field
          name="height"
          :errors="errors"
        >
          <ui-numeric
            expanded
            v-model="shipping.height"
            delimiter=""
            :min="2"
            :max="105"
            :maxlength="3"
            :precision="0"
          />
          <p class="control">
            <a class="button is-static">cm</a>
          </p>
        </ui-field>
      </div>
    </div>

    <div class="columns">
      <!-- Length -->
      <div class="column is-half">
        <b-field label="Largura"/>
        <ui-field
          name="length"
          :errors="errors"
        >
          <ui-numeric
            expanded
            v-model="shipping.length"
            delimiter=""
            :min="11"
            :max="105"
            :maxlength="3"
            :precision="0"
          />
          <p class="control">
            <a class="button is-static">cm</a>
          </p>
        </ui-field>
      </div>

      <!-- Weight -->
      <div class="column is-half">
        <b-field label="Peso"/>
        <ui-field
          name="weight"
          :errors="errors"
        >
          <ui-numeric
            expanded
            v-model="shipping.weight"
            :maxlength="5"
            :precision="0"
          />
          <p class="control">
            <span class="button is-static">gramas</span>
          </p>
        </ui-field>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      shipping: {
        type: Object,
        required: true
      }
    },
    computed: {
      ...mapGetters({
        errors: 'product/errors'
      })
    }
  }
</script>
