<template>
    <div>
        <TopHeader ref="header" />        
    </div>
    <div class="fixed w-full min-h-screen bg-blue/20 backdrop-blur z-50 realative" v-if="showAskModal">
        <div class="w-full min-h-screen flex justify-center ">
            <div class="absolute right-10 top-10 bg-white px-2 py-1 rounded-lg" @click="closeModal">
                <i class="fas fa-times text-lg text-red-500  cursor-pointer" ></i>
            </div>
            <div class="self-center bg-panel-700 w-[90%] flex flex-col py-10 px-10 border-2 rounded-xl border-blue/40 ">
                <div class="text-center text-white heading-2">
                    <h1>Ask Question</h1>
                </div>
                <div>
                    <form>
                        <div class="my-4">
                            <div>
                                <div class="relative z-0">
                                    <input type="text" v-model="title" id="title" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                    :class="{
                                        'border-red-600': !isTitleValid,
                                        'dark:border-red-500': !isTitleValid,
                                        'dark:focus:border-red-500': !isTitleValid,
                                        'focus:border-red-600': !isTitleValid,
                                        'border-white': isTitleValid,
                                        'dark:border-white': isTitleValid,
                                        'dark:focus:border-white': isTitleValid,
                                        'focus:border-white': isTitleValid,
                                    }"
                                    
                                    />
                                    <label for="title" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                    :class="{
                                        'text-red-600': !isTitleValid,
                                        'dark:text-red-500': !isTitleValid,
                                        'text-white' : isTitleValid,
                                        'dark:text-white' : isTitleValid,
                                    }"
                                    >Title</label>
                                </div>
                                <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                    'text-red-600' : !isTitleValid,
                                    'dark:text-red-400' : !isTitleValid,
                                    'text-white': isTitleValid,
                                    'dark:text-white': isTitleValid
                                }"
                                v-show="!isTitleValid"
                                >{{TitleMessage}}</p>
                            </div>
                        </div>

                        <div>
                            <TextEditor ref="DescriptionEditor" contentType="html" />
                        </div>

                        <div class="mt-5">
                            <button class="bg-blue text-white w-full rounded-lg py-3 text-lg " @click.prevent="SubmitQuestion">Ask Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="min-h-screen bg-dark-blue pt-16 md:pt-20">

        <div class="px-5 md:px-20 w-full flex flex-col md:flex-row">
            
            <div class="bg-blue/20 flex flex-col md:flex-row w-full gap-4 px-5 py-5 rounded-lg my-5">
                <div class="w-full flex items-center justify-between">
                    <div v-if="!TechnologyInfo.image" class="w-[25%] h-20  md:h-20 bg-blue/20 rounded animate-pulse">
                        
                    </div>
                    <div class="w-[25%] h-20 md:w-[25%] md:h-20 " v-if="TechnologyInfo.image">
                        <img :src="`/storage/images/technologies/${TechnologyInfo.image}`" class="w-full h-full object-contain" alt="">
                    </div>
                    <div class="w-[70%]">
                        <h1 class="heading-2 text-blue uppercase">{{TechnologyName}}</h1>
                        <p class="text-white/60 font-semibold body">{{TechnologyInfo.description}}</p>
                    </div>
                </div>
                <div class="w-full flex items-center justify-between md:border-l-2 border-blue/20 px-5 border-t-2 md:border-t-0 pt-5 md:pt-0 " >
                    <div class="text-white/60 body font-semibold  md:text-right md:mt-2">
                        Total Questions {{totalQuestions}}
                    </div>         
                    <div class="text-right" v-if="loggedUser.isLoggedIn">
                        
                        <button class="bg-blue px-4 py-3 text-white rounded " @click.prevent="showAskModal = true">Ask Question</button>
                    </div>       
                </div>
            </div>
            
        </div>
        <div class="px-5 md:px-20 w-full flex flex-col md:flex-row">      
                
            <QuestionsList :technologyID="TechnologyInfo.id" ref="Quelist" @loaded="isQueLoaded=true" v-show="isQueLoaded"  />

            <QuestionsSkeleton v-if="!isQueLoaded" />
                
        </div>
    </div>
    <div>
        
    </div>
