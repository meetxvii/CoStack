<template>
    <div class="w-screen bg-extra-dark-blue">
        <TopHeader />
        <div class="fixed top-0 left-0 w-screen min-h-[100vh] flex justify-center items-center z-50 backdrop-blur" v-if="success">
            <div class="bg-white px-10  rounded-lg">
                <div  class="flex min-h-[50vh] flex-col justify-center items-center text-blue gap-10 animate-pulse">
                    <i class="fa-solid fa-circle-check text-8xl"></i>
                    <h1 class="heading-3 text-blue">Password Changed successfully</h1>
                </div>
            </div>
        </div>
        <div class="pt-16 md:pt-20 min-h-screen w-full flex justify-center items-center">
            <div class="w-[50%] py-10 px-8 rounded-lg bg-white">
                <div class="text-blue">
                    <h1 class="heading-1 text-blue">
                        Set New Password
                    </h1>
                    <div class="body text-grey ">
                        <p class="font-semibold">
                            Enter your new password
                        </p>
                    </div>
                    <div>
                        <div class="my-4">
                            <div>
                                <div class="relative z-0">
                                    <input :type="togglePassword ==='show'? 'text' : 'password'" v-model="Password" id="password" autocomplete="off" aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                    :class="{
                                        'border-red-600': !isPasswordValid,
                                        'dark:border-red-500': !isPasswordValid,
                                        'dark:focus:border-red-500': !isPasswordValid,
                                        'focus:border-red-600': !isPasswordValid,
                                        'border-gray-600': isPasswordValid,
                                        'dark:border-gray-500': isPasswordValid,
                                        'dark:focus:border-gray-500': isPasswordValid,
                                        'focus:border-gray-600': isPasswordValid,
                                    }"
                                    
                                    />
                                    <label for="password" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    :class="{
                                        'text-red-600': !isPasswordValid,
                                        'dark:text-red-500': !isPasswordValid,
                                        'text-gray-600' : isPasswordValid,
                                        'dark:text-gray-500' : isPasswordValid,
                                    }"
                                    >Password</label>
                                    <div>
                                        <transition name="slide-up">
                                            <div class="absolute right-0 top-3 text-gray-600 dark:text-gray-400 cursor-pointer"
                                            v-if="togglePassword==='hide'" @click="togglePassword = 'show'">
                                                <i class="fa-solid fa-eye" ></i>
                                            </div>
                                            <div class="absolute right-0 top-3 text-gray-600 dark:text-gray-400 cursor-pointer"
                                            v-else-if="togglePassword==='show'" @click="togglePassword = 'hide'" >
                                                <i class="fa-solid fa-eye-slash " ></i>
                                            </div>
                
                                        </transition>
                                    </div>
                                </div>
                                <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                    'text-red-600' : !isPasswordValid,
                                    'dark:text-red-400' : !isPasswordValid,
                                    'text-gray-600': isPasswordValid,
                                    'dark:text-gray-400': isPasswordValid
                                }"
                                v-show="!isPasswordValid"
                                >{{PasswordMessage}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between gap-5">
                        
                        <button class="bg-blue text-white py-2 rounded w-full" @click="changePassword">Set Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from 'vue'
import { computed, onMounted, watch } from '@vue/runtime-core'
import {useRoute} from 'vue-router'
import TopHeader from '../components/TopHeader.vue'

import router from "../router"
export default {
    setup() {

        const Password = ref('')
        const PasswordMessage = ref('')
        const isPasswordValid = ref(true)
        const togglePassword = ref('hide')
        const success = ref(false)

        const token = computed(() => useRoute().params.token);
        // check if token is valid

        const user = ref();
        const checkToken = async () => {
            await axios.post("/api/check-token", {
                token: token.value
            }).then((response) => {
                
                user.value = response.data.token.user_id;
            }).catch((error) => {
                console.log(error);
            });
        };

        const changePassword = async () => {

                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$/;
                if(!regex.test(Password.value)){
                    PasswordMessage.value = 'Password must be 6-16 characters long, contain at least one uppercase letter, one lowercase letter, one number and one special character'
                    isPasswordValid.value = false
                    return
                }
                
                
                await axios.post("/api/change-password", {
                    password: Password.value,
                    user_id: user.value
                }).then((response) => {
                    console.log(response.data);
                    if(response.data.message === "success"){
                        success.value == true;
                        setTimeout(() => {
                            router.push('/login');
                        }, 3000);
                    }
                }).catch((error) => {
                    console.log(error);
                });
            
            
        };

        onMounted(() => {
            checkToken();
        });
        return {
            Password,
            PasswordMessage,
            isPasswordValid,
            togglePassword,
            success,
            changePassword
        };
    },
    components: { TopHeader }
}
</script>

<style scoped>

</style>