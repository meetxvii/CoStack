
<template>
    <div>
        <TopHeader ref="header" />        
    </div>
    <div id="contentview"  class="bg-dark-blue pt-16 md:pt-20">
        <div  class="min-h-[70vh] md:min-h-[90vh] bg-extra-dark-blue  bg-[url('../img/man-developing-website-on-desk.svg')] bg-[length:50%]  bg-no-repeat bg-[position:right_center] flex">
            <div class="text-white w-full px-4 md:px-36 flex flex-col justify-center items-start text-center">
                <div class="text-center heading-1 md:text-7xl font-rounded">
                    CoStack
                </div>
                <div class="flex flex-col items-start text-5xl md:mt-10 gap-2">
                    <div class="font-semibold opacity-80">
                        <span class="text-blue">Co</span>llaborate
                    </div>
                    <div class="font-semibold opacity-80">
                        <span class="text-blue">Stack</span> your skills
                    </div>
                </div>
                <div class="">
                    <button class="mt-10" @click="toggleSearch">
                        <div class="bg-blue text-white px-10 py-3 rounded-2xl font-semibold text-lg ">
                            <span class="mr-2">Find Solution </span>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </button>
                </div>
                
            </div>
        </div>
        <div class="px-10 md:px-12 lg:px-24 py-10 bg-extra-dark-blue">
            <div>
                <h1 class="heading-2 text-center uppercase ">Technologies</h1>
                <p class="body text-center font-semibold text-white/70">Get solution for all your technologies</p>
                <div class="w-[100%] flex justify-center">
                    <div class="bg-blue/50 pt-1 rounded-3xl my-4 w-full md:w-[50%]"></div>
                </div>
            </div>
            <TechnologyList />
        </div>
    </div>
</template>
<script >
    import { reactive, ref, toRefs, onMounted } from 'vue';
    import TopHeader from '../components/TopHeader.vue';
    import { useUser } from '../stores/User';
    import axios from 'axios';
    import {CheckLogin} from '../composables/CheckLogin';
    import TechnologyList from '../components/TechnologyList.vue';
    export default {
        name: 'dashboard',
        setup(){
            const user = useUser();
            const header = ref(null);

            
            onMounted(()=>{
                CheckLogin();
            })            
            
            const toggleSearch = () =>{
                console.log(header.value.openSearchDialog=true);
            }

            return {
                user,
                header,             
                toggleSearch,
            }
        },
        components:{
            TopHeader,
            TechnologyList,            
        }
        
    }

</script>
<style scoped>
    
</style>