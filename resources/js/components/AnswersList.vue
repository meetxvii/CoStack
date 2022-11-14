<template>
    <div>
        <teleport to="#questionpage">

            <div class="fixed z-50 top-0 left-0 min-w-[100vw] min-h-screen bg-blue/20 backdrop-blur flex justify-center items-center" v-if="showReportModal">

                <div class="absolute top-10 right-10">
                    <button class="bg-white/20 px-2 py-1 rounded" @click="showReportModal=false">
                        <i class="fa-solid fa-times text-white/50"></i>
                    </button>
                </div>
                <div class="bg-blue/20 w-[40vw] py-10 px-10 flex justify-center rounded-lg backdrop-blur">
                    <div class="heading-2">
                        <h1>Reported Successfully</h1>
                        <div>
                            <p class="body font-semibold text-white/70 ">Thank you for reporting this question. We will review it and take appropriate action.</p>
                        </div>
                    </div>
                </div>
            </div>
        </teleport>
        <div class="mb-4">
            <div>
                <div class="w-full flex ">
                    <div class="bg-blue/20 flex flex-col md:flex-row w-full gap-4 px-5 py-3 rounded-lg">
                        <div class="flex overflow-hidden w-full">
                            <transition name="slide-up" mode="out-in">
                                <div class="text-white/90 flex items-end justify-between w-full " v-if="showSearchBar===false">
                                    <!-- sort div -->
                                    <div>
                                        <div class="mb-2 text-sm">
                                            <span>Sort By</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-32 px-2 py-1 bg-blue/20 rounded-full cursor-pointer overflow-hidden flex justify-center" :class="{
                                                'text-blue': sortby === 'upvote' || sortby === 'downvote',
                                                'bg-white': sortby === 'upvote' || sortby === 'downvote',
                                                'text-white/90': sortby !== 'upvote' && sortby !== 'downvote'
                                            }">
                                                <!-- upvote -->
                                                <transition name="slide-up" mode="out-in">
                                                    <div v-if="sortby!=='downvote' || sortby==='default'" class="flex items-center gap-2" @click="sortby='downvote'">
                                                        <i class="fa-solid fa-chevron-up"></i>
                                                        <span>Upvote</span>
                                                    </div>
                                                    <div v-else-if="sortby==='downvote'" class="flex items-center gap-2" @click="sortby='upvote'">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                        <span>Downvote</span>
                                                    </div>
                                                </transition>
                                            </div>
                                            <div class="w-36 px-2 py-1 bg-blue/20 rounded-full cursor-pointer overflow-hidden flex justify-center" :class="{
                                                'text-blue': sortby === 'latest' || sortby === 'oldest',
                                                'bg-white': sortby === 'latest' || sortby === 'oldest',
                                                'text-white/90': sortby !== 'latest' && sortby !== 'oldest'
                                            }">
                                                <!-- upvote -->
                                                <transition name="slide-up" mode="out-in">
                                                    <div v-if="sortby!=='oldest' || sortby==='default'" class="flex items-center gap-2" @click="sortby='oldest'">
                                                        <i class="fa-solid fa-chevron-up"></i>
                                                        <span>Latest First</span>
                                                    </div>
                                                    <div v-else-if="sortby==='oldest'" class="flex items-center gap-2" @click="sortby='latest'">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                        <span>Oldest First</span>
                                                    </div>
                                                </transition>
                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <button class="bg-blue/20 py-2 px-4 text-white rounded-xl" @click="showSearchBar=true">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex w-full items-end ml-auto" v-else-if="showSearchBar===true">
                                    <div class="w-full flex items-center text-white bg-blue/20 px-4 rounded-md">
                                        <div>
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </div>
                                        <input type="text" class="bg-transparent text-white/90 px-4 py-2 flex-grow placeholder:text-white outline-none" placeholder="Search..." v-model="searchQuery">
                                        <div>
                                            <button @click="showSearchBar=false">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <div v-auto-animate>
            <template v-for="answer in filteredAnswers" :key="answer.id"  >
                <AnswerTemplate :answer="answer" :user="loggedUser" :question_info="Question_info" @reloadAnswers = "getAnswers" @reported="showReportModal=true" />
            </template>
        </div>
        

    </div>
</template>

<script>
import {computed, onMounted, ref, watch} from 'vue';
import axios from 'axios'

import {CheckLogin} from '../composables/CheckLogin'
import {useUser} from "../stores/User";
import AnswerTemplate from './AnswerTemplate.vue';

import {htmlToText} from 'html-to-text';
export default {
    props: ['question_info'],
    setup (props, context) {
        const loggedUser = useUser();

        const Question_info = computed(() => {
            return props.question_info;
        });

        watch(Question_info, (newVal, oldVal) => {
            getAnswers()
        }, {deep: true});

        const answers = ref([]);
        const filteredAnswers = ref([]);

        const getAnswers = async() =>{
            
            const res = await axios.get('/api/answers', {
                params: {
                    question_id: Question_info.value.id
                }
            }).then((res) => {
                
                answers.value = res.data;
                filteredAnswers.value = res.data;


            }).catch((err) => {
                console.log(err);
            });
        }

        //sort
        const sortby = ref('default')
        const showSearchBar = ref(false);
        const searchQuery = ref('');

       

        watch(searchQuery, (newVal, oldVal) => {
            if(!showSearchBar.value ){
                return
            }
            if(newVal === ''){
                filteredAnswers.value = answers.value;
                return
            }
            filteredAnswers.value = [];
            answers.value.forEach((answer) => {
                
                if(htmlToText(answer.answer).toLowerCase().includes(newVal.toLowerCase())){
                    filteredAnswers.value.push(answer);
                }
            });
          
        });

        watch(sortby, (newVal, oldVal) => {
            if(newVal === 'default'){
                console.log('default')
                filteredAnswers.value = answers.value;
                return
            }
            if(newVal === 'upvote'){
                filteredAnswers.value = answers.value.sort((a, b) => {
                    return b.vote - a.vote
                })
                return
            }
            if(newVal === 'downvote'){
                filteredAnswers.value = answers.value.sort((a, b) => {
                    return a.vote - b.vote
                })
                return
            }

            if(newVal === 'latest'){
                filteredAnswers.value = answers.value.sort((a, b) => {
                    return new Date(b.created_at) - new Date(a.created_at)
                })
            }
            if(newVal === 'oldest'){
                filteredAnswers.value = answers.value.sort((a, b) => {
                    return new Date(a.created_at) - new Date(b.created_at)
                })
            }
        });

        const showReportModal = ref(false);
        
        const toggleReportModal = status =>{
            showReportModal.value = status;
        }

        return {
            Question_info,
            answers,
          
            filteredAnswers,
            sortby,
            showSearchBar,
            searchQuery,      
            loggedUser,
            showReportModal,
            toggleReportModal,
            getAnswers
        }
    },
    components: {
    AnswerTemplate,
    AnswerTemplate
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
</style>