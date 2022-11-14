<template>
    <div class="min-h-screen w=screen bg-extra-dark-blue">
        <TopHeader />
        <div class="pt-16 md:pt-20">
            <div class="w-full flex justify-center">
                <div class="w-[90vw]">
                    <div class="my-5">
                        <h1 class="heading-1">
                            Featured
                        </h1>
                        <div class="heading-3">
                            <p class="font-semibold">Help your community by answering featured questions</p>
                            <p class="text-white/70">
                                <span class="text-sm font-extrabold">Note : </span>
                                <span class="text-sm font-extrabold">Questions which are not marked as solved and older than 3 days will be featured automaticallly</span>
                            </p>
                        </div>

                        <div>
                            <div class="flex flex-col gap-4 pt-5">
                                <div v-for="question in questions" :key="question.id">
                                    <router-link :to="{name:'question',params:{'id':question.id}}">
                                        <div  class="px-4 py-2 bg-blue/20 text-white rounded-lg">
                                            <div class="heading-3">
                                                <h1>{{question.title}}</h1>
                                            </div>
                                            <div class="body font-semibold ">
                                                <h1>{{htmlParser(question.body)}}</h1>
                                            </div>
                                            <div class="flex items-center my-2 pt-2 border-t border-blue/20 gap-4 text-white/60">
                                                <div class="bg-blue/20 px-2 py-1 rounded flex items-center gap-2">
                                                    <i class="fas fa-code"></i>
                                                    {{question.technology_name}}
                                                </div>
                                                <div class="bg-blue/20 px-2 py-1 rounded flex items-center gap-2">
                                                    <i class="fas fa-user"></i>
                                                    {{question.username}}
                                                </div>
                                                <div class="bg-blue/20 px-2 py-1 rounded flex items-center gap-2">
                                                    <i class="fas fa-clock"></i>
                                                    {{timeAgo(question.created_at)}}
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <FeaturedList />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from 'vue';
import { onMounted } from '@vue/runtime-core'
import TopHeader from "../components/TopHeader.vue"
import htmltoText from 'html-to-text'
import moment from 'moment'
export default {
    setup () {

        const questions = ref([]);
        const getQuestions = async() =>{
            await axios.get('/api/questions/featured')
            .then((response)=>{
                questions.value = response.data;
                console.log(response.data);
            })
            .catch((error)=>{
                console.log(error);
            })
        }
        onMounted(()=>{
            getQuestions();
        })

        const htmlParser = (html) =>{
            return htmltoText.fromString(html)
        }

        const timeAgo = (date) =>{
            return moment(date).fromNow();
        }

        return {
            questions,
            htmlParser,
            timeAgo

        }
    },
    components:{
        TopHeader
    }
}
</script>

<style scoped>

</style>