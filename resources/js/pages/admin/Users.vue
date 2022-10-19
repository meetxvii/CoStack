<template>
    <div class="bg-panel-700 min-h-screen">
        <Sidebar />
        <div class="text-white min-h-screen md:ml-20 py-4 px-4">
            <div>
                <div class="heading-2">
                    <h1>Users</h1>
                </div>
                <div class="my-5">
                    <div class="flex flex-col gap-2">
                        <div class="w-full py-5 px-5 bg-blue/20 rounded-lg" v-for="user in users" :key="user.id">
                            <div>
                                <div class="text-2xl"> @{{user.username}}</div>
                            </div>
                            <div class="mt-2 text-white/70 body font-semibold">
                                <div>{{user.email}}</div>
                            </div>
                            <div class="mt-2 flex justify-between">
                                <div v-if="user.is_verified" class="text-sm px-2 py-1 bg-green-500/40 rounded-lg">
                                    <i class="fa-solid fa-check"></i> Verified
                                </div>
                                <div >
                                    <button class="text-sm px-2 py-1 bg-red-500/40 rounded-lg" @click="deactivate(user.id)" v-if="user.is_active">
                                        <i class="fa-solid fa-trash"></i>
                                        Deactivate
                                    </button>
                                    <button class="text-sm px-2 py-1 bg-red-500/40 rounded-lg" @click="activate(user.id)" v-if="!user.is_active">
                                        <i class="fa-solid fa-trash"></i>
                                        Activate
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from 'vue'
import { onMounted } from '@vue/runtime-core';
import Sidebar from "./components/Sidebar.vue";
export default {
    setup () {
        
        const users = ref([]);
        const getUsers = async () => {
            const response = await axios.get('/api/admin/users/all').then(res => {
                users.value = res.data.users;
            })
        }

        const deactivate = async (id) => {
            const response = await axios.post('/api/admin/users/deactivate',{
                'user_id': id
            }).then(res => {
                console.log(res.data)
                getUsers();
            })
        }

        const activate = async (id) => {
            const response = await axios.post('/api/admin/users/activate',{
                'user_id': id
            }).then(res => {
                console.log(res.data)
                getUsers();
            })
        }

        onMounted(()=>{
            getUsers();
        })
        return {
            users,
            deactivate,
            activate
        }
    },
    components:{
        Sidebar
    }
}
</script>

<style lang="scss" scoped>

</style>