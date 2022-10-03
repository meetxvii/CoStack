import { defineStore } from "pinia";
export const useUser = defineStore('User',{
    state: () => {
        return {
            isLoggedIn: false,
            user: null,
        }
    },
})