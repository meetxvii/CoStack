<template>
    <div class="px-2 py-2 w-full md:w-1/2 lg:w-1/3 ">
                    
            <div class="bg-panel-700 hover:bg-blue/30 transition duration-300 text-white/80 font-semibold px-4 py-4 rounded-lg flex relative gap-5 group">
                <div class="w-[20%] h-[100%]">
                    <img :src="`/storage/images/technologies/${technology.image}`" class="w-full h-full object-contain" loading="lazy"/>
                </div>
                <div class="w-[80%]">
                    <router-link :to="{name:'technology', params:{'name':technology.name}}">
                        <div class="heading-3 capitalize hover:underline">
                            {{ technology.name }}
                        </div>
                    </router-link>

                    <div class="text-xs text-white/50 text-description cursor-pointer" @click="toggleDescription">
                        {{ technology.description }}
                    </div>
                </div>
                <div v-if="isAdmin" class="scale-0 group-hover:scale-100 flex items-center transition duration-200 " @click="deleteCard">
                    <i class="fa-solid fa-trash"></i>
                </div>
            </div>
    </div>
</template>

<script>
    import {computed, onMounted, ref} from 'vue';
    export default {
        props: ['technology', 'isAdmin'],
        setup (props, {emit}) {
       
            const technology = computed(() => {
                return props.technology
            })

            const isAdmin = ref(props.isAdmin);

            const deleteCard = () => {
                emit('deleteCard', technology.value.id)
            }
            
            const toggleDescription = (e) => {
                e.target.classList.toggle('text-description')
            }

            return {
                technology,
                toggleDescription,
                deleteCard,
            }
        }
    }
</script>

<style scoped>
.text-description{
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
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