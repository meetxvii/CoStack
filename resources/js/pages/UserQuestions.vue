<template>
    <div>
        <TopHeader />
    </div>
    <div class="min-h-screen bg-dark-blue pt-16 md:pt-20">
        <div class="w-full flex flex-col items-center mt-5" v-if="username">
            <h1 class="heading-2">Questions asked by {{username}}</h1>
        </div>
        <div class="w-full flex flex-col items-center gap-4 mb-5 my-5 justify-center" v-auto-animate>
            
            <template v-for="question in questions" :key ="question.id"  >
                <QuestionTemplate :question="question" />
            </template>
            <div v-if="questions.length===0 && questionsLoaded && username" class="px-40 bg-blue/20 py-4 rounded-lg">
                <h1 class="heading-3 ">No Questions Found !!</h1>
            </div>
            <QuestionsSkeleton  v-show="!questionsLoaded" />
            
            <div v-show="questions.length===0 && questionsLoaded && username===''" class="flex flex-col items-center mt-5 gap-5">

                <img src="../../img/404.svg" class="w-[40vw]" alt="">
                <div class="heading-1 font-rounded uppercase text-white/90">not found</div>
            </div>
        </div>

    </div>
</template>

<script>
import {ref} from 'vue'
import { computed, onMounted } from '@vue/runtime-core'
import { useRoute } from 'vue-router'
import axios from 'axios'
import TopHeader from '../components/TopHeader.vue'
import QuestionTemplate from '../components/QuestionTemplate.vue';
import QuestionsSkeletonVue from '../components/QuestionsSkeleton.vue'

import {useUser} from '../stores/User'
import QuestionsSkeleton from '../components/QuestionsSkeleton.vue'
export default {
    setup () {
        const userID = computed(() => {
            return useRoute().params.id
        })
        const doesOwns = ref(false)
        const questions = ref([]);
        const username = ref('');
        const questionsLoaded = ref(false);

        const getUserQuestions = async () => {
            const response = await axios.post('/api/user/questions',{
                user_id: userID.value
            }).then((response) => {
                questions.value = response.data.questions,
                username.value = response.data.username,
                questionsLoaded.value = true
            }).catch(()=>{
                questionsLoaded.value= true;
            })
        }
        onMounted(() => {

            getUserQuestions()
        })
        return {
            userID,
            questions,
            username,
            questionsLoaded,
            getUserQuestions
        }
    },
    components: {
        TopHeader,
        QuestionTemplate,
        QuestionsSkeleton,
    }
}
</script>

<style scoped>

</style>