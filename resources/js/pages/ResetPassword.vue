<template>
    <div class="w-screen bg-extra-dark-blue">
        <TopHeader />
        <div class="pt-16 md:pt-20 min-h-screen w-full flex justify-center items-center">
            <div class="w-[50%] py-10 px-8 rounded-lg bg-white">
                <div class="text-blue">
                    <h1 class="heading-1 text-blue">
                        Reset Password
                    </h1>
                    <div class="body text-grey ">
                        <p class="font-semibold">Enter your email address and we'll send you a link to reset your password</p>
                    </div>
                    <div>
                        <div class="my-4">
                            <div>
                                <div class="relative z-0">
                                    <input type="email" v-model="Email" id="email" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                    :class="{
                                        'border-red-600': !isEmailValid,
                                        'dark:border-red-500': !isEmailValid,
                                        'dark:focus:border-red-500': !isEmailValid,
                                        'focus:border-red-600': !isEmailValid,
                                        'border-gray-600': isEmailValid,
                                        'dark:border-gray-500': isEmailValid,
                                        'dark:focus:border-gray-500': isEmailValid,
                                        'focus:border-gray-600': isEmailValid,
                                    }"
                                    
                                    />
                                    <label for="email" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    :class="{
                                        'text-red-600': !isEmailValid,
                                        'dark:text-red-500': !isEmailValid,
                                        'text-gray-600' : isEmailValid,
                                        'dark:text-gray-500' : isEmailValid,
                                    }"
                                    >Email Address</label>
                                </div>
                                <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                    'text-red-600' : !isEmailValid,
                                    'dark:text-red-400' : !isEmailValid,
                                    'text-gray-600': isEmailValid,
                                    'dark:text-gray-400': isEmailValid
                                }"
                                v-show="!isEmailValid"
                                >{{EmailMessage}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between gap-5">
                        <div class="w-full">
                            <router-link :to="{name:'login'}">
                                <button class="text-blue py-2 rounded w-full" >Back to login</button>
                            </router-link>
                        </div>
                        <button class="bg-blue text-white py-2 rounded w-full" @click="resetPassword">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopHeader from "../components/TopHeader.vue"
import { ref } from "vue"
import axios from 'axios'
export default {
    setup () {
        const Email = ref('')
        const isEmailValid = ref(true)
        const EmailMessage = ref('')

        const resetPassword = async() => {
            if (Email.value === '') {
                isEmailValid.value = false
                EmailMessage.value = 'Email is required'
                return
            } else {
                isEmailValid.value = true
                EmailMessage.value = ''
            }
            await axios.post('/api/reset-password', {
                email: Email.value
            }).then((response) => {
                console.log(response)
            }).catch((error) => {
                console.log(error)
            })
        }

        return {
            Email,
            isEmailValid,
            EmailMessage,
            resetPassword

        }
    },
    components:{
        TopHeader
    }
}
</script>

<style lang="scss" scoped>

</style>