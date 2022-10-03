<template>
    <div class="bg-extra-dark-blue min-h-screen flex justify-center ">
        
        <div class="self-center bg-white w-[90vw] md:w-[60vw]  text-grey rounded-2xl flex">
            <div class="md:w-[50%] bg-[url('../img/register.svg')] bg-no-repeat bg-contain bg-center md:mx-4  ">
                
            </div>
            <div class=" w-[100%] md:w-[50%] pt-12 pb-12 px-8 md:px-14">
                <h1 class="white heading-1 text-light-blue text-center mb-10">Register</h1>
                <form>
                    <div class="my-4">
                        <div>
                            <div class="relative z-0">
                                <input type="text" v-model.lazy="username" id="username" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                :class="{
                                    'border-red-600': !isUsernameValid,
                                    'dark:border-red-500': !isUsernameValid,
                                    'dark:focus:border-red-500': !isUsernameValid,
                                    'focus:border-red-600': !isUsernameValid,
                                    'border-gray-600': isUsernameValid,
                                    'dark:border-gray-500': isUsernameValid,
                                    'dark:focus:border-gray-500': isUsernameValid,
                                    'focus:border-gray-600': isUsernameValid,
                                }"
                                
                                />
                                <label for="username" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                :class="{
                                    'text-red-600': !isUsernameValid,
                                    'dark:text-red-500': !isUsernameValid,
                                    'text-gray-600' : isUsernameValid,
                                    'dark:text-gray-500' : isUsernameValid,
                                }"
                                >Username</label>
                            </div>
                            <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                'text-red-600' : !isUsernameValid,
                                'dark:text-red-400' : !isUsernameValid,
                                'text-gray-600': isUsernameValid,
                                'dark:text-gray-400': isUsernameValid
                            }"
                            v-show="!isUsernameValid"
                            >{{UsernameMessage}}</p>
                        </div>
                    </div>
                    <div class="my-4">
                        <div>
                            <div class="relative z-0">
                                <input type="email" v-model.lazy="email" id="email" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
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
                                <input :type="togglePassword ==='show'? 'text' : 'password'" v-model.lazy="password" id="password" autocomplete="off" aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
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
                    <div class="my-4">
                        <div>
                            <div class="relative z-0">
                                <input :type="toggleConfirmPassword ==='show'? 'text' : 'password'" v-model.lazy="passwordConfirm" id="confirmpassword" autocomplete="off" aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                :class="{
                                    'border-red-600': !isConfirmPasswordValid,
                                    'dark:border-red-500': !isConfirmPasswordValid,
                                    'dark:focus:border-red-500': !isConfirmPasswordValid,
                                    'focus:border-red-600': !isConfirmPasswordValid,
                                    'border-gray-600': isConfirmPasswordValid,
                                    'dark:border-gray-500': isConfirmPasswordValid,
                                    'dark:focus:border-gray-500': isConfirmPasswordValid,
                                    'focus:border-gray-600': isConfirmPasswordValid,
                                }"
                                
                                />
                                <label for="confirmpassword" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                :class="{
                                    'text-red-600': !isConfirmPasswordValid,
                                    'dark:text-red-500': !isConfirmPasswordValid,
                                    'text-gray-600' : isConfirmPasswordValid,
                                    'dark:text-gray-500' : isConfirmPasswordValid,
                                }"
                                >Confirm Password</label>
                                <div>
                                    <transition name="slide-up">
                                        <div class="absolute right-0 top-3 text-gray-600 dark:text-gray-400 cursor-pointer"
                                        v-if="toggleConfirmPassword==='hide'" @click="toggleConfirmPassword = 'show'">
                                            <i class="fa-solid fa-eye" ></i>
                                        </div>
                                        <div class="absolute right-0 top-3 text-gray-600 dark:text-gray-400 cursor-pointer"
                                        v-else-if="toggleConfirmPassword==='show'" @click="toggleConfirmPassword = 'hide'" >
                                            <i class="fa-solid fa-eye-slash " ></i>
                                        </div>
            
                                    </transition>
                                </div>
                            </div>
                            <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                'text-red-600' : !isConfirmPasswordValid,
                                'dark:text-red-400' : !isConfirmPasswordValid,
                                'text-gray-600': isConfirmPasswordValid,
                                'dark:text-gray-400': isConfirmPasswordValid
                            }"
                            v-show="!isConfirmPasswordValid"
                            >{{PasswordConfirmMessage}}</p>
                        </div>
                    </div>

                    <div v-show="registerError !== ''" class="my-2 text-xs text-red-600 font-semibold">
                        <p>{{registerError}}</p>
                    </div>

                    <div class="mt-4">
                        <button @click.prevent="register" class="w-full bg-light-blue hover:bg-light-blue-hover cursor-pointer py-2 rounded-full uppercase text-white body text-sm">Register </button>
                    </div>
                    <transition name="slide-up">

                        <div class="my-4 text-green-500 text-center" v-if="registrationSuccess">
                            <span>
                                Registered successfully 
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            </span>
                        </div>
                        
                    </transition>
                    <div>
                        <p class="mt-4 text-sm text-">Already have an account? <router-link :to="{name:'login'}" class="text-light-blue hover:text-light-blue-hover">Login</router-link></p>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</template>

