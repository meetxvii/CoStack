<template>
    <div class="bg-extra-dark-blue min-h-screen flex justify-center">
        <div class="self-center bg-white w-[90vw] md:w-[60vw] text-grey rounded-2xl flex">
            <div class="md:w-[50%] bg-[url('../img/login.svg')] bg-no-repeat bg-contain bg-center md:mx-4 hidden md:block ">

            </div>
            <div class="w-[100%] md:w-[50%] pt-12 pb-12 px-8 md:px-14">
                <h1 class="white heading-1 text-light-blue text-center mb-10">Login</h1>
                <form>
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
                    <div v-show="invalidCredentials" class=" my-4 text-red-500 text-sm font-sans body">
                        <span class="font-semibold">Oh snap! </span>Invalid Email or Password
                    </div>
                    <div class="mt-4">
                        <button @click.prevent="login" class="w-full bg-light-blue hover:bg-light-blue-hover cursor-pointer py-2 rounded-full uppercase text-white body text-sm">Login </button>
                    </div>
                    <transition name="slide-up">

                        <div class="my-4 text-green-500 text-center" v-if="loginSuccess">
                            <span>Logged in successfully 
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            </span>
                        </div>
                    </transition>
                    
                    <div class="flex mt-5 justify-center cursor-pointer" >
                        <div class=" cursor-default">Forgot Password?</div>
                        <div class="inline-block ml-2 hover:underline">
                            <router-link :to="{name:'reset-password'}">Reset Now</router-link>
                        </div>
                    </div>
                    <div>
                        <div class="mt-5 cursor-pointer" >
                            <p class="mt-4 text-sm text-center">Don't have account? <router-link :to="{name:'register'}" class="text-light-blue hover:text-light-blue-hover">Register</router-link></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { ref, reactive, toRefs, watch } from 'vue'
    import { useUser } from '../stores/User'
    import router from '../router'
    export default {
        setup () {
            const togglePassword = ref('hide');
            const invalidCredentials = ref(false);
            const loginSuccess = ref(false);
            
            const user = useUser();
            const form = reactive({
                Email: '',
                Password: ''
            })
            
            const validation = reactive({
                isEmailValid: true,
                isPasswordValid: true,
                EmailMessage: '',
                PasswordMessage: ''
            });

            const validateEmail = () =>{
                //check if email is empty
                if (form.Email === '') {
                    validation.isEmailValid = false;
                    validation.EmailMessage = 'Email is required';
                    return 
                }

                //validate email using regex query
                const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!emailRegex.test(form.Email)) {
                    validation.isEmailValid = false;
                    validation.EmailMessage = 'Invalid email';
                    return 
                }

                validation.isEmailValid = true;
                validation.EmailMessage = '';
            }
            
            watch(() => form.Email, (value) => {
                validateEmail();
            })    
            

            const login = async() =>{
                validateEmail();

                if (form.Password === ''){
                    validation.isPasswordValid = false;
                    validation.PasswordMessage = 'Password is required';
                }

                if(!validation.isEmailValid || !validation.isPasswordValid){
                    return
                }
                
                const response = await axios.post('/api/login', {
                    email: form.Email,
                    password: form.Password
                })
                .then(response => {
                    
                    if(response.data.message === 'success'){
                        
                        user.user = response.data.user;
                        user.isLoggedIn = true;
                        loginSuccess.value = true;
                        setTimeout(() => {
                            router.push({ name: 'dashboard' })
                        }, 2000);
                    }
                }).catch(error => {
                    if(error.response.status === 401 && error.response.data.message === "Invalid credentials"){
                        invalidCredentials.value = true;
                    }
                })
            }
            return {
                ...toRefs(form),
                ...toRefs(validation),
                togglePassword,
                invalidCredentials,
                loginSuccess,
                login
                
            }
        }
    }
</script>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.25s ease-out;
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.slide-up-leave-to {
  transition: 0s; 
  opacity: 0;
  transform: translateY(-10px);
}
</style>