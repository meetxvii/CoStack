<template>
    <TopHeader />   
    <div class="bg-dark-blue min-h-screen pt-24">
        <div class="w-full h-full flex flex-col gap-5 justify-center items-center">
            <img src="../../img/404.svg" class="w-[40vw]" alt="">
            <button @click="$router.go(-1)" class="bg-blue px-6 py-2 rounded-lg text-white">Go Back</button>
        </div>
    </div>
</template>

<script>
import TopHeader from '../components/TopHeader.vue'
export default {
    setup () {
        

        return {}

    },
    components: {
        TopHeader
    }
}
</script>

<style scoped>

</style>