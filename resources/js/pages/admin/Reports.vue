<template>
    <div class="bg-panel-700 min-h-screen">
        <div>
            <sidebar />
        </div>
        <div class="text-white md:ml-20 px-10 pt-4">
            <div class="w-full flex flex-col gap-2 " >
                <div class="w-full">
                    <h1 class="heading-1 font-bold">Reports</h1>
                </div>
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5 bg-blue/60 px-5 py-2 rounded-lg">
                        <div class="heading-2 mr-auto">
                            <h2>Reported Questions</h2>
                        </div>
                        <div class="heading-3 ">
                            Total: {{questions.length}}
                        </div>
                        <div class="text-lg">
                            <button @click="showQuestions= !showQuestions">
                                <!-- font awesome chevron down icon -->
                                <div v-if="!showQuestions">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div v-if="showQuestions">
                                    <i class="fas fa-chevron-up"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4" v-auto-animate v-if="showQuestions">
                        <div class="bg-blue/20 py-4 px-4 rounded-lg" v-for="question in questions" :key="question.question.id" >
                            <div>
                                <h1 class="heading-3 text-2xl">
                                    {{question.question.title}}
                                </h1>
                            </div>
                            <div>
                                <h1 class="font-semibold text-white/60">
                                    {{htmlParse(question.question.body)}}
                                </h1>
                            </div>
                            <div class="mt-2 text-white/60 flex justify-between gap-2">
                                <div class="px-3 py-1 bg-blue/20 rounded-lg">
                                    <span>Total Reports {{question.total_reports}}</span>
                                </div>
                                <div class="text-red-500/100 px-3 py-1 bg-blue/20 rounded-lg ">
                                    <button class="flex items-center gap-2" @click="deleteQuestion(question.question.id)">
                                        <!-- delete icon fontawesome -->
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- answers  -->
                <div class="flex flex-col gap-5 mt-5">
                    <div class="flex items-center gap-5 bg-blue/60 px-5 py-2 rounded-lg">
                        <div class="heading-2 mr-auto">
                            <h2>Reported Answers</h2>
                        </div>
                        <div class="heading-3 ">
                            Total: {{answers.length}}
                        </div>
                        <div class="text-lg">
                            <button @click="showAnswers= !showAnswers">
                                <!-- font awesome chevron down icon -->
                                <div v-if="!showAnswers">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div v-if="showAnswers">
                                    <i class="fas fa-chevron-up"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-4" v-auto-animate v-if="showAnswers">
                        <div class="bg-blue/20 py-4 px-4 rounded-lg" v-for="answer in answers" :key="answer.answer.id" >
                            
                            <div>
                                <h1 class="heading-3 text-2xl">
                                    {{htmlParse(answer.answer.answer)}}
                                </h1>
                            </div>
                            
                            <div class="mt-2 text-white/60 flex justify-between gap-2">
                                <div class="px-3 py-1 bg-blue/20 rounded-lg">
                                    <span>Total Reports {{answer.total_reports}}</span>
                                </div>
                                <div class="text-red-500/100 px-3 py-1 bg-blue/20 rounded-lg ">
                                    <button class="flex items-center gap-2" @click="deleteAnswer(answer.answer.id)">
                                        <!-- delete icon fontawesome -->
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete</span>
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
import {ref, onMounted} from 'vue'
import Sidebar from './components/Sidebar.vue'
import axios from 'axios'
import {htmlToText} from 'html-to-text';
export default {
    setup () {

        const questions = ref([])
        const answers = ref([])

        const showQuestions = ref(true)
        const showAnswers = ref(true)

        const loadReports = async () => {
            await axios.get('/api/admin/reports')
            .then((response) => {
                
                questions.value = response.data.questions
                answers.value = response.data.answers
            }).catch((error) => {
                console.log(error)
            })
        }
        onMounted(async() => {
            loadReports()
        })

        const htmlParse = (html) => {
            return htmlToText(html)
        }

        const deleteQuestion = async(id) => {
            await axios.post('/api/admin/delete/question',{
                'question_id':id
            })
            .then((response) => {
                loadReports()
            })
            .catch((error) => {
                console.log(error)
            })
        }
        const deleteAnswer = async(id) => {
            await axios.post('/api/admin/delete/answer',{
                'answer_id':id
            })
            .then((response) => {
                console.log(response)
                loadReports()
            })
            .catch((error) => {
                console.log(error)
            })
        }

        return {
            questions,
            showQuestions,
            answers,
            showAnswers,
            htmlParse,
            deleteQuestion,
            deleteAnswer
        }
    },
    components: {
        Sidebar
    }
}
</script>

<style scoped>

</style>