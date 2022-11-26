<template>
    <div class="min-h-screen bg-extra-dark-blue">
        <TopHeader />
        <div class="w-full flex justify-center pt-24">
            <div class="bg-panel-700 w-[80vw] md:w-[40vw] flex flex-col justify-center items-center text-white rounded-lg py-6 px-4">
                <h1 class="heading-2">Verify Mail</h1>
                <p class="">
                    <span class="body font-semibold">We have sent a verification link to your email address.</span>
                    <span class="body font-semibold">Please check your email and click on the link to verify your email address.</span>
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
import TopHeader from '../components/TopHeader.vue'
import axios from 'axios'
import router from "../router"
export default {
    setup() {
        const logout = async() => {
            const res = await axios.post('/api/logout').then(()=>{
                router.push('/login')
            })
        }
        return {
            logout
        }
        
    },
    components: { 
        TopHeader
    }
}
</script>

<style scoped>

</style>