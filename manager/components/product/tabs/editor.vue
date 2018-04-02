<template>
  <quill-editor
    ref="myTextEditor"
    v-model="newValue"
    @input="input"
  />
</template>

<script>
  export default {
    props: {
      content: String
    },
    data () {
      return {
        newValue: this.content
      }
    },
    methods: {
      input () {
        this.$emit('update:content', this.newValue)
      }
    }
  }
</script>
