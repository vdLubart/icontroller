require('./bootstrap');

import Vue from 'vue';
import App from './App';
import TableComponent from 'vue-table-component';

Vue.use(TableComponent);

new Vue({
    el: '#app',

    template: '<App/>',

    components: { App }

}).$mount('#app');
