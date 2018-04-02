import Vue from 'vue'
import Ui from '@/components/ui'

for (let name in Ui) {
  Vue.component(name, Ui[name])
}
