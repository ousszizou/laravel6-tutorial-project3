import axios from "axios";
import Cookies from "js-cookie";
import * as types from "../mutations_types";

// state
const state = {
    user: null,
    token: Cookies.get("token"),
    auth_err: null,
    loading: false
}

// getters
const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null,
    authError: state => state.auth_err,
    isLoading: state => state.loading
}

// mutations
const mutations = {
    [types.LOGIN](state) {
        state.loading = true;
        state.auth_err = null;
    },
    [types.LOGIN_SUCCESS](state, { token, rembmer }) {
        state.loading = false;
        state.auth_err = null;
        state.token = token;
        Cookies.set("token", token, { expires: rembmer ? 365 : null });
    },
    [types.LOGIN_FAILED](state, { error }) {
        state.loading = false;
        state.auth_err = error
    },
    [types.FETCH_USER_SUCCESS](state, { user }) {
        state.user = user.data;
    },
    [types.FETCH_USER_FAILURE](state) {
        state.token = null;
        Cookies.remove("token")
    },
    [types.LOGOUT](state) {
        state.user = null;
        state.token = null;
        Cookies.remove("token");
    }
};

// actions
const actions = {
    login({commit}) {
        commit(types.LOGIN);
    },
    async fetchUser({commit}) {
        try {
            const { data } = await axios.get('/api/v1/auth/user')
            commit(types.FETCH_USER_SUCCESS, {user: data} )
        } catch (error) {
            commit(types.FETCH_USER_FAILURE)
        }
    }
}

export default  {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
