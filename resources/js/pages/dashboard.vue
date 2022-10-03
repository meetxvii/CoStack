
<template>
    <div>
        <TopHeader/>        
    </div>
    <div id="contentview" class="bg-dark-blue py-10 px-20 min-h-screen">
        

        <Tiptap v-model="editorContent" />
        {{editorContent}}
        <div v-html="editorContent">

        </div>
        
    </div>
</template>
<script >
    import { reactive, ref, toRefs, onMounted } from 'vue';
    import TopHeader from '../components/TopHeader.vue';
    import { useUser } from '../stores/User';
    import axios from 'axios';
    import Tiptap from '../components/Tiptap.vue';
    import {CheckLogin} from '../composables/CheckLogin';
    export default {
        name: 'dashboard',
        setup(){
            const user = useUser();
            const editorContent = ref('');
            onMounted(()=>{
                CheckLogin();
            })
            
            
            return {
                user,
                editorContent                                             
            }
        },
        components:{
            TopHeader,
            Tiptap
        }
        
    }

</script>
<style scoped>
    
</style>