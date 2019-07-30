require('./bootstrap');

window.Vue = require('vue');

//VISTAS VUE
import App from './components/App';

//PARTIALS COMPONENTEs
require('./partials');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    components: { App},
});
