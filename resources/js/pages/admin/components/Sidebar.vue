<template>
    <div class="fixed bg-white text-blue w-[70%] md:w-16 bottom-0 left-[50%] md:left-0 translate-x-[-50%] md:translate-x-0 md:top-0 md:rounded-t-none md:rounded-r-xl px-2 py-2 pt-4 rounded-t-2xl flex flex-col items-center z-40">
        <div class="flex flex-row justify-around md:flex-col items-center w-full ">
            <div>
                <router-link :to="{name:'admin'}" class="group flex hover:bg-blue hover:text-white w-10 h-10 justify-center items-center text-lg rounded-lg transition duration-500 hover:-translate-y-1.5 md:hover:translate-y-0 md:hover:translate-x-1.5 hover:shadow-lg hover:shadow-blue md:my-4">
                    <div class="">
                        <i class="fa-solid fa-gauge"></i>
                    </div>
                </router-link>
            </div>
            <div>
                <router-link :to="{name:'admin-users'}" class="group flex hover:bg-blue hover:text-white w-10 h-10 justify-center items-center text-lg rounded-lg transition duration-500 hover:-translate-y-1.5 md:hover:translate-y-0 md:hover:translate-x-1.5 hover:shadow-lg hover:shadow-blue md:my-4">
                    <div>
                        <div>
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                </router-link>
            </div>    
            <div>
                <router-link :to="{name:'admin-technologies'}" class="group flex hover:bg-blue hover:text-white w-10 h-10 justify-center items-center text-lg rounded-lg transition duration-500 hover:-translate-y-1.5 md:hover:translate-y-0 md:hover:translate-x-1.5 hover:shadow-lg hover:shadow-blue md:my-4">
                    <div>
                        <div>
                            <i class="fa-solid fa-code"></i>
                        </div>
                    </div>
                </router-link>
            </div>           
            <div>
                <router-link :to="{name:'admin-reports'}" class="group flex hover:bg-blue hover:text-white w-10 h-10 justify-center items-center text-lg rounded-lg transition duration-500 hover:-translate-y-1.5 md:hover:translate-y-0 md:hover:translate-x-1.5 hover:shadow-lg hover:shadow-blue md:my-4">
                    <div>
                        <div>
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>
                </router-link>
            </div>    
            
            
        </div>
        <div class="md:mt-auto hidden md:block ">
            <div class="w-10 h-10 flex justify-center items-center text-lg cursor-pointer" @click="logout">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
        </div>
    </div>
</template>

<script>
import router  from '../../../router.js'

export default {
    
    setup () {
    
        const logout = () => {
            axios.post('/api/admin/logout')
            .then((res)=>{
                router.push({name:'admin-login'})
            })
            .catch((err)=>{
                console.log(err)
            })
        }
        return {
            logout
        }
    }
}
</script>

<style scoped>
.router-link-active{
    background-color: rgb(50 138 241);
    color: white;
    transform: translateY(-0.375rem);
    box-shadow: 0 10px 15px -3px rgb(50 138 241), 0 4px 6px -4px rgb(50 138 241);
}
@media (min-width: 768px){
    .router-link-active{
        transform: translateX(0.375rem) translateY(0);
    }
}

</style>