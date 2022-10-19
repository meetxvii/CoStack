<template>
    <div class="w-full flex flex-col items-center gap-2 justify-center">
        <div class="bg-blue/20 px-5 py-5 w-full md:w-[70%] rounded-lg" v-for="i in 3" :key="i">
            <div class="flex items-start">
                <div class="w-full mx-4">
                    <div class="py-4 bg-blue/40 rounded w-full animate-pulse mb-2">
                    </div>
                    <div class="py-8 bg-blue/40 rounded w-full animate-pulse mb-2">
                    </div>
                    <div class="flex justify-end items-center gap-2">
                        <div class="bg-blue/40 py-2 w-16 animate-pulse">
                        </div>
                        <div class="text-blue/40 text-sm animate-pulse">
                            |
                        </div>
                        <div class="bg-blue/40 py-2 w-16 animate-pulse">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "QuestionsList",
        setup(){
            return {
                
            }
        }  
    }
</script>

<style scoped>

</style>