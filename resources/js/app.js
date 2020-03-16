import Vue from "vue";
import router from "./routes/index";
import store from "./store/index";
import VModal from "vue-js-modal";

Vue.use(VModal);

const app = new Vue({
    el: "#app",
    router,
    store
});
