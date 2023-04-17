/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";


// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'sweetalert2/dist/sweetalert2.min.css';

// Toast
import Toastr from 'vue-toastr';
Vue.use(Toastr);


//=========Form validation library=====
import Vuelidate from 'vuelidate';
Vue.use(Vuelidate)

Vue.component("v-select", vSelect);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



// Vue.component('v-select', VueSelect.VueSelect);
Vue.component('dashboard', require('./components/Dashboards/Dashboard.vue').default);
Vue.component('dashboardnopermission', require('./components/Dashboards/DashboardNoPermission.vue').default);
Vue.component('dashboardnoformscreated', require('./components/Dashboards/DashboardNoFormsCreated.vue').default);
Vue.component('dashboardnoformsassigned', require('./components/Dashboards/DashboardNoFormsAssigned.vue').default);
Vue.component('create-form', require('./components/form/CreateForm.vue').default);
Vue.component('form-list', require('./components/form/FormList.vue').default);
Vue.component('form-users', require('./components/form/FormUsers.vue').default);
Vue.component('form-data', require('./components/form/FormData.vue').default);
Vue.component('form-viewers', require('./components/form/FormViewers.vue').default);
Vue.component('collected-form-data', require('./components/form/CollectedFormData.vue').default);
Vue.component('form-list-assigned', require('./components/form/FormListAssigned.vue').default);
Vue.component('collect-form-data', require('./components/form/CollectFormData.vue').default);
Vue.component('export-data', require('./components/ExportData.vue').default);

Vue.component('help-center', require('./components/HelpCenter.vue').default);


const app = new Vue({
    el: '#app',
    methods: {
        openOrCloseMenu() {
            $("#unicef-nav-menu").toggle();
        },
    },


    mounted() {
        // jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
        //     icons: {
        //         time: "far fa-clock",
        //         date: "far fa-calendar-alt",
        //         up: "fas fa-chevron-up",
        //         down: "fas fa-chevron-down",
        //         previous: 'fas fa-chevron-left',
        //         next: 'fas fa-chevron-right',
        //         today: 'fas fa-calendar-check',
        //         clear: 'far fa-trash-alt',
        //         close: 'far fa-times-circle'
        //     }
        // });
    }
});


