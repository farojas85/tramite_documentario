import {HasError, AlertError} from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('passport-clients',require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients',require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue').default);

Vue.component('unidad-organica', require('./views/configuraciones/UnidadOrganica.vue').default)
Vue.component('dependencia', require('./views/configuraciones/Dependencia.vue').default)