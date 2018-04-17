<template>
  <div class="container slider">
    <div class="flex">
      <div class="slider-rotator">
        <ul>
          <li v-for="n in 12" v-show="current == n"><img :src="`assets/img/360/${n}.jpg`" alt=""></li>
        </ul>
      </div>
      <div class="slider-content">
        <div>
          <h2 class="slider-title">Faça do<br><span>seu</span> jeito.</h2>
        </div>
        <br>
        <br>
        <div class="text-center">
          <nuxt-link to="colecao" class="btn btn-primary btn-outlined">Descubra</nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        current: 1
      }
    },
    mounted () {
      setInterval(() => {
        if (this.current === 12) {
          this.current = 1
        } else {
          this.current++
        }
      }, 300)
    }
  }
</script>

<style lang="sass">
  .flex
    display: flex
    flex-direction: column
    @media screen and (min-width: 768px)
      flex-direction: row

  .slider
    text-transform: uppercase

  .slider-content
    display: flex
    align-items: center
    justify-content: center
    flex-direction: column
    @media screen and (min-width: 768px)
      width: 50%

  .slider-title
    font-size: 5rem
    font-weight: 100
    text-align: center
    span
      font-weight: bold
    @media screen and (min-width: 768px)
      font-size: 6rem

  .slider-rotator
    ul
      margin: 0
      padding: 0
      list-style: none
      width: 100%
    img
      width: 100%
    @media screen and (min-width: 768px)
      width: 50%
</style>
