export default function guest({ next, store }) {
    console.log("guest middleware run");
    if (store.getters["auth/token"]) {
        return next({ name: "home" });
    } else {
        return next();
    }
}
