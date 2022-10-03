<template>
    
    <div>
        <div class="border-white border-2 rounded-xl py-2">
            <div class="md:mx-6 flex gap-2 text-white pb-2">

                
                <div class="flex items-center">
                    <div>
                        <button class=" px-2.5 py-1 rounded-md text-lg "  @click="editor.chain().focus().toggleBold().run()" >
                            <i class="ri-bold"></i>    
                        </button>
                    </div>
                    
                </div>
                

                <div class="flex items-center">
                    <div class="w-[2px] h-5 bg-white/20"></div>
                </div>

                <div class="flex items-center">
                    <div>
                        <button class=" px-2.5 py-1 rounded-md text-lg  " :class="{
                            'bg-blue/30': heading === 'h1',
                            'text-blue': heading === 'h1',

                        }" @click="editor.chain().focus().toggleHeading({level:1}).run(),heading='h1'" >
                            <i class="ri-h-1"></i>                  
                        </button>
                    </div>
                    <div>
                        <button class="px-2.5 py-1 rounded-md text-lg hover:text-blue" :class="{
                            'bg-blue/30': heading === 'h2',
                            'text-blue': heading === 'h2',
                        }" @click="editor.chain().focus().toggleHeading({level:2}).run(),heading='h2'" >
                            <i class="ri-h-2"></i>                  
                        </button>
                    </div>
                    <div>
                        <button class="px-2.5 py-1 rounded-md text-lg" :class="{
                            'bg-blue/30': heading === 'p',
                            'text-blue': heading === 'p',
                        }" @click="editor.chain().focus().setParagraph().run(),heading='p'" >
                            <i class="ri-paragraph"></i>                 
                        </button>
                    </div>
                </div>
            </div>
            <hr class="md:mx-6">
            <div class="text-white bg-blue/20 md:mx-6 rounded-xl my-4">
                <editor-content :editor="editor"/>
            </div>
        </div>
    </div>
</template>
  
<script>
    import StarterKit from '@tiptap/starter-kit'
    import { Editor, EditorContent } from '@tiptap/vue-3'
    import Heading from '@tiptap/extension-heading'
    import Paragraph from '@tiptap/extension-paragraph'
    
    export default {
        components: {
            EditorContent,
        },
    
        props: {
            modelValue: {
                type: String,
                default: '',
            },
        },
  
        emits: ['update:modelValue'],
  
        data() {
            return {
                heading: 'p',
                style:"",
                editor: null,
            }
        },

        

  
        watch: {
            
            modelValue(value) {
                // HTML
                const isSame = this.editor.getHTML() === value
        
                // JSON
                // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)
        
                if (isSame) {
                return
                }
        
                this.editor.commands.setContent(value, false)
            },
        },
  
        mounted() {
            this.editor = new Editor({
                extensions: [
                    StarterKit,
                    Heading.configure({
                        levels: [1, 2],
                        //add tailwind css to style heading
                        

                    }),
                ],
                content: this.modelValue,
                onUpdate: () => {
                // HTML
                    this.$emit('update:modelValue', this.editor.getHTML())
        
                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
                },
            })
        },
  
        beforeUnmount() {
            this.editor.destroy()
        },
    }
</script>
<style >
    .ProseMirror  {
        min-height: 150px;
        outline: none;
        padding: 1rem;
    }
</style>