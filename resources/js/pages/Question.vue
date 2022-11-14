<template>
    <div>
        <TopHeader />  
    </div>
    <div id="questionpage" class="">
    </div>
    <div class="min-h-screen bg-dark-blue pt-16 md:pt-20">
        <div class="flex flex-col gap-5 justify-center py-5 px-5">

            <!-- Question main div -->
            <div class="w-full">

                <!-- Question details -->
                <div class="bg-blue/20 flex flex-col gap-4 px-5 py-5 rounded-lg">
                    
                    <div class="flex justify-end" >
                        <div class="w-24 py-4 bg-blue/20 rounded" v-if="QuestionInfo.isFeatured===undefined"></div>
                        <div class="px-2 py-1 rounded bg-yellow-400/40 text-white flex justify-center items-center gap-1" v-if="QuestionInfo.isFeatured" >
                            <i class="fas fa-star"></i>
                            <span>Featured</span>
                        </div>
                    </div>

                    <div>
                        <div class="w-full bg-blue/20 py-4 rounded-md animate-pulse" v-if="!QuestionInfo.title">

                        </div>
                        <div class="heading-2 text-2xl">
                            <h1>{{QuestionInfo.title}}</h1>
                        </div>                        
                    </div>

                    <div>
                        <div class="w-full bg-blue/20 py-10 rounded-md animate-pulse" v-if="!QuestionInfo.body">
                        </div>
                        <div class="heading-2 text-2xl" v-if="QuestionInfo.body">
                            <TextEditor :content="QuestionInfo.body" contentType="html" theme="bubble" readonly="true" heigth="none" />
                        </div>                        
                    </div>

                    <div class="flex items-center justify-end">
                        <div class="mr-auto">
                            <div class="w-24 bg-blue/20 py-4 rounded-md animate-pulse" v-if="!QuestionInfo.username">
                            </div>
                            <div class="body font-semibold text-sm capitalize" v-if="QuestionInfo.username">
                                <span>@ {{QuestionInfo.username}}</span>
                            </div>
                        </div>

                        <div class="mr-4">
                            <div class="w-24 bg-blue/20 py-4 rounded-md animate-pulse" v-if="!QuestionInfo.created_at">
                            </div>
                            <button class="body font-semibold text-sm flex justify-center items-center gap-2 bg-red-500/20 px-2 py-1 rounded" v-if="QuestionInfo.created_at && !isReported && loggedUser!==undefined" @click="report">
                                <i class="fa-solid fa-circle-exclamation text-white/50"></i>
                                <span>Report</span>
                            </button>
                        </div>

                        <div class="">
                            <div class="w-24 bg-blue/20 py-4 rounded-md animate-pulse" v-if="!QuestionInfo.created_at">
                            </div>
                            <div class="body font-semibold text-sm" v-if="QuestionInfo.created_at">
                                <span>{{timeStamp(QuestionInfo.created_at)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Answers -->
            <div class="w-full">
                <div>
                    
                    <AnswersList :question_info="QuestionInfo"   ref="AnsList" />
                </div>
            </div>

            <div class="w-full" v-if="loggedUser!==undefined">
                <div class="bg-blue/20 flex flex-col gap-4 px-5 py-5 rounded-lg">
                    <div class="heading-2 text-2xl">
                        <h1>Your Answer</h1>
                    </div>
                    <div>
                        <TextEditor contentType="html" theme="snow" heigth="200px" ref="answerEditor" />
                    </div>
                    <div class="flex">
                        <button class="bg-blue/20 px-6 py-2 text-white rounded-lg cursor-pointer" @click="submitAnswer">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {computed, onMounted, ref, watch} from 'vue';
import {useRoute} from 'vue-router';
import axios from 'axios';
import moment from 'moment'

import {useUser} from "../stores/User"
import TopHeader from '../components/TopHeader.vue'
import TextEditor from '../components/TextEditor.vue';
import AnswersList from '../components/AnswersList.vue';
import AnswerSkeleton from '../components/AnswerSkeleton.vue';
    export default {
        setup() {
            const timeStamp = (date) => {
                return moment(date).fromNow();
            }

            const QuestionInfo = ref({});

            const QuestionId = ref(0);

            const loggedUser = ref({});

            const AnsList = ref();

            const getAllInfo = async () => {

                QuestionId.value = useRoute().params.id;

                const res = await axios.get('/api/question', {
                    params: {
                        id: QuestionId.value
                    }
                }).then((res) => {          
                    
                    QuestionInfo.value = res.data.question;
                    QuestionInfo.value.username = res.data.username;
                }).catch((err) => {
                    console.log(err);
                });
            }

            const isReported = ref(false);

            

            onMounted(async() => {
                await getAllInfo();
                loggedUser.value = useUser().user.id;

                // check if reported
                await axios.get('/api/question/check-reported', {
                    params: {
                        user_id: loggedUser.value,
                        question_id: QuestionId.value
                    }
                }).then((res) => {
                    isReported.value = res.data;
                    
                }).catch((err) => {
                    console.log(err);
                });

                //
                

            });

            const report = async() => {
                console.log(QuestionId.value, loggedUser.value);
                const res = await axios.post('/api/question/report', {
                    question_id: QuestionId.value,
                    user_id: loggedUser.value
                }).then((res) => {
                    AnsList.value.toggleReportModal(true);
                }).catch((err) => {
                    console.log(err);
                });
            }

            const answerEditor = ref();

            const submitAnswer = async() => {
                const answer = await answerEditor.value.getData();
                
                const res = await axios.post('/api/answer', {
                    question_id: QuestionId.value,
                    user_id: loggedUser.value,
                    answer: answer
                }).then((res) => {
                    AnsList.value.getAnswers();
                }).catch((err) => {
                    console.log(err);
                });
            }
            

            return {
                QuestionInfo,
                loggedUser,
                
                timeStamp,
                report,
                isReported,
                AnsList,
                answerEditor,
                submitAnswer,
                
            }
        },
        components: {
            TopHeader,
            TextEditor,
            AnswersList,
            AnswerSkeleton,
        }
    }
</script>

<style scoped>

</style>