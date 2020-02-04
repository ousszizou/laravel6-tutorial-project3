import Login from '../pages/auth/Login.vue'
import Home from "../pages/Home.vue";

export default {
    mode: "history",
    routes: [
        {
            path: "/login",
            component: Login,
            name: "login"
        },
        {
            path: "/home",
            component: Home,
            name: "home"
        }
    ]
};
