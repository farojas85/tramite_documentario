require('./bootstrap')

//IMPORT GENERALS
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'
import Axios from 'axios'
import routes from './routes'
import VeeValidate, { Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es'
window.Vue = require('vue')

//USOS
Vue.use(VueRouter);
Vue.use(VueAxios,Axios);
Validator.localize("es",es)

const router = new VueRouter({
    mode: 'history',
    routes,    
})

//FILTROS
require('./filtros')

Vue.component('example-component', require('./components/ExampleComponent.vue').default)

const app = new Vue({
    el: '#app',
    router
})
