import Vue from 'vue'
import UiZoom from './zoom'

export default {
  open ({ src }) {
    const ZoomComponent = Vue.extend(UiZoom)

    return new ZoomComponent({
      el: document.createElement('div'),
      propsData: {
        src
      }
    })
  }
}
