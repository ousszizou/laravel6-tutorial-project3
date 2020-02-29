export default function auth({next, store}) {
    console.log("auth middlware run ...")
    if (!store.getters["auth/check"]) return next({ name: "login"})
    else return next();
}
