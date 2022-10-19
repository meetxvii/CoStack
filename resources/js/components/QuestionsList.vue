<template>
    
    <div class="w-full flex flex-col items-center gap-4 mb-5 justify-center" v-auto-animate>
        <template v-for="question in questions" :key ="question.id" >
            <QuestionTemplate :question="question" />
        </template>
    </div>
    
</template>

<script>
import { reactive, ref, computed, watch, onMounted, onBeforeMount } from 'vue'

import axios from 'axios'
import QuestionTemplate from './QuestionTemplate.vue'


export default {
    name: "QuestionsList",
    props: ['technologyID'],
    setup(props, context) {
        
        const questions = ref({});

        const TechId = computed(() =>{
            return props.technologyID;
        });
        watch(TechId, async () =>{
            await getQuestions();
        });

        const getQuestions = async() => {
            const res = await axios.get('/api/questions',{
                params: {
                    technology: TechId.value
                } 
            })
            .then(res => {
                questions.value = res.data;
                context.emit('loaded', true);
            })
            .catch(err => {
                console.log(err);
            })
        }
        
        return {
            questions,
            getQuestions,
        }

    },
    components: {
        QuestionTemplate     
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