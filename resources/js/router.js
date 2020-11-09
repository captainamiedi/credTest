import VueRouter from 'vue-router'

//Pages
import Home from './components/Home'
import Login from './components/Login'
import Register from './components/Register'
import Dashboard from './components/Dashboard';
import Referrer from './components/Referrer';


const guardMyroute = (to, from, next) => {
    let isAuthenticated = false;
    if (localStorage.getItem('user-token') !== null)
        isAuthenticated = true;
    else
        isAuthenticated = false;
    if (isAuthenticated) {
        next(); // allow to enter route
    } else {
        next('/login'); // go to '/login';
    }
}

const routes= [
    {
        path: '/',
        component: Home,
        name: 'home',
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/referer',
        name: 'refer',
        component: Referrer,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // User Routes
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        beforeEnter : guardMyroute,
        meta: {
            requireAuth: true
        }
    }
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router