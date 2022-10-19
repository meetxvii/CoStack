<template>
    <div>
        <div class=" flex  flex-wrap" v-auto-animate>
            <template v-for="technology in technologies" :key="technology.id" >
                <TechnologyCard :technology="technology" :isAdmin="isAdmin" @deleteCard="deleteCard" />
            </template>
        </div>        
    </div>
</template>

<script>
    import { onMounted, reactive, toRefs, ref, computed } from 'vue'
    import TechnologyCard from './TechnologyCard.vue'
    import { useAdmin } from "../stores/Admin";

    export default {
        setup (props, {emit}) {

            const technologies = ref({})
            const totalTechnologies = ref(0)
            const getTechnologies = async() => {
                const res = await axios.get('/api/technologies')
                .then(res => {
                    totalTechnologies.value = res.data.technologies.length;
                    technologies.value = res.data.technologies;
                    emit('updateLength', totalTechnologies.value)
                })
                .catch(err => {
                    console.log(err);
                })
            }

            
            const isAdmin = ref(false);
            onMounted(() => {
                getTechnologies();
                isAdmin.value = useAdmin().isLoggedIn;
            })
            
            const deleteCard = async(id) => {
                const res = await axios.post('/api/admin/delete-technology', {
                    'id': id
                }).then(res => {
                    
                    if(res.data.message === 'success'){
                        technologies.value = res.data.technologies;
                        totalTechnologies.value = res.data.technologies.length;
                        emit('updateLength', totalTechnologies.value)
                    }
                }).catch(err => {
                    console.log(err);
                })
            }
                
            return {
                getTechnologies,
                technologies,
                totalTechnologies,
                isAdmin,
                deleteCard,           
            }
        },
        components: {
            TechnologyCard
        }
    }
</script>

<style scoped>

</style>