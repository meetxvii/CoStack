<template>
    <div class="w-full">
        
        <div class="w-full bg-blue/20 px-5 py-5 rounded-lg mb-5">
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center text-white/70">
                    <button class="cursor-pointer px-1" @click="upvote" :class="{
                        'bg-blue/20' : isVoted>0,
                    }" :disabled="isVoted>0" >
                        <i class="fas fa-chevron-up"></i>
                    </button>
                    <div>
                        <span>{{answer.vote}}</span>
                    </div>
                    <button class="cursor-pointer px-1" @click = "downvote" :class="{
                        'bg-blue/20' : isVoted<0,

                    }" :disabled="isVoted<0">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="w-full">
                    <TextEditor theme="bubble" :content="answer.answer" heigth="none" contentType="html" readonly="true" />
                    <div class="mt-2 text-white/60 flex justify-start items-center gap-2 text-sm">
                        <div class="mr-auto">
                            <span class="flex items-center">@{{answer.username}}</span>
                        </div>
                        
                        <div v-if="isReported">
                            <button class="bg-red-500/20 px-2 py-1 rounded" @click="report">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                Report
                            </button>
                        </div>
                        <div v-if="isReported">
                            |
                        </div>
                        <div >
                            
                            {{timeStamp}}
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {watch,ref} from 'vue';
import { computed, onMounted } from '@vue/runtime-core'
import moment from 'moment'



import TextEditor from './TextEditor.vue'
export default {
    props: ['answer','user'],
    setup (props, context) {
        
        const answer = computed(() => {
            return props.answer;
        });
        const user = computed(() => {
            return props.user;
        });

        const timeStamp = computed(() => {
            return moment(answer.value.created_at).fromNow();
        });


        const upvote = async() => {
            console.log(user.value)
            const res = await axios.post('/api/answer/upvote', {
                answer_id: answer.value.id,
                user_id: user.value.user.id
            }).then(res => {
                context.emit('reloadAnswers')
            }).catch(err => {
                console.log(err);
            });

        }

        const downvote = async() => {
            const res = await axios.post('/api/answer/downvote', {
                answer_id: answer.value.id,
                user_id: user.value.user.id
            }).then(res => {
                context.emit('reloadAnswers')

            }).catch(err => {
                console.log(err);
            });
        }

        const report = async () => {
            
            const res = await axios.post('/api/answer/report', {
                answer_id: answer.value.id,
                user_id: user.value.user.id
            }).then(res => {
                context.emit('reported')
            }).catch(err => {
                console.log(err);
            });
        }

        const isReported = ref(false);
        const isVoted = ref(false);

        onMounted( async () => {
            // check if reported alredy
            const res = await axios.post('/api/answer/check-reported', {
                answer_id: answer.value.id,
                user_id: user.value.user.id
            }).then(res => {
                if(res.data.id===undefined){
                    isReported.value = true;
                }
            }).catch(err => {
                console.log(err);
            });

            const res2 = await axios.post('/api/answer/check-voted', {
                answer_id: answer.value.id,
                user_id: user.value.user.id
            }).then(res => {
                isVoted.value = res.data.vote;
            }).catch(err => {
                console.log(err);
            });

        });


        return {
            answer,
            timeStamp,
            user,
            upvote,
            downvote,
            isReported,
            isVoted,
            report,
        }
    },
    components: {
        TextEditor
    }
}
</script>

<style scoped>

</style>