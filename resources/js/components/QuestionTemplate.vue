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
                <router-link :to="{name:'question', params:{'id':question.id}}" >
                    <div class="heading-3 rounded w-[80%] md:w-[80%] lg:w-[85%] mb-2 -z-10">
                        {{question.title}}
                    </div>
                </router-link>
                <div class="body font-semibold rounded w-full">
                    <TextEditor :content="question.body" contentType="html" ref="Editor" theme="bubble" readonly="true" heigth="70px" />
                </div>
            </div>
            <div class="w-full px-2 mt-4 flex justify-end gap-4 text-white/50 text-sm">
                <div class="capitalize">
                    By {{question.username}}
                </div>
                <div>|</div>
                <div>
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

            

            return {
                question,
                timeStamp,
                Editor
            }
        },
        components:{
            TextEditor
        }

        
    }
</script>

<style  scoped>

</style>