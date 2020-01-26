import Home from '../components/Home.vue'
import Test from '../components/Test.vue'

export default {
    mode: "history",
    routes: [
        {
            path: '/',
            component: Home,
            name: 'home'
        },
        {
            path: '/test',
            component: Test,
            name: 'test'
        }
    ]
}
