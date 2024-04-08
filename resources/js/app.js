

require('./bootstrap');
window.Vue = require('vue');

import Vuetify from 'vuetify';

Vue.use(Vuetify);


//Iconos Material Desings
import '@mdi/font/css/materialdesignicons.min.css';




//Vuetify-Money para dar formato de moneda
import VuetifyMoney from "vuetify-money";
Vue.use(VuetifyMoney);


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('app-component', require('./components/App.vue').default);

// import AppNav from './components/AppNav.vue';
// Vue.component('app-nav', AppNav);


const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});


