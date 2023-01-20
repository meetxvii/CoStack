<i class="f" />>
<template>
    <div class=" px-5 py-5 w-full md:w-[70%] rounded-lg bg-blue/20" >
        <div class="">
            <div class="w-full px-4 relative">
                <div class="absolute right-0 z-10" v-if="question.isFeatured">
                    <div class="bg-yellow-500/40  px-2 py-1 rounded-lg text-white/60">
                        <i class="fas fa-star"></i>
                        Featured
                    </div>
                </div>
                <div class="absolute right-0 z-10" v-if="question.isSolved">
                    <div class="bg-green-500/40  px-2 py-1 rounded-lg text-white/60">
                        <i class="fas fa-check"></i>
                        Solved
                    </div>
                </div>
                <router-link :to="{name:'question', params:{'id':question.id}}" >
                    <div class="body text-xl font-semibold rounded w-[80%] md:w-[80%] lg:w-[85%] mb-2 -z-10">
                        {{question.title}}
                    </div>
                </router-link>
                <!-- <div class="body font-semibold rounded w-full" v-if="htmlParser(question.body) !== ''" >
                    <h1>{{htmlParser(question.body)}}</h1>
                </div> -->
            </div>
            <div class="w-full px-2 mt-4 flex justify-end gap-4 text-white/50 text-sm">
                <div class="capitalize flex items-center bg-blue/20 py-1 px-2 rounded gap-2" v-show="question.username">
                    <i class="fas fa-user"></i>
                     {{question.username}}
                </div>
                <div v-show="question.username">|</div>
                <div class="capitalize flex items-center bg-blue/20 py-1 px-2 rounded gap-2">
                    <i class="fas fa-clock"></i>

                    {{timeStamp(question.created_at)}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs,ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core';
import TextEditor from './TextEditor.vue'
import moment from 'moment'
import htmltoText from 'html-to-text'

    export default {
        name: "QuestionTemplate",
        props:['question'],
        setup(props){
            
            const question = ref(props.question);
            
            const timeStamp = (date) => {
                return moment(date).fromNow();
            }

            const Editor = ref(null);
            onMounted(() => {
                
            });

            const htmlParser = (html) => {
                return htmltoText.fromString(html);
            }
            

            return {
                question,
                timeStamp,
                Editor,
                htmlParser
            }
        },
        components:{
            TextEditor
        }

        
    }
</script>

<style  scoped>

</style>