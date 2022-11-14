<template>
    <div class="w-screen min-h-screen bg-blue/25 fixed backdrop-blur-[2px] z-50 flex justify-center" >
        <div class="absolute top-4 right-8 bg-white px-4 py-2 rounded-xl text-grey hover:text-blue hover:scale-90 transition-all duration-100 cursor-pointer text-lg" @click="closeDialog">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="px-5 md:px-10 py-5 md:py-10 w-[90%] bg-white self-start mt-20 rounded-2xl md:rounded-3xl" id="searchPanel">
            <div>
                <div class="bg-white flex justify-center items-center px-5 rounded-xl border-2 search-parent "> 
                    <input type="search" v-model="searchText" class="w-full h-10 px-2 py-6 bg-transparent border-none outline-none text-grey search order-2 peer" placeholder="Search">
                    <div class="text-grey mr-2 order-1 peer-focus:text-blue">
                        <i class="fa-solid fa-magnifying-glass "></i>
                    </div>
                    <div v-if="searchText!==''" @click="searchText = ''" class="text-grey order-3 cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>

                <div class="w-full">
                    <div class="flex flex-col gap-4 pt-4" v-auto-animate>
                        <div v-for="result in searchResults" :key="result.id" class="bg-gray-400/20 shadow-md px-4 py-2  rounded-lg">
                            <div>
                                <router-link :to="{name:'question', params:{'id':result.id}}">
                                    <div class="font-semibold text-xl text-blue/70">
                                        <p>{{result.title}}</p>
                                    </div>
                                    <div>
                                        <p class="text-grey">{{htmlParser(result.body)}}</p>
                                    </div>
                                    <div class="flex mt-4">
                                        <div>
                                            <p class="text-grey capitalize">{{result.technology}}</p>
                                        </div>
                                        <div class="ml-5">
                                            <p class="text-grey capitalize">@{{result.username}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <p class="text-grey">{{timeStamp(result.created_at)}}</p>
                                        </div>
                                    
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs, ref, onMounted, onUnmounted, watch } from 'vue'
import htmltoText from 'html-to-text'
//import moment
import moment from 'moment'

export default {
    name: 'Search',
    setup (props, ctx) {
        const searchText = ref('');
        
        onMounted(()=>{
            setTimeout(() => {
                window.addEventListener('click', closeDialog);
            }, 500);
        })

        const closeDialog = () =>{
            
            if(!document.getElementById('searchPanel').contains(event.target)){
                ctx.emit('closeSearchDialog');
            }
            window.removeEventListener('click', closeDialog);
            
        }

        const searchResults = ref([]);

        watch(searchText, async(searchQuery) => {
            if(searchQuery === ''){
                return
            }
            

            const res = await axios.post('/api/search', {
                searchQuery
            }).then(res => {
                searchResults.value = res.data;
                console.table(searchResults.value);
            })

        })

        const htmlParser = (html) => {
            return htmltoText.fromString(html)
        }

        const timeStamp = (time) => {
            return moment(time).fromNow();
        }

        return {
            searchText,
            closeDialog,
            searchResults,
            htmlParser,
            timeStamp
        }
    }
}
</script>

<style  scoped>
.search-parent:focus-within{
    border-color: #3b83f67a;
}
</style>