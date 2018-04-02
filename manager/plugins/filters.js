import Vue from 'vue'
import moment from 'moment'

Vue.filter('money', value => {
  let money = value / 100

  return money.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  })
})

Vue.filter('datetime', value => {
  return moment(value).format('L [às] LT')
})
