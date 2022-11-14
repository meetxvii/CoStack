<template>
    <div>
        <TopHeader />
    </div>
    <div class="min-h-screen bg-dark-blue pt-16 md:pt-20">
        <div class="flex flex-col gap-5 justify-center py-5 px-5">
            <div class="w-full text-white">
                <QuestionsList :userID="3" />
            </div>
        </div>

    </div>
</template>

<script>
import {ref} from 'vue'
import { computed, onMounted } from '@vue/runtime-core'
import { useRoute } from 'vue-router'
import axios from 'axios'
import TopHeader from '../components/TopHeader.vue'
import QuestionsList from '../components/QuestionsList.vue';

import {useUser} from '../stores/User'
export default {
    setup () {
        const userID = computed(() => {
            return useRoute().params.id
        })
        const doesOwns = ref(false)
        const isQueLoaded = ref(false)
        return {
            userID,
            isQueLoaded
        }
    },
    components: {
        TopHeader,
        QuestionsList,

    }
}
</script>

<style scoped>

</style>