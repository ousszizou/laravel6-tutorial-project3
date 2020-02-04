import axios from "axios";
import Cookies from "js-cookie";
import * as types from "../mutations_types";

// state
const state = {
    user: null,
    token: Cookies.get("token")
}

// getters
const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
}

// mutations
const mutations = {
    [types.SAVE_TOKEN](state, { token, rembmer }) {
        state.token = token;
        Cookies.set("token", token, { expires: rembmer ? 365 : null });
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
    saveToken({commit}, payload) {
        commit(types.SAVE_TOKEN, payload);
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
