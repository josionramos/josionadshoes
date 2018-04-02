<template>
  <b-input
    type="text"
    expanded
    :min="min"
    :max="max"
    :size="size"
    :required="required"
    :disabled="disabled"
    :maxlength="maxlength"
    :has-counter="hasCounter"
    :placeholder="placeholder"
    @input.native="input"
  />
</template>

<script>
  import VMasker from 'vanilla-masker'

  export default {
    props: {
      required: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      },
      expanded: {
        type: Boolean,
        default: false
      },
      value: {
        default: ''
      },
      prefix: {
        type: String,
        default: ''
      },
      precision: {
        type: Number,
        default: 2
      },
      separator: {
        type: String,
        default: ','
      },
      delimiter: {
        type: String,
        default: '.'
      },
      hasCounter: {
        type: Boolean,
        default: false
      },
      min: Number,
      max: Number,
      size: String,
      maxlength: Number,
      placeholder: String
    },
    data () {
      return {
        el: null,
        options: {}
      }
    },
    mounted () {
      this.options = {
        unit: this.prefix,
        separator: this.separator,
        delimiter: this.delimiter,
        precision: this.precision
      }

      this.el = this.$el.querySelector('input')

      if (this.value) {
        this.apply(this.value)
      }
    },
    watch: {
      value (value) {
        this.apply(value)
      }
    },
    methods: {
      /**
       * Emit input event
       *
       * @param  {InputEvent}  e
       */
      input (e) {
        this.$emit('input', this.raw(this.apply(e.target.value)))
      },

      /**
       * Get the raw value
       *
       * @param  {String}  value
       * @return {String}
       */
      raw (value) {
        return VMasker.toNumber(value)
      },

      /**
       * Mask the value
       *
       * @param  {String}  value
       * @return {String}
       */
      mask (value) {
        return VMasker.toMoney(value, this.options)
      },

      /**
       * Apply mask
       *
       * @param  {String}  value
       * @return {String}
       */
      apply (value) {
        this.el.value = this.mask(value)

        return this.el.value
      }
    }
  }
</script>
