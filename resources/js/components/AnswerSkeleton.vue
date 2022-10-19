<template>
    <div class="w-full">
        <div class="bg-blue/20 px-5 py-4 rounded-lg flex gap-4 ">
            <div>
                <div class="animate-pulse">
                    <i class="fa-solid fa-chevron-up text-white/50"></i>
                </div>
                <div class="animate-pulse">
                    <i class="fa-solid fa-chevron-down text-white/50"></i>
                </div>
            </div>
            <div class="w-full">
                <div class="flex flex-col gap-2">
                    <div class="w-full bg-blue/20 py-4 rounded-md animate-pulse">
                    </div>
                    <div class="w-full bg-blue/20 py-10 rounded-md animate-pulse">
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="w-24 py-4 bg-blue/20 rounded-lg"></div>
                        <div class="w-24 py-4 bg-blue/20 rounded-lg ml-auto"></div>
                        <div class="w-24 py-4 bg-blue/20 rounded-lg"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    setup () {
        

        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>