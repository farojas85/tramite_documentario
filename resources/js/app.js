require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';

Vue.use(VueRouter);
Vue.use(VueAxios);

//IMportando VISTAS VUE
import App from './components/App';
import Home from './views/Home';
//RUTAS
let routes = [
    { path:'/', name:'home', component: Home}
];

const router = new VueRouter({
    mode: 'history',
    routes,    
});

//PARTIALS COMPONENTEs
require('./partials');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    components: { App},
    router
});
