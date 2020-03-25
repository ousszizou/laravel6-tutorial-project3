import Login from "../pages/auth/Login.vue";
import Register from "../pages/auth/Register.vue";
import Home from "../pages/Home.vue";
import Welcome from "../pages/Welcome.vue";
import SignleDiscussion from "../pages/SingleDiscussion.vue";
import Index from "../pages/Index.vue";

import VueRouter from "vue-router";
import Vue from "vue";
import store from "../store/index";

import guest from "../middlewares/guest";
import auth from "../middlewares/auth";
import checkAuth from "../middlewares/auth-check";
import middlewarePipeline from "../routes/middlewarePipeline";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: Welcome,
            name: "welcome"
        },
        {
            path: "/login",
            component: Login,
            name: "login",
            meta: {
                middleware: [guest]
            }
        },
        {
            path: "/register",
            component: Register,
            name: "register",
            meta: {
                middleware: [guest]
            }
        },
        {
            path: "/home",
            component: Home,
            meta: {
                middleware: [auth, checkAuth]
            },
            children: [
              {
                path: "",
                component: Index,
                name: "home",
              },
              {
                path: "discussion/:channel/:discussion",
                component: SignleDiscussion,
                name: "discussion"
              }
            ]
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) return next();
    const middleware = to.meta.middleware;
    const context = {
        to,
        from,
        next,
        store
    };
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    });
});

export default router;