<script>
    import { reactive, toRefs, ref, watch } from 'vue'
    import axios from 'axios';
    import router from '../router'
    export default {
        name: 'Register',
        components: {
            
        },
        setup () {

            const togglePassword = ref('hide');
            const toggleConfirmPassword = ref('hide');
            const registerError = ref('');
            const registrationSuccess = ref(false);
            const form = reactive({
                username:'',
                email: '',
                password: '',
                passwordConfirm: '',
            })       


            const validation = reactive({
                isEmailValid: true,
                EmailMessage: '',
                isUsernameValid: true,
                UsernameMessage: '',
                isPasswordValid: true,
                PasswordMessage: '',
                isConfirmPasswordValid: true,
                PasswordConfirmMessage: '',
            })
            watch(() => form, (value)=>{
                registerError.value = '';
            }, {deep: true})

            watch(()=>form.username, async (value) => {
                if(value.length < 3){
                    validation.isUsernameValid = false;
                    validation.UsernameMessage = 'Username must be at least 3 characters';
                    return
                }
                
                const regex = /^[a-zA-Z0-9_]*$/;
                if(!regex.test(value)){
                    validation.isUsernameValid = false;
                    validation.UsernameMessage = 'Username must be only characters and numbers and underscore';
                    return
                }
                const res = await axios.post('/api/check-username', {username: value})
                .then(res => {
                    if(res.data.message === 'Username is available'){
                        validation.isUsernameValid = true;
                        validation.UsernameMessage = '';
                    }
                })
                .catch(err => {
                    if(err.response.data.message === 'Username already exists'){
                        validation.isUsernameValid = false;
                        validation.UsernameMessage = err.response.data.message;
                    }
                })

            })

            watch(()=>form.email, async(value) => {
                const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!emailRegex.test(value)){
                    validation.isEmailValid = false;
                    validation.EmailMessage = 'Email is invalid';
                    return
                }
                const res = await axios.post('/api/check-email', {email: value})
                .then((res) => {
                    if(res.data.message === 'Email is available'){
                        validation.isEmailValid = true;
                        validation.EmailMessage = '';
                    }
                }).catch((err) => {
                    
                    if(err.response.data.message === "Email already exists"){
                        validation.isEmailValid = false;
                        validation.EmailMessage = err.response.data.message;
                    }
                })
            });

            watch(()=>form.password, (value) => {

                //validate password with regex with 6-16 characters, at least one uppercase letter, one lowercase letter, one number and one special character
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$/;
                if(!regex.test(value)){
                    validation.isPasswordValid = false;
                    validation.PasswordMessage = 'Password must be 6-16 characters, at least one uppercase letter, one lowercase letter, one number and one special character';
                    return
                }
                
                validation.isPasswordValid = true;
                validation.PasswordMessage = '';
            })
            watch(()=>form.passwordConfirm, (value) => {
                if(value !== form.password){
                    validation.isConfirmPasswordValid = false;
                    validation.PasswordConfirmMessage = 'Password does not match';
                    return
                }
                validation.isConfirmPasswordValid = true;
                validation.PasswordConfirmMessage = '';
            })

            const validateForm = () => {
                if(form.username === ''){
                    validation.isUsernameValid = false;
                    validation.UsernameMessage = 'Username is required';
                }
                
                if(form.email === ''){
                    validation.isEmailValid = false;
                    validation.EmailMessage = 'Email is required';
                }
            
            
                const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!emailRegex.test(form.email)){
                    validation.isEmailValid = false;
                    validation.EmailMessage = 'Email is invalid';
                }
            
                if(form.password === ''){
                    validation.isPasswordValid = false;
                    validation.PasswordMessage = 'Password is required';
                }
                if(form.passwordConfirm !== form.password){
                    validation.isConfirmPasswordValid = false;
                    validation.PasswordConfirmMessage = "Confirm Password doesn't match";
                }

            }
            

            const register = async() => {
                validateForm();
                if(!validation.isEmailValid || !validation.isUsernameValid || !validation.isPasswordValid || !validation.isConfirmPasswordValid){
                    return
                }
                
                const res = await axios.post('/api/register', {
                    username: form.username,
                    email: form.email,
                    password: form.password,    
                }).
                then((res) => {
                    console.log(res);
                    if(res.statusText === "Created"){
                        registrationSuccess.value = true;
                        setTimeout(() => {
                            router.push({ name: 'login' })
                        }, 2000);
                    }
                }).catch((err) => {
                    console.log(err.response);
                    registerError.value = "Something went wrong, please try again later";
                })
                
                
            }
        
            return {
                ...toRefs(form),
                ...toRefs(validation),
                togglePassword,
                toggleConfirmPassword,
                registerError,
                registrationSuccess,
                register
                
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