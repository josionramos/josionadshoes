import Vue from 'vue'
import Moment from 'moment'
import Masker from 'vanilla-masker'

Vue.filter('money', value => {
  let options = {
    style: 'currency', currency: 'BRL'
  }

  let number = value / 100

  return number.toLocaleString('pr-BR', options)
})

Vue.filter('zipcode', value => {
  return Masker.toPattern(value, '99999-999')
})

Vue.filter('datetime', value => {
  return Moment(value).format('L LT')
})
