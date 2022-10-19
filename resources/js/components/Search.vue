<template>
    <div class="w-screen min-h-screen bg-blue/25 fixed backdrop-blur-[2px] z-50 flex justify-center" >
        <div class="absolute top-4 right-8 bg-white px-4 py-2 rounded-xl text-grey hover:text-blue hover:scale-90 transition-all duration-100 cursor-pointer text-lg" @click="closeDialog">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="px-10 py-10 w-[70%] bg-white self-start mt-20 rounded-3xl" id="searchPanel">
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
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs, ref, onMounted, onUnmounted } from 'vue'

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
            //check if the click is inside the search panel
            if(!document.getElementById('searchPanel').contains(event.target)){
                ctx.emit('closeSearchDialog');
            }
            window.removeEventListener('click', closeDialog);
            
        }
        return {
            searchText,
            closeDialog
        }
    }
}
</script>

<style  scoped>
.search-parent:focus-within{
    border-color: #3b83f67a;
}
</style>