<template>
    <div class="rounded-lg bg-blue/20"> 
        <QuillEditor :theme="theme" :options="options" :contentType="contentType" :readOnly="readonly" v-model:content="textData"  />         
    </div>
</template>

<script>
import { reactive, toRefs, ref } from 'vue'


import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import '@vueup/vue-quill/dist/vue-quill.bubble.css';

export default {
    props:{
        'contentType' : {
            type: String,
            default: 'text'
        },
        'content' : {
            type: String,
            default: ''
        },
        'readonly' : {
            type: Boolean,
            default: false
        },
        'theme' : {
            type: String,
            default: 'snow'
        },
        heigth: {
            type: String,
            default: '200px'
        }

    },
    methods:{
        forceUpdate(){
            this.$forceUpdate();
        }
    },
    setup (props, context) {

        const options = {
            modules: {
                toolbar: [
                    // [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote','code-block'],
                    [{'list' : 'ordered' },{'list': 'bullet'}],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['clean']
                ]
            },
        }
        const contentType = ref(props.contentType)
        const textData = ref(props.content)
        const readonly = ref(props.readonly)
        const theme = ref(props.theme)
        const heigth = ref(props.heigth)
        const getData = () =>{
            return textData.value
        }
        
        
        return {  
            options,
            contentType,
            textData,
            readonly,
            theme,
            heigth,
            getData,
            
        }
    },
    components: {
        QuillEditor
    }
}
</script>

<style >

    .ql-editor{
        color:white;
    }
    .ql-toolbar.ql-snow *{
        color:white !important;
        stroke: white !important;
    }

    .ql-header.ql-picker *{
        background-color: rgba(50 138 241 / 0.2) !important;
    }
    .ql-header .ql-picker-options *{
        color: white !important;
    }
    .ql-formats button{
        background-color: rgba(50 138 241 / 0.2) !important;
        border-radius: 5px;
    }
    .ql-container.ql-snow{
        cursor: text;
    }
    .ql-editor{
        min-height: v-bind(heigth) !important;
    }
    .ql-toolbar.ql-snow,.ql-container.ql-snow{
        
        border:none !important;
        outline: none !important;
    }
    .ql-toolbar.ql-snow{
        border-bottom: 1px solid #e2e8f0 !important;

    }
</style>