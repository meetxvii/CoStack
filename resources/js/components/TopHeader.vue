<template>
    <div>
        
        <div v-if="openSearchDialog">
            <Search @closeSearchDialog="toggleSearchDialog" />
        </div>
    
    </div>
    <div>
        <nav>
            <div class="bg-extra-dark-blue w-screen fixed px-5 py-2 md:px-8 md:py-4 flex items-center z-40" id="navbar">
                <div class="mr-auto">
                    <router-link :to="{name:'dashboard'}">
                        <h1 class="heading-2 text-blue font-rounded ">CoStack</h1>
                    </router-link>
                    
                </div>

                <div class="hidden md:block">
                    <div>
                        <ul class="flex gap-5 uppercase font-semibold menuList">
                            <li v-for="page in menuList" :key="page.name" class="group text-blue/60 hover:text-blue flex justify-center items-center">
                                <div class="max-w-fit relative overflow-hidden py-2">
                                    <router-link :to="{name:page.link}">
                                        {{page.name}}
                                    </router-link>
                                    <div class="bg-blue w-full h-1 rounded
                                    absolute right-40 opacity-0 group-hover:right-0 group-hover:opacity-100 transition-all duration-300">
                                    </div>
                                </div>
                            </li>
                            <li v-if="!user.isLoggedIn" class="group text-blue/60 hover:text-blue flex justify-center items-center">
                                <div class="max-w-fit relative overflow-hidden py-2">
                                    <router-link :to="{name:'login'}">
                                        Login
                                    </router-link>
                                    <div class="bg-blue w-full h-1 rounded
                                    absolute right-40 opacity-0 group-hover:right-0 group-hover:opacity-100 transition-all duration-300">
                                    </div>
                                </div>
                            </li>
                            <li v-if="!user.isLoggedIn" class="group text-blue/60 hover:text-blue flex justify-center items-center">
                                <div class="max-w-fit relative overflow-hidden py-2">
                                    <router-link :to="{name:'register'}">
                                        Register
                                    </router-link>
                                    <div class="bg-blue w-full h-1 rounded
                                    absolute right-40 opacity-0 group-hover:right-0 group-hover:opacity-100 transition-all duration-300">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="ml-auto mx-4 md:ml-4 relative w-10 h-10 rounded-2xl bg-blue/10 hover:border-[1px] hover:border-blue/20 hover:text-blue text-white cursor-pointer duration-300 transition-all" @click="toggleSearchDialog">                    
                    <div class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                <div class="block md:hidden mr-4">
                    <div class="text-white hover:text-blue hover:bg-white cursor-pointer relative w-10 h-10 rounded-2xl transition-all duration-300"
                     :class="{
                        'text-blue':openMobileMenu,
                        'text-white': !openMobileMenu,
                        'bg-white': openMobileMenu,
                        'bg-transparent': !openMobileMenu
                     }"
                    @click="openMobileMenu = !openMobileMenu">
                        <transition name="slide-up">
                            <div v-if="!openMobileMenu"  class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]">
                                <i class="fa-solid fa-bars-staggered  -scale-x-100"></i>
                            </div>
                            <div v-else-if="openMobileMenu" class="absolute top-[50%] text-blue left-[50%] translate-x-[-50%] translate-y-[-50%]">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        </transition>
                    </div>
                </div>
                <div class="mr-4" v-if="user.isLoggedIn">
                    <div>
                        <div class="cursor-pointer relative"> 
                            <img src="../../img/MaleUser.svg" 
                            :title="user.user.username" @click="showProfileMenu = !showProfileMenu" class="w-10 rounded-full border-2 border-blue p-1">
                            <div v-if="showProfileMenu" class="absolute right-0 top-12 border-2  rounded-xl bg-white px-5 py-2 w-[9rem]">
                                <ul>
                                    <li class="py-1 font-semibold text-grey hover:text-blue border-b-2">
                                        <router-link :to="{name:'user-question', params:{'id': user.user.id}}">My Questions</router-link>
                                    </li>
                                    <li class="py-1 font-semibold text-grey hover:text-red-600">
                                        <button @click="logout">Logout</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
            
            </div>
            
            <transition name="slide-fade">
                <div class="w-screen block md:hidden bg-panel-700 fixed top-14 z-20" v-if="openMobileMenu">
                    <div class="py-2 border-b-2 border-blue/40">
                        <ul class="mobileMenuList ">
                            <li v-for="page in menuList" :key="page.name" class="uppercase text-blue/30 hover:text-blue font-semibold flex justify-center items-center group border-b-2 border-blue/10">
                                <div class="max-w-fit relative overflow-hidden py-2 my-2">
                                    <router-link :to="{name:`${page.link}`}" >{{page.name}}
                                    </router-link>
                                    <div class="bg-blue w-full h-1 rounded
                                    absolute right-40 opacity-0 group-hover:right-0 group-hover:opacity-100 transition-all duration-300">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </transition>
        </nav>
    </div>
    
</template>

<script>
    import {onMounted, ref} from 'vue';
    import {CheckLogin} from '../composables/CheckLogin';
    import {useUser} from "../stores/User";
    import Search from "./Search.vue"
    import router from "../router"

    export default {
        name: 'TopHeader',

        setup(){
            const openSearchDialog = ref(false);
            const openMobileMenu = ref(false);
            const showProfileMenu = ref(false);
            const menuList = ref([
                {'name':'home', 'link':'dashboard'},
                {'name':'Technologies', 'link': 'technologies'},
                {'name':'Featured', 'link': 'Featured'},
            ]);
            const user =ref({});
            onMounted(async()=>{
                await CheckLogin();
                user.value = await useUser();

            });

            const toggleSearchDialog = () => {
                openSearchDialog.value = !openSearchDialog.value;
            }

            const logout = async () => {
                await axios.post('/api/logout').then((res)=>{
                    if(res.data.message === 'success'){
                        
                        router.go(0);
                    }
                })
            }

            return {
                user,
                openSearchDialog,
                openMobileMenu,
                menuList,
                showProfileMenu,
                toggleSearchDialog,
                logout
            }
        },
        components:{
            Search
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
  transform: translateY(30px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-100%);
}
.search-parent:focus-within{
    border-color: #3b83f67a;
}
.router-link-active{
    color: rgb(50 138 241);
}
.router-link-active+div{
    display: block;
    right: 0;
    opacity: 1;
}
ul.mobileMenuList li:nth-last-child(1){
    border-bottom: none;
}
</style>