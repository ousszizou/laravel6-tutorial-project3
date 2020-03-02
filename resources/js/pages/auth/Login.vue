<template>
    <div class="container border rounded-lg w-3/4 mt-12 border-gray-300 p-6 mx-auto flex content-center font-sans shadow-2xl">
        <div class="w-2/5">
            <img class="w-full mx-auto" :src="imgForm" alt="image_for_login">
        </div>
        <div class="text-center w-3/5 self-center">
            <h1 class="text-5xl font-bold text-mainColor">Algorum</h1>
            <div class="mt-2">
                <h3 class="text-3xl text-gray-700">welcome !</h3>
                <p class="pb-8 text-gray-600">Sign in by entering your information.</p>
                <div v-if="authError" class="text-white mb-4 bg-red-400 p-4 w-1/2 mx-auto">
                    <p> {{authError}} </p>
                </div>
                <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                    <input class="w-1/2 mx-auto border-b p-4 border-gray-400 outline-none block" type="email" placeholder="Email" name="email" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-errortailwind :form="form" field="email"></has-errortailwind>
                    <input class="w-1/2 mx-auto border-b border-gray-400 p-4 border-gray-400 outline-none block" type="password" placeholder="Password" name="password" v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-errortailwind :form="form" field="password"></has-errortailwind>
                    <button class="mt-8 border-none rounded-full bg-mainColor px-16 py-2 text-white" type="submit">
                        <clip-loader :loading="isLoading" color="#fff" size="30px"></clip-loader>
                        <span v-if="!isLoading">sign in</span>
                        <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                </form>
                <div>
                    <a href="/login/github" class="mt-8 border-none rounded-full bg-gray-700 px-6 py-2 text-white" type="submit">With Github <i class="fa fa-github" aria-hidden="true"></i></a>
                    <a href="/login/facebook" class="mt-8 border-none rounded-full bg-blue-700 px-6 py-2 text-white" type="submit">With Facebook <i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                </div>
                <p class="pt-4 text-gray-600">Not registred? <a class="text-mainColor font-bold underline" href="/register">Create an account</a></p>

            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import {Form} from 'vform'
import {mapGetters} from 'vuex'
import HasErrorTailwind from '../../components/HasErrorTailwind'
import { ClipLoader } from 'vue-spinner/dist/vue-spinner.min.js'

Vue.component(HasErrorTailwind.name, HasErrorTailwind)
Vue.component('clip-loader', ClipLoader)

export default {
    data() {
        return {
            form: new Form({
                email: '',
                password: '',
                remember: false
            }),
            imgForm: "/images/login.svg"
        }
    },
    methods: {
        login() {
            this.$store.dispatch("auth/login")
            this.form.post("/api/v1/auth/login").then(({data}) => {
                this.$store.commit("auth/LOGIN_SUCCESS", {
                    token: data.access_token,
                    remember: this.remember
                })
                this.$store.dispatch('auth/fetchUser')
                this.$router.push({name: 'home'})
            })
            .catch((error) => {
                this.$store.commit("auth/LOGIN_FAILED", error.response.data)
            })
        }
    },
    computed: {
        ...mapGetters({
            authError: 'auth/authError',
            isLoading: 'auth/isLoading'
        })
    }
}
</script>

<style scoped>

    .is-invalid {
        border-bottom: 1px solid #e64f5c
    }

</style>
