import moment from 'moment'
import 'moment/locale/pt-br'

moment.locale('pt-BR')

export default ({ app }, inject) => {
  inject('moment', moment)
}
