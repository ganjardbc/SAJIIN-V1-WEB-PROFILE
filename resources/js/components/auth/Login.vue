<template>
    <div id="Login" class="main-screen" style="padding-top: 50px;">
        <div class="width width-400px width-mobile width-center">
            <div class="padding padding-left-15px padding-right-15px">
                <div class="card box-shadow border-radius">
                    <form action="#" @submit.prevent="submit" style="width: 100%;">
                        <div class="image image-all" style="
                            width: 180px;
                            padding-bottom: 30%;
                            margin: auto;
                            margin-bottom: 0;
                            background-color: rgba(0,0,0,0)
                        ">
                            <img :src="logo" alt="HNF" class="post-center" style="width: 100%;">
                        </div>
                        
                        <div class="padding padding-top-10px padding-bottom-5px">
                            <div class="fonts fonts-11 semibold black">Username</div>
                            <el-input 
                                :disabled="visibleButton" 
                                v-model="form.username" />
                        </div>

                        <div class="padding padding-top-10px padding-bottom-30px">
                            <div class="fonts fonts-11 semibold black">Password</div>
                            <el-input 
                                type="password" 
                                :disabled="visibleButton" 
                                v-model="form.password"
                                show-password />
                        </div>

                        <div 
                            v-if="visibleError" 
                            class="fonts fonts-10 normal red" 
                            style="text-align: center; margin-bottom: 15px;">
                            {{ textError }}
                        </div>

                        <div style="margin-bottom: 10px;">
                            <button 
                                class="btn btn-main" 
                                style="width: 100%;" 
                                type="submit" 
                                :disabled="visibleButton">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <AppAlert v-if="visiblePopup" :isLoader="true" />
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import logo from '../../../img/logo.png'
import AppWrapper from '../modules/AppWrapper'
import AppButton from '../modules/AppButton'
import AppForm from '../modules/AppForm'
import AppText from '../modules/AppText'
import AppAlert from '../modules/AppAlert'

export default {
    name: "Login",
    metaInfo: {
        title: 'Saji-in',
        titleTemplate: '%s | Login',
        htmlAttrs: {
            lang: 'en',
            amp: true
        }
    },

    components: {
        AppWrapper,
        AppButton,
        AppText,
        AppForm,
        AppAlert
    },

    mounted() {
        this.$gtag.event('login', { method: 'Google' })
    },

    data () {
        return {
            visiblePopup: false,
            visibleError: false,
            visibleButton: false,
            textError: 'error',
            logo: logo,
            form: {
                username: '',
                password: '',
                remember: false
            }
        }
    },

    methods: {
        ...mapActions({
            setCookieAuth: 'auth/setCookieAuth',
            signIn: 'auth/signIn',
        }),

        async submit () {
            this.visiblePopup = true
            this.visibleError = false
            this.visibleButton = true 
            const rest = await this.signIn(this.form)
            if (rest.data.status === 'ok') {
                const data = rest.data.data
                const token = 'Bearer '.concat(data.token)
                this.setCookieAuth(data)
                this.visiblePopup = false
                this.$router.replace({ name: 'dashboard' })
            } else {
                this.visiblePopup = false
                this.visibleButton = false
                this.visibleError = true
                this.textError = rest.data.message
            }
        }
    },
}

</script>
