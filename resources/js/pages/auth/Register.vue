<template>
    <div class="container border rounded-lg w-3/4 mt-12 border-gray-300 p-6 mx-auto flex content-center font-sans shadow-2xl">
        <div class="w-2/5 self-center">
            <img class="w-full mx-auto" :src="imgForm" alt="image_for_login">
        </div>
        <div class="text-center w-3/5 self-center">
            <h1 class="text-5xl font-bold text-mainColor">Algorum</h1>
            <div class="mt-2">
                <h3 class="text-3xl text-gray-700">welcome !</h3>
                <p class="pb-8 text-gray-600">Sign up by entering your information.</p>
                <div v-if="authError" class="text-white mb-4 bg-red-400 p-4 w-1/2 mx-auto">
                    <p> {{authError}} </p>
                </div>
                <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                    <input class="w-1/2 mx-auto border-b p-4 border-gray-400 outline-none block" type="text" placeholder="Name" name="name" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-errortailwind :form="form" field="name"></has-errortailwind>
                    <input class="w-1/2 mx-auto border-b p-4 border-gray-400 outline-none block" type="email" placeholder="Email" name="email" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-errortailwind :form="form" field="email"></has-errortailwind>
                    <input class="w-1/2 mx-auto border-b border-gray-400 p-4 border-gray-400 outline-none block" type="password" placeholder="Password" name="password" v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-errortailwind :form="form" field="password"></has-errortailwind>
                    <input class="w-1/2 mx-auto border-b border-gray-400 p-4 border-gray-400 outline-none block" type="password" placeholder="confirm password" name="password_confirmation" v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                    <has-errortailwind :form="form" field="password_confirmation"></has-errortailwind>
                    <button class="mt-8 border-none rounded-full bg-mainColor px-16 py-2 text-white" type="submit">
                        <clip-loader :loading="isLoading" color="#fff" size="30px"></clip-loader>
                        <span v-if="!isLoading">register</span>
                        <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                </form>
                <p class="pt-4 text-gray-600">Already have an account? <a class="text-mainColor font-bold underline" href="/login">Login</a></p>

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
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }),
            imgForm: "/images/register.svg"
        }
    },
    methods: {
        register() {
            this.form.post("/api/v1/auth/register").then(({data}) => {
                console.log(data)
                this.$router.push({name: 'login'})
            }).catch((err) => {
                console.log(err.response.data)
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
