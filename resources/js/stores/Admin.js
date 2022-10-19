import { defineStore } from "pinia";
export const useAdmin = defineStore('Admin',{
    state: () => {
        return {
            isLoggedIn: false,
            info: null,
        }
    },
})