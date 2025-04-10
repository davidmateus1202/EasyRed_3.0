import axios from "axios";
import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        user: null
    }),

    actions: {
        // login user
        async login(email, password) {
            try {
                const response = await axios.post(
                    '/api/v1/auth/login',
                    {
                        email: email,
                        password: password
                    },
                )

                if (response.status === 200) {
                    this.user = response.data.data.user;
                    localStorage.setItem("token", response.data.data.token);
                    return true;
                } else {
                    return false;
                }

            } catch (error) {
                console.error("Error logging in:", error);
                return false;
            }
        }
    },
    persist: true,
})