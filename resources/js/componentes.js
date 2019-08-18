import {HasError, AlertError} from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('unidad-organica', require('./views/configuraciones/UnidadOrganica.vue').default)
Vue.component('dependencia', require('./views/configuraciones/Dependencia.vue').default)