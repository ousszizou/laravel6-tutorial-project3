import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import routes from './routes/index'
import store from './store/index'

Vue.use(VueRouter)
Vue.use(Vuex)


const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    store: new Vuex.Store(store)
});
