/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import VueRouter from 'vue-router';
import { Form, HasError, AlertError } from 'vform';
import Swal from 'sweetalert2';
import VueProgressBar from 'vue-progressbar';
import vSelect from 'vue-select';
import Gate from "./Gate";
import VueBarcodeScanner from 'vue-barcode-scanner';
Vue.prototype.$gate = new Gate(window.user);
import downloadexcel from "vue-json-excel";
import JsonExcel from 'vue-json-excel';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('downloadExcel', JsonExcel)
Vue.component('v-select', vSelect)
Vue.use(require('vue-shortkey'))
Vue.use(VueBarcodeScanner)

// import HotelDatePicker from 'vue-hotel-datepicker';
// Vue.component('HotelDatePicker', HotelDatePicker);

// SWEET ALERT
window.Swal = Swal;
window.Fire = new Vue();

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

Vue.filter('myDate', function(created) {
    return moment(created).format('MMM. DD, YYYY ');
});
Vue.filter('myDateTime', function(created) {
    return moment(created).format('MMM. DD, YYYY h:mm:ss a');
});

Vue.filter('cheque_date', function(created) {
    return moment(created).format('MM / DD / YYYY');
});

Vue.filter('billingDate', function(created) {
    return moment(created).format('MMMM YYYY');
});

Vue.filter('toCurrency', function(value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('zh-CN', {
        style: 'currency',
        currency: 'Php'
    }); //
    return formatter.format(value);
});

Vue.filter('timeFilter', function(boothTime) {
    return moment(boothTime, ["h:mm A"]).format('h:mm a');
});



window.toast = toast;

// import VueProgressBar from 'vue-progressbar';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.use(VueProgressBar, {
//     color: 'red',
//     failedColor: 'red',
//     height: '40px'
// });

Vue.filter('capitalize', function(value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('toCurrency', function(value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('zh-CN', {
        style: 'currency',
        currency: 'Php'
    }); //
    return formatter.format(value);
});

Vue.filter('toPositive', function(value) {
    return Math.abs(value);
});


Vue.use(VueRouter);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('header-bar', require('./components/Header.vue').default);

let routes = [
    // Dashboard
    {
        path: '/dashboard',
        component: require('./components/Dashboard.vue').default,
    },
    // Products
    { path: '/products', component: require('./components/Products.vue').default },
    // user management
    { path: '/usermanagement', component: require('./components/Usermanagement.vue').default },
    // sales
    { path: '/sales', component: require('./components/Sales.vue').default },
    // sales
    { path: '/salescollection', component: require('./components/Salescollection.vue').default },
    // direct sales
    { path: '/directsales', component: require('./components/DirectSales.vue').default },
    // store
    { path: '/branch', component: require('./components/Branch.vue').default },
    // add category
    { path: '/category', component: require('./components/Category.vue').default },
    // add resellers
    { path: '/renters', component: require('./components/Resellers.vue').default },
    // add rent management
    { path: '/rentmanagement', component: require('./components/Rentmanagement.vue').default },
    // add all rent management
    { path: '/all', component: require('./components/Allrentmanagement.vue').default },
    // report
    { path: '/report', component: require('./components/Report.vue').default },
    // boxex
    { path: '/cubes', component: require('./components/Boxes.vue').default },
    // assign
    { path: '/assign', component: require('./components/Boxmanagement.vue').default },
    // duedate
    { path: '/duedate', component: require('./components/Duedate.vue').default },
    // collected
    { path: '/collected', component: require('./components/Collected.vue').default },
    // collected
    { path: '/inventory', component: require('./components/Inventory.vue').default },
    // transaction
    { path: '/transactions', component: require('./components/Transactions.vue').default },
    { path: '/producttransmittal', component: require('./components/ProductTransmittal.vue').default },
    // return
    { path: '/return', component: require('./components/ReturnProduct.vue').default },
    // return
    { path: '/renterdashboard', component: require('./components/RenterDashboard.vue').default },
    // returnsales
    { path: '/returnsales', component: require('./components/ReturnSales.vue').default },
    // salehistory
    { path: '/salehistory', component: require('./components/SaleHistory.vue').default },
    // salehistorydirect
    { path: '/salehistorydirect', component: require('./components/SalesHistoryDirect.vue').default },

    { path: '/voidhistory', component: require('./components/VoidSales.vue').default },

    { path: '/systemlogs', component: require('./components/SystemLog.vue').default },


    // RENTERS PAGES
    // my profile
    { path: '/profile', component: require('./components/RentersPage/Profile.vue').default },
    // my products
    { path: '/myproducts', component: require('./components/RentersPage/MyProducts.vue').default },
    // my inventory
    { path: '/myinventory', component: require('./components/RentersPage/Inventory.vue').default },
    // my product returns
    { path: '/myproductreturn', component: require('./components/RentersPage/ProductReturns.vue').default },
    // my sales hsitory
    { path: '/mysaleshistory', component: require('./components/RentersPage/Saleshistory.vue').default },
    // my boxes
    { path: '/myboxes', component: require('./components/RentersPage/Boxes.vue').default },
    // my rent manager
    { path: '/myrentmanager', component: require('./components/RentersPage/RentManager.vue').default },
    // settings
    { path: '/settings', component: require('./components/Settings.vue').default },
    // voucher
    { path: '/voucher', component: require('./components/Voucher.vue').default },

    // REPORTS
    { path: '/renterslist', component: require('./components/Reports/Renterslist.vue').default },
    { path: '/productlist', component: require('./components/Reports/Productlist.vue').default },
    { path: '/inventorylist', component: require('./components/Reports/Inventorylist.vue').default },
    { path: '/saleshistory', component: require('./components/Reports/Saleshistory.vue').default },
    { path: '/cubesummary', component: require('./components/Reports/Cubesummary.vue').default },
    { path: '/inventoryhistory', component: require('./components/Reports/Inventoryhistory.vue').default },
    { path: '/directsalesreport', component: require('./components/Reports/Directsales.vue').default },
    { path: '/salescollectionreport', component: require('./components/Reports/Salescollections.vue').default },
    { path: '/voidsalessummary', component: require('./components/Reports/VoidSaleSummary.vue').default },
    { path: '/returnreports', component: require('./components/Reports/ReturnsReport.vue').default },
    // { path: '*', component: require('./components/Dashboard.vue').default },

];

var isProduction = true;
if (isProduction){
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true; 
}

const router = new VueRouter({
        base: '/',
        mode: 'history',
        routes //short for `routes: routes`
    })
    /**
     * Next, we will create a fresh Vue application instance and attach it to
     * the page. Then, you may begin adding components to this application
     * or customize the JavaScript scaffolding to fit your unique needs.
     */
    // PROGRESS BAR
Vue.use(VueProgressBar, {
    color: 'red',
    failedColor: 'red',
    height: '40px'
});

const app = new Vue({
    el: '#app',
    router
});