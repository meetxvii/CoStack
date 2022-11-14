<template>
    <div class="min-h-screen w-screen bg-extra-dark-blue">
        <TopHeader />
        <div class="pt-16 md:pt-20">
            <div class="w-full flex justify-center">
                <div class="w-[90vw]">
                    <div class="my-5">
                        <h1 class="heading-1">
                            Technologies
                        </h1>
                        <div class="heading-3">
                            <p class="font-semibold">We have communities for the technologies</p>
                        </div>
                    </div>
                    <TechnologyList />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopHeader from "../components/TopHeader.vue";
import TechnologyList from "../components/TechnologyList.vue";
export default {
    setup () {
        
        return {}
    },
    components: {
        TechnologyList,
        TopHeader
    }
}
</script>

<style scoped>

</style>