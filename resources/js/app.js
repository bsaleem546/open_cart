
require('./bootstrap');

window.Vue = require('vue').default;

import { ValidationProvider } from 'vee-validate/dist/vee-validate.full.esm';
Vue.component('ValidationProvider', ValidationProvider);

import { ValidationObserver } from 'vee-validate';
Vue.component('ValidationObserver', ValidationObserver);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-product', require('./components/add_products.vue').default);
Vue.component('edit-product', require('./components/edit_products.vue').default);

Vue.filter('removeNullProps',function(object) {
    // sorry for using lodash and ES2015 arrow functions :-P
    return _.reject(object, (value) => value === null)
})

const app = new Vue({
    el: '#app',
});