</template>

<script>
    import { onMounted, toRefs } from '@vue/runtime-core';
    import {ref, reactive, computed, onBeforeMount, watch} from 'vue';
    import axios from 'axios';
    import router from '../router';
    import { useRoute } from 'vue-router'

    import {CheckLogin} from '../composables/CheckLogin';
    import {useUser} from '../stores/User';

    import TopHeader from '../components/TopHeader.vue';
    import QuestionsList from '../components/QuestionsList.vue';
    import QuestionsSkeleton from '../components/QuestionsSkeleton.vue';
    import TextEditor from '../components/TextEditor.vue';
    export default {
        setup(){

            const Quelist = ref({});
            const isQueLoaded = ref(false);

            const TechnologyName = computed(() =>{
                return useRoute().params.name;
            });
            const TechnologyInfo = ref({
                id: '',
                name: '',
                description: '',
                image: ''
            });
            
            const getTechnologyInfo = async () =>{
                const response = await axios.get(`/api/technology`,{
                    params:{
                        name: TechnologyName.value
                    }
                }).then((response) =>{
                    TechnologyInfo.value.id = response.data.technology.id;
                    TechnologyInfo.value.name = response.data.technology.name;
                    TechnologyInfo.value.description = response.data.technology.description;
                    TechnologyInfo.value.image = response.data.technology.image;
                    
                }).catch((error) =>{
                    console.log(error);
                });
                
            }

            const loggedUser = computed(() =>{
                return useUser();
            });

            onMounted(async () =>{
                const TechnologyInfo = await getTechnologyInfo();
                await CheckLogin();
                loggedUser.value = await useUser();
            });

            const totalQuestions = ref(0);

            //watch on TechnologyInfo
            const getTotalQuestions = async() =>{
                const res = await axios.get('/api/total-questions',{
                    params: {
                        technology: TechnologyInfo.value.id
                    }
                }).then((res) =>{
                    totalQuestions.value = res.data;
                }).catch((err) =>{
                    console.log(err);
                });
            }

            watch(TechnologyInfo, async() =>{
                const totalQuestions = await getTotalQuestions();
            }, {deep: true});

          

            // ask modal
            const showAskModal = ref(false);
            const DescriptionEditor = ref();

            
            const AskForm = reactive({
                title: '',
                description: '',                
            });
            const validation = reactive({
                isTitleValid: true,
                TitleMessage: '',
                isDescriptionValid: true,
                DescriptionMessage: '',                
            });
            
            const SubmitQuestion = async() =>{
                AskForm.description = DescriptionEditor.value.getData();
                
                if(AskForm.title.length < 10){
                    validation.isTitleValid = false;
                    validation.TitleMessage = 'Title must be at least 10 characters';
                    return
                }
                if(AskForm.title.length >= 200){
                    validation.isTitleValid = false;
                    validation.TitleMessage = 'exceeded 200 characters limit';
                    return
                }
                validation.isTitleValid = true;
                validation.TitleMessage = '';

                
                const res = await axios.post('/api/ask-question', {
                    'user_id' : loggedUser.value.user.id,
                    'technology': TechnologyInfo.value.id,
                    'title': AskForm.title,
                    'description': AskForm.description.toString(),
                }).then((res) =>{
                    showAskModal.value = false;
                    Quelist.value.getQuestions();
                }).catch((err) =>{
                    console.log(err);
                });
            }

            const closeModal = () =>{
                showAskModal.value = false;
                AskForm.title = '';
            }



            return {
                TechnologyName,  
                TechnologyInfo,
                totalQuestions,
                showAskModal,
                ...toRefs(AskForm),
                ...toRefs(validation),
                DescriptionEditor,
                SubmitQuestion,
                closeModal,
                loggedUser,
                Quelist,
                isQueLoaded
            }
        },
        components: {
            TopHeader,
            QuestionsList,
            QuestionsSkeleton,
            TextEditor,
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
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>