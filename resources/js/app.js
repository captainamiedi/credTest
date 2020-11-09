import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import './bootstrap'
// import auth from './auth'
import router from './router'
import Index from './Index'


// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = 'http://localhost:8000'
const token = JSON.parse(localStorage.getItem("user-token"));
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
// axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}

// Vue.use(VueAuth, auth)

// Load Index
Vue.component('index', Index)

const app = new Vue({
    el: '#app',
    router
});