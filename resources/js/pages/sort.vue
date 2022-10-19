<template>
    <div>
        <div>
            <div class="w-full flex md:justify-end">
                <div class="bg-blue/20 flex flex-col md:flex-row w-full md:w-[50%] gap-4 px-5 py-3 rounded-lg">
                    <div class="flex overflow-hidden w-full">
                        <transition name="slide-up" mode="out-in">
                            <div class="text-white/90 flex items-end justify-between w-full " v-if="showSearchBar===false">
                                <!-- sort div -->
                                <div>
                                    <div class="mb-2 text-sm">
                                        <span>Sort By</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-32 px-2 py-1 bg-blue/20 rounded-full cursor-pointer overflow-hidden flex justify-center" :class="{
                                            'text-blue': sortby === 'upvote' || sortby === 'downvote',
                                            'bg-white': sortby === 'upvote' || sortby === 'downvote',
                                            'text-white/90': sortby !== 'upvote' && sortby !== 'downvote'
                                        }">
                                            <!-- upvote -->
                                            <transition name="slide-up" mode="out-in">
                                                <div v-if="sortby!=='downvote' || sortby==='default'" class="flex items-center gap-2" @click="sortby='downvote'">
                                                    <i class="fa-solid fa-chevron-up"></i>
                                                    <span>Upvote</span>
                                                </div>
                                                <div v-else-if="sortby==='downvote'" class="flex items-center gap-2" @click="sortby='upvote'">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                    <span>Downvote</span>
                                                </div>
                                            </transition>
                                        </div>
                                        <div class="w-36 px-2 py-1 bg-blue/20 rounded-full cursor-pointer overflow-hidden flex justify-center" :class="{
                                            'text-blue': sortby === 'latest' || sortby === 'oldest',
                                            'bg-white': sortby === 'latest' || sortby === 'oldest',
                                            'text-white/90': sortby !== 'latest' && sortby !== 'oldest'
                                        }">
                                            <!-- upvote -->
                                            <transition name="slide-up" mode="out-in">
                                                <div v-if="sortby!=='oldest' || sortby==='default'" class="flex items-center gap-2" @click="sortby='oldest'">
                                                    <i class="fa-solid fa-chevron-up"></i>
                                                    <span>Latest First</span>
                                                </div>
                                                <div v-else-if="sortby==='oldest'" class="flex items-center gap-2" @click="sortby='latest'">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                    <span>Oldest First</span>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="bg-blue/20 py-2 px-4 text-white rounded-xl" @click="showSearchBar=true">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex w-full items-end ml-auto" v-else-if="showSearchBar===true">
                                <div class="w-full flex items-center text-white bg-blue/20 px-4 rounded-md">
                                    <div>
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <input type="text" class="bg-transparent text-white/90 px-4 py-2 flex-grow placeholder:text-white outline-none" placeholder="Search..." v-model="searchQuery">
                                    <div>
                                        <button @click="showSearchBar=false">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</template>

<script>
export default {
    setup () {
        const sortby = ref('default')
        const showSearchBar = ref(false);
        const searchQuery = ref('');
        return {
            sortby,
            showSearchBar,
            searchQuery
        }
    }
}
</script>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.25s ease-out;
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
</style>