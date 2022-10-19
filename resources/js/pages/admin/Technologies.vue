<template>
    <div class="bg-extra-dark-blue min-h-screen" >
        <Sidebar />
        <div class="bg-black/10 backdrop-blur-sm min-h-screen min-w-[100vw] z-50 fixed top-0 left-0 flex justify-center items-center" v-if="openAddDialog">
            <div class="absolute top-4 right-4 text-xl ">
                
                <div class="bg-white/50 rounded-lg w-8 h-8 text-white hover:text-red-400 hover:bg-white cursor-pointer transition duration-500" @click="openAddDialog = false, reloadAddForm()">
                    <button  class=" absolute top-[50%] left-[50%] -translate-x-[50%] -translate-y-[50%]">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="w-[80%] md:w-[50%] bg-panel-700 border-2 border-blue/20 rounded-lg flex flex-col px-10 py-5">
                <transition name="slide-up" mode="out-in">
                    <div v-if="addTechStatus === ''">
                        <div class="w-full">
                            <h1 class="heading-2 text-center">Add New Technology</h1>
                        </div>
                        <form @submit.prevent="addTechnology">
                            <div>
                                <div class="my-4">
                                    <div>
                                        <div class="relative z-0">
                                            <input type="text" v-model="name" id="name" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                            :class="{
                                                'border-red-600': !isNameValid,
                                                'dark:border-red-500': !isNameValid,
                                                'dark:focus:border-red-500': !isNameValid,
                                                'focus:border-red-600': !isNameValid,
                                                'border-white': isNameValid,
                                                'dark:border-white': isNameValid,
                                                'dark:focus:border-white': isNameValid,
                                                'focus:border-white': isNameValid,
                                            }"
                                            
                                            />
                                            <label for="name" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                            :class="{
                                                'text-red-600': !isNameValid,
                                                'dark:text-red-500': !isNameValid,
                                                'text-white' : isNameValid,
                                                'dark:text-white' : isNameValid,
                                            }"
                                            >Title</label>
                                        </div>
                                        <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                            'text-red-600' : !isNameValid,
                                            'dark:text-red-400' : !isNameValid,
                                            'text-white': isNameValid,
                                            'dark:text-white': isNameValid
                                        }"
                                        v-show="!isNameValid"
                                        >{{NameMessage}}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="my-4">
                                    <div>
                                        <div class="relative z-0">
                                            <textarea rows="1"  v-model="description" id="description" autocomplete="off" autofocus aria-describedby="standard_error_help" class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2  appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                                            :class="{
                                                'border-red-600': !isDescValid,
                                                'dark:border-red-500': !isDescValid,
                                                'dark:focus:border-red-500': !isDescValid,
                                                'focus:border-red-600': !isDescValid,
                                                'border-white': isDescValid,
                                                'dark:border-white': isDescValid,
                                                'dark:focus:border-white': isDescValid,
                                                'focus:border-white': isDescValid,
                                            }"
                                            
                                            ></textarea>
                                            <label for="description" class="absolute text-sm  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                            :class="{
                                                'text-red-600': !isDescValid,
                                                'dark:text-red-500': !isDescValid,
                                                'text-white' : isDescValid,
                                                'dark:text-white' : isDescValid,
                                            }"
                                            >Description</label>
                                        </div>
                                        <p id="standard_error_help" class="mt-2 text-xs " :class="{
                                            'text-red-600' : !isDescValid,
                                            'dark:text-red-400' : !isDescValid,
                                            'text-white': isDescValid,
                                            'dark:text-white': isDescValid
                                        }"
                                        v-show="!isDescValid"
                                        >{{DescMessage}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="my-4">
                                <div class=" py-2 px-2 rounded-md flex items-center justify-start cursor-pointer gap-2 border-2" :class="{
                                    'border-blue/20' : isIconValid,
                                    'border-red-600/40' : !isIconValid,
                                    'bg-blue/20' : isIconValid,
                                    'bg-red-600/40' : !isIconValid,
                                }" @click="addIconFile.click()">
                                    <div>
                                        <img src="../../../img/image placeholder.png" class="w-20 h-20 object-contain" ref="addPrevIcon" />
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <label class="text-white  cursor-pointer heading-3 text-lg " >{{addIconLabel}}</label>
                                        <input type="file" ref="addIconFile" accept=".svg,.png,.jpg" id="icon"  @input="FileChange" class="hidden" />
                                    </div>
                                </div>
                            </div>

                            <div class="my-4 w-full">
                                <input type="submit" class="bg-blue w-full py-4 rounded-md text-white text-lg hover:scale-95 transition duration-200" value="Add Technology">                        
                            </div>

                        </form>
                    </div>
                    <div v-else-if="addTechStatus === 'success'" class="flex min-h-[50vh] flex-col justify-center items-center text-blue gap-10 animate-pulse">
                        <i class="fa-solid fa-circle-check text-8xl"></i>
                        <h1 class="heading-3 text-blue">Technology Added Successfully</h1>
                    </div>
                    <div v-else-if="addTechStatus === 'failed'" class="flex min-h-[50vh] flex-col justify-center items-center text-yellow-500 gap-10 animate-pulse">
                        
                        <i class="fa-solid fa-circle-exclamation text-8xl"></i>
                        <h1 class="heading-3 text-yellow-500">Failed to Add Technology</h1>
                    </div>
                </transition>
            </div>
        </div>
        <div class="text-white md:ml-20 px-4 pt-4">
            <div>
                <div class="my-2">
                    <h1 class="heading-2 text-blue/70">Manage Technologies</h1>
                </div>
                <div class="my-2 flex justify-evenly">
                    <div class="group bg-white/10 w-[40%] flex items-center justify-center gap-2 text-lg py-4 rounded-xl cursor-default">
                        <span>{{techLenght ?? 0}}</span>
                        <div>Total Technologies</div>
                    </div>
                    <div class="group border-2 bg-blue/50 border-white/40 w-[40%] flex items-center justify-center gap-2 text-lg py-4 rounded-xl cursor-pointer hover:scale-95 transition duration-200 hover:bg-blue" @click="openAddDialog = !openAddDialog" >
                        <i class="fas fa-plus"></i>
                        <div>Add Technology</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="py-5">
                    <TechnologyList ref="techList" @updateLength = "(len)=>{techLenght=len}" />
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    import {onMounted, reactive, ref, toRefs } from 'vue'
    import Sidebar from './components/Sidebar.vue'
    import axios from 'axios';
    import TechnologyList from '../../components/TechnologyList.vue'

    export default {
        setup(){

            
            // add technology
            const addTechStatus = ref('');
            const addPrevIcon = ref(null); 
            const addIconFile = ref(null);
            const addIconLabel = ref('Upload Icon');
            const openAddDialog = ref(false);
            
            const form = reactive({
                name: '',
                description: '',
                logo: null,
            })
            const validation = reactive({
                isNameValid: true,
                NameMessage: '',
                isDescValid: true,
                DescMessage: '',
                isIconValid: true,
            })
            
            
            const FileChange = (e) => {
                const file = e.target.files[0];
                addIconLabel.value = file.name
                addPrevIcon.value.src = URL.createObjectURL(file)
                form.logo = file
                validation.isIconValid = true
            }
            const reloadAddForm = () => {
                addTechStatus.value = '';
                form.name = '';
                form.description = '';
                form.logo = null;
                addIconLabel.value = 'Upload Icon';
                addPrevIcon.value.src = '../../../img/image placeholder.png';
            }

            const validateForm = () => {
                if(form.name == ''){
                    validation.isNameValid = false;
                    validation.NameMessage = 'Title is required';
                }else{
                    validation.isNameValid = true;
                    validation.NameMessage = '';
                }
                if(form.description == ''){
                    validation.isDescValid = false;
                    validation.DescMessage = 'Description is required';
                }else{
                    validation.isDescValid = true;
                    validation.DescMessage = '';
                }
                if(form.logo === null){
                    validation.isIconValid = false;
                }else{
                    validation.isIconValid = true;
                }
            }

            const addTechnology = async(e) => {
                validateForm();
                if(!validation.isNameValid || !validation.isDescValid || !validation.isIconValid){
                    return;
                }

                const res = await axios.post('/api/admin/add-technology', form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(res => {
                    if(res.data.message == 'success'){
                        addTechStatus.value = 'success';
                        setTimeout(() => {
                            openAddDialog.value = false;
                            addTechStatus.value = '';
                            techList.value.getTechnologies();
                            reloadAddForm();
                        }, 1000);
                    }
                })
                .catch(err => {
                    
                    addTechStatus.value = 'failed';
                    setTimeout(() => {
                        openAddDialog.value = false;
                        addTechStatus.value = '';
                        reloadAddForm();
                    }, 2000);

                })
            }
            
            const techList = ref();
            const techLenght = ref(0);
            

            return {
                openAddDialog,
                addPrevIcon,
                addIconFile,
                addIconLabel,
                ...toRefs(form),
                ...toRefs(validation),
                FileChange,
                reloadAddForm,
                addTechnology,
                addTechStatus,
                techList,
                techLenght,
            }
        },
        components: {
            Sidebar,
            TechnologyList,
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