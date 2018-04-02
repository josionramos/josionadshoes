import Vue from 'vue'
import Ui from '@/components/ui'

// Zoom
import UiZoom from '@/components/ui/zoom'

// Toast
import UiToast from '@/components/ui/toast'

for (let name in Ui) {
  Vue.component(name, Ui[name])
}

export default (context, inject) => {
  inject('zoom', UiZoom)
  inject('toast', UiToast)
}
