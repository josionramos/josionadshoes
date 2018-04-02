<template>
  <div id="map"></div>
</template>

<script>
  const KEY = 'AIzaSyD4kfRV7agTxWxTUOxNEsBNqL2_JTcv-N0'
  const SCRIPT_URL = `https://maps.googleapis.com/maps/api/js?key=${KEY}&callback=initMap`

  export default {
    data () {
      return {
        map: null
      }
    },
    mounted () {
      window.initMap = this.initMap
      this.loadGoogleMapsAPI()
    },
    methods: {
      initMap () {
        let center = {
          lat: -29.3714770,
          lng: -50.8033330
        }

        this.map = new window.google.maps.Map(this.$el, {
          zoom: 13,
          center,
          disableDefaultUI: true
        })
      },

      loadGoogleMapsAPI () {
        if (!window.google) {
          let script = document.createElement('script')
          script.src = SCRIPT_URL

          document.head.appendChild(script)
        } else {
          this.initMap()
        }
      }
    }
  }
</script>

<style lang="sass">
  #map
    position: relative
    height: 370px
    margin-top: 3rem
    margin-bottom: -4rem
    &::before
      content: ''
      width: 100%
      height: 70px
      top: 0
      left: 0
      z-index: 100
      background: linear-gradient(#fff, transparent)
      position: absolute
</style>
