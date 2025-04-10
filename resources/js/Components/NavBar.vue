<template>
    <div class="flex w-full h-16 items-center justify-between px-2  md:px-10 py-5 bg-white">
        <!-- seccion search -->
        <div class="flex w-auto h-auto items-center">
            <h1 class="hidden sm:block text-gray-600 font-extrabold text-xl">EasyRed</h1>
            <div class="flex w-full h-full bg-gray-100 ml-5 p-3 rounded-3xl items-center">
                <i class="pi pi-search text-gray-600 mr-2"></i>
                <input type="text" placeholder="Buscar" class="outline-none">
            </div>
        </div>

        <!-- navigation -->
        <div class="hidden lg:flex w-auto h-auto items-center gap-10">
            <div class="flex items-center bg-gray-100 p-2 rounded-lg cursor-pointer hover:bg-gray-200 transition duration-300 ease-in-out">
                <i class="pi pi-home text-blue-500" style="font-size: 1.5rem;"></i>
                <h3 class="text-gray-400 ml-2 font-semibold text-sm">Home</h3>
            </div>
            <div class="flex items-center">
                <i class="pi pi-bell text-gray-300" style="font-size: 1.5rem;"></i>
            </div>
            <div class="flex items-center">
                <i class="pi pi-inbox text-gray-300" style="font-size: 1.5rem;"></i>
            </div>
        </div>

        <!-- user profile -->
        <div class="flex w-auto h-auto items-center gap-5 cursor-pointer">
            <h3 class="hidden md:block">{{ user.user?.email ?? '' }}</h3>
            <img @click="logout" :src="user.user?.photo !== null ? user.user?.photo : 'https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg'" class="min-w-10 w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
        </div>
    </div>
</template>

<script setup>
import { useUserStore } from '../Store/UserStore.js'
import { useRouter } from 'vue-router'

const user = useUserStore()
const router = useRouter()

const logout = () => {
    localStorage.removeItem('token'),
    router.push('/login')
}

</script>