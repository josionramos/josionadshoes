import Vue from 'vue'
import UiToast from './toast'

export default {
  open ({ state, message }) {
    const ToastComponent = Vue.extend(UiToast)

    return new ToastComponent({
      el: document.createElement('div'),
      propsData: {
        state,
        message
      }
    })
  }
}
