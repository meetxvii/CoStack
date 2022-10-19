<template>
    <div class="bg-dark-blue min-h-screen grid items-center">
        <div class="flex justify-center items-center">
            <div class="bg-white w-[90%] md:w-[70%] flex justify-around px-10 py-10 rounded-xl">
                <div class="hidden md:block md:w-[50%]">

                </div>
                <div class="w-[100%] md:w-[50%]">
                    <div class="text-center">
                        <h1 class="heading-1 font-rounded text-blue">Admin Login</h1>
                    </div>
                    <div class="my-4">
                        <div>
                            <div class="relative z-0">
                                <input type="email" v-model="email" id="email" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
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
                                >Email or Username</label>
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

                    <!-- password -->
                    <div class="my-4">
                        <div>
                            <div class="relative z-0">
                                <input :type="togglePassword ==='show'? 'text' : 'password'" v-model="password" id="password" autocomplete="off" aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
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

                    <!-- submit button -->
                    <div v-show="invalidCredentials" class=" my-4 text-red-500 text-sm font-sans body">
                        <span class="font-semibold">Oh snap! </span>Invalid credentials
                    </div>
                    <div class="mt-4">
                        <button @click.prevent="login" class="w-full bg-light-blue hover:bg-light-blue-hover cursor-pointer py-2 rounded-full uppercase text-white body text-sm font-bold ">Login </button>
                    </div>
                    <transition name="slide-up">

                        <div class="my-4 text-green-500 text-center" v-if="loginSuccess">
                            <span>Logged in successfully 
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            </span>
                        </div>
                    </transition>

                </div>
                
            </div>
        </div>        
    </div>
</template>

<script>
    import {ref,reactive, toRefs} from 'vue'

    import router from "../../router"

    import {useAdmin} from "../../stores/Admin";
    export default {
        setup () {

           

            const adminInfo = useAdmin();

            const togglePassword = ref('hide');

            const form = reactive({
                email: '',
                password: '',
            })
            const formValidation = reactive({
                isEmailValid: true,
                isPasswordValid: true,
                EmailMessage: '',
                PasswordMessage: '',
            })
            const invalidCredentials = ref(false);
            const loginSuccess = ref(false);

            const validateForm = () => {
                if(form.email === ''){
                    formValidation.isEmailValid = false;
                    formValidation.EmailMessage = 'Email is required';
                }else{
                    formValidation.isEmailValid = true;
                    formValidation.EmailMessage = '';
                }
                if(form.password === ''){
                    formValidation.isPasswordValid = false;
                    formValidation.PasswordMessage = 'Password is required';
                }else{
                    formValidation.isPasswordValid = true;
                    formValidation.PasswordMessage = '';
                }
            }

            const login = async() =>{
                validateForm();
                
                if(!formValidation.isEmailValid || !formValidation.isPasswordValid){
                    return;    
                }
                let isEmail = form.email.includes('@');
                let data;
                if(isEmail){
                    data = {
                        email: form.email,
                        password: form.password
                    }
                }
                else{
                    data = {
                        username: form.email,
                        password: form.password
                    }
                }
                const res = await axios.post('/api/admin/login', data)
                .then(res => {
                    if(res.data.message === 'success'){
                        adminInfo.isLoggedIn = true;
                        adminInfo.info = res.data.user;
                        loginSuccess.value = true;
                        setTimeout(() => {
                            router.push({name: 'admin'})
                        }, 1000);
                    }
                    else{
                        invalidCredentials.value = true;
                    }
                })
                .catch(err => {
                    console.log(err);
                    if(err.response.status === 401){
                        invalidCredentials.value = true;
                        return;
                    }
                    console.log(err.response.data.message);
                })
            }
            return {
                adminInfo,
                ...toRefs(form),
                ...toRefs(formValidation),
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