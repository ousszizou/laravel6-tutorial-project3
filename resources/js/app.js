import Vue from "vue";
import router from "./routes/index";
import store from "./store/index";

const app = new Vue({
    el: "#app",
    router,
    store
});
