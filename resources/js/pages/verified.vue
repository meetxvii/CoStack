<template>
    <div class="min-h-screen bg-extra-dark-blue">
        
        <div class="w-full flex justify-center pt-24" v-show="isVerifying && !Failed">
            <div class="bg-panel-700 w-[80vw] md:w-[40vw] flex flex-col justify-center items-center text-white rounded-lg py-6 px-4">
                <h1 class="heading-2">Mail Verification in process</h1>
                <p class="">
                    <span>We are verifying your email please wait</span>
                    <span class="animate-ping"> .</span>
                    <span class="animate-ping"> .</span>
                    <span class="animate-ping"> .</span>
                    <span class="animate-ping"> .</span>
                </p>
            </div>
        </div>
        <div class="w-full flex justify-center pt-24" v-show="!isVerifying && !Failed">
            <div class="bg-panel-700 w-[80vw] md:w-[40vw] flex flex-col justify-center items-center text-white rounded-lg py-6 px-4">
                <h1 class="heading-2">Mail Verified successfully</h1>
                <p class="">
                    <span>You mail is verified successfully. you can use costack now!!</span>
                </p>
                <button><router-link :to="{name:'dashboard'}">Home</router-link></button>
            </div>
        </div>
        <div class="w-full flex justify-center pt-24" v-show="Failed">
            <div class="bg-panel-700 w-[80vw] md:w-[40vw] flex flex-col justify-center items-center text-white rounded-lg py-6 px-4">
                <h1 class="heading-2">Mail Verification Failed</h1>
                <p class="">
                    <span>Mail verification got failed please try again with another mail</span>
                </p>
                <button class="py-2 px-6 mt-4 bg-blue rounded cursor-pointer" @click="logout">Logout</button>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from 'vue'
import { computed, onMounted, watch } from '@vue/runtime-core'
import {useRoute} from 'vue-router'

import axios from 'axios'
import router from "../router"
export default {
    setup() {
        const isVerifying = ref(true);
        const Failed = ref(false);
        const token = computed(() => useRoute().params.token);
        const checkToken = async() => {
            const res = await axios.post('/api/user/verify', {token: token.value})
            .then((response)=>{

                console.log(response.data);
                if(response.data.message == 'success'){
                    isVerifying.value = false;
                    
                    setTimeout(() => {
                        router.push({name:'dashboard'})
                    }, 1500);
                }else{
                    Failed.value = true;
                }
                isVerifying.value = false;
            }).catch((error)=>{
                console.log(error);
                Failed.value = true;
                isVerifying.value = false;
            })
        }
        const logout = async() => {
            const res = await axios.post('/api/logout').then(()=>{
                router.push('/login')
            })
        }
        onMounted(() => {
            checkToken();
        })
        return {
            isVerifying,
            Failed,
            logout
        }
        
    },
    components: { 
     
    }
}
</script>

<style scoped>

</style>