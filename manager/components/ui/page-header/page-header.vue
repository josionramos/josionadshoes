<template>
  <section class="page-header level">
    <div class="level-left">
      <div>
        <h1 v-html="title" class="title"></h1>
        <h2 v-if="subtitle" v-html="subtitle" class="subtitle"></h2>
      </div>
    </div>
    <div class="level-right">
      <slot></slot>
    </div>
  </section>
</template>

<script>
  export default {
    props: {
      title: String,
      subtitle: String
    }
  }
</script>

<style lang="sass">
  .page-header
    margin: -.75rem
    padding: 2rem .75rem
    background-color: #f9f9f9
    border-bottom: 1px solid #eee
    .title
      font-size: 1.5rem
    .subtitle
      font-size: 1.125rem
      color: #999
</style>
