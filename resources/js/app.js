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
import Role from './views/sistema/Role';
import Personal from './views/sistema/Personal';
import Permiso from './views/sistema/Permiso';

//RUTAS
let routes = [
    { path:'/', name:'home', component: Home},
    { path: '/home',name: 'home',component: Home},
    { path: '/role', name: 'role',component: Role},
    { path: '/personal',name: 'personal', component: Personal},
    { path: '/permiso',name: 'permiso',component: Permiso}
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
