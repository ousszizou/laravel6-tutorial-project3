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
                <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                    <input class="w-1/2 mx-auto border-b p-4 border-gray-400 outline-none block" type="email" placeholder="Email" name="email" v-model="form.email">
                    <input class="w-1/2 mx-auto border-b border-gray-400 p-4 border-gray-400 outline-none block" type="password" placeholder="Password" name="password" v-model="form.password">
                    <button class="mt-8 border-none rounded-full bg-mainColor px-16 py-2 text-white" type="submit">Sign In <i class="fa fa-sign-in" aria-hidden="true"></i></button>
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
import {Form} from 'vform'

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
        async login() {
           const {data} = await this.form.post("/api/v1/auth/login")
           this.$store.dispatch('auth/saveToken', {
               token: data.access_token,
               remember: this.remember
           })
           await this.$store.dispatch('auth/fetchUser')
           this.$router.push({ name: 'home' })
        }
    }
}
</script>
