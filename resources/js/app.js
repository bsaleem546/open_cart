
require('./bootstrap');

window.Vue = require('vue').default;

import { ValidationProvider } from 'vee-validate/dist/vee-validate.full.esm';
Vue.component('ValidationProvider', ValidationProvider);

import { ValidationObserver } from 'vee-validate';
Vue.component('ValidationObserver', ValidationObserver);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-product', require('./components/add_products.vue').default);
Vue.component('edit-product', require('./components/edit_products.vue').default);


const app = new Vue({
    el: '#app',
});
