require('./bootstrap')

//IMPORT GENERALS
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'
import Axios from 'axios'

import routes from './routes'
import VeeValidate, { Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es'
import swal from 'sweetalert2';
import Form  from 'vform'

window.Vue = require('vue')
window.swal = swal
window.Form  = Form
//REQUIRE 
require('./filtros')
require('./componentes')

//USOS
Vue.use(VueRouter);
Vue.use(VueAxios,Axios);
Vue.use(VeeValidate);
Validator.localize("es",es)

const router = new VueRouter({
    mode: 'history',
    routes,    
})



Vue.component('example-component', require('./components/ExampleComponent.vue').default)

const app = new Vue({
    el: '#app',
    router
})
