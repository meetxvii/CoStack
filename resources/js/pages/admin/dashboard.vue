<template>
    <div class="bg-extra-dark-blue min-h-screen" v-if="loginState.isLoggedIn">
        <Sidebar /> 
        <div class="text-white min-h-screen md:ml-20 py-4 px-4">
            <div>
                <div class="heading-2">
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="my-5">
                <!-- informations -->
                <div>
                    <div class="heading-3 flex flex-col gap-3 pr-20">
                        <div class="">
                            <h1 class="mb-4">Users</h1>
                            <div class="flex flex-col md:flex-row gap-10">
                                <div>
                                    <router-link :to="{name:'admin-reports'}">
                                        <div class="flex flex-col items-center gap-3 w-64  bg-blue/20 px-10 py-10 rounded-lg">
                                            
                                            <div class="heading-3 flex items-center gap-4"> <i class="fas fa-user"></i> {{totalUsers}}</div>
                                            <div class="body font-semibold">Total Users</div>
                                        </div>
                                    </router-link>
                                </div>
                                <!-- <div>
                                    charts
                                </div> -->
                                
                            </div>
                        </div>
                        <!-- Technologies -->
                        <div>
                            <h1 class="mb-4">Technologies</h1>
                            <div class="flex flex-col md:flex-row gap-10">
                                <div>
                                    <router-link :to="{name:'admin-technologies'}">
                                        <div class="flex flex-col items-center gap-3 w-64 bg-blue/20 px-10 py-10 rounded-lg">
                                            
                                            <div class="heading-3 flex items-center gap-4"> <i class="fas fa-code"></i> {{totalTechnologies}}</div>
                                            <div class="body font-semibold">Total Technologies</div>
                                        </div>
                                    </router-link>
                                </div>
                                <!-- <div>
                                    charts
                                </div> -->
                            </div>
                        </div>

                        <div>
                            <h1 class="mb-4">Reports</h1>
                            <div class="flex flex-col md:flex-row gap-10">
                                <div>
                                    <router-link :to="{name:'admin-reports'}">
                                        <div class="flex flex-col items-center gap-3 w-64 bg-blue/20 px-10 py-10 rounded-lg">
                                            
                                            <div class="heading-3 flex items-center gap-4"> <i class="fa-solid fa-triangle-exclamation"></i> {{totalReports}}</div>
                                            <div class="body font-semibold">Total Reports</div>
                                        </div>
                                    </router-link>
                                </div>
                                <!-- <div>
                                    charts
                                </div> -->
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
    import { ref,watch } from 'vue';
    import { computed, onBeforeMount, onMounted } from '@vue/runtime-core';
    import { useAdmin } from "../../stores/Admin"
    import Sidebar from "./components/Sidebar.vue";
    import router from "../../router"
    import axios from 'axios';  
    export default {
        name: 'Dashboard',
        setup() {
            const loginState = computed({
                get: () => useAdmin()
            })

            const totalUsers = ref(0)
            const totalTechnologies = ref(0)
            const totalReports = ref(0)
            const getData = async() =>{
                const res = await axios.get('/api/admin/dashboard')
                .then(res => {
                    
                    totalUsers.value = res.data.users;
                    totalTechnologies.value = res.data.technologies;
                    totalReports.value = res.data.reports;
                })
            }

            onMounted(() => {
                getData()
            })

            return {
                loginState,
                totalUsers,
                totalTechnologies,
                totalReports
            }
        },
        components:{
            Sidebar
        }
    }
</script>

<style scoped>

</style>