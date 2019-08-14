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
import VueProgressBar from 'vue-progressbar'

window.Vue = require('vue')
window.swal = swal
window.form  = Form

//USOS
Vue.use(VueRouter);
Vue.use(VueAxios,Axios);
Vue.use(VeeValidate);
Validator.localize("es",es)
Vue.use(VueProgressBar,{
    color: 'rgb(143,255,199)',
    failedColor: 'red',
    height: '5px'
})

//REQUIRE 
require('./filtros')
require('./componentes')

const router = new VueRouter({
    mode: 'history',
    routes,    
})



Vue.component('example-component', require('./components/ExampleComponent.vue').default)


const app = new Vue({
    el: '#app',
    router
})
