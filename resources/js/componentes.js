import {HasError, AlertError} from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('passport-clients',require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients',require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue').default);

Vue.component('unidad-organica', require('./views/configuraciones/Institucional/UnidadOrganica.vue').default)
Vue.component('dependencia', require('./views/configuraciones/Institucional/Dependencia.vue').default)
Vue.component('cargo', require('./views/configuraciones/Institucional/Cargo.vue').default)
Vue.component('cargo-calificado', require('./views/configuraciones/Institucional/CargoCalificado.vue').default)
Vue.component('ubigeo', require('./views/configuraciones/Institucional/Ubigeo.vue').default)

Vue.component('procedimiento', require('./views/configuraciones/tupa/Procedimiento.vue').default)